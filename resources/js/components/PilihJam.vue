<script setup lang="ts">
import { computed, watch } from 'vue';

interface BookedSlot {
    booking_date: string;
    booking_time: string;
    status: string;
}

const props = defineProps<{
    isConfirmed?: boolean;
    selectedDate?: string;
    bookedSlots?: BookedSlot[];
}>();
const emit = defineEmits(['update:modelValue']);

const jam = defineModel<string>('modelValue');

interface JamItem {
    waktu: string;
    tersedia: boolean;
}

const defaultJamList: JamItem[] = [
    { waktu: '09:30', tersedia: true },
    { waktu: '13:00', tersedia: true },
    { waktu: '15:00', tersedia: true },
    { waktu: '16:30', tersedia: true },
];

const bookedTimes = computed(() => {
    const date = props.selectedDate;

    if (!date) {
        return new Set<string>();
    }

    return new Set(
        (props.bookedSlots || [])
            .filter(
                (slot) =>
                    (slot.status === 'confirmed' ||
                        slot.status === 'completed') &&
                    slot.booking_date === date,
            )
            .map((slot) => (slot.booking_time || '').substring(0, 5)),
    );
});

const isToday = computed(() => {
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    if (!props.selectedDate) return false;

    const selectedDate = new Date(props.selectedDate);
    selectedDate.setHours(0, 0, 0, 0);

    return today.getTime() === selectedDate.getTime();
});

const currentTime = computed(() => {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    return `${hours}:${minutes}`;
});

const jamList = computed<JamItem[]>(() =>
    defaultJamList.map((slot) => {
        // Check if time has passed today
        let isPastTime = false;
        if (isToday.value) {
            isPastTime = slot.waktu <= currentTime.value;
        }

        return {
            ...slot,
            tersedia: !bookedTimes.value.has(slot.waktu) && !isPastTime,
        };
    }),
);

watch(
    [() => props.selectedDate, jamList],
    () => {
        if (!jam.value) {
            return;
        }

        const selectedStillAvailable = jamList.value.some(
            (slot) => slot.waktu === jam.value && slot.tersedia,
        );

        if (!selectedStillAvailable) {
            jam.value = '';
            emit('update:modelValue', '');
        }
    },
    { immediate: true },
);

function pilih(j: JamItem) {
    if (!j.tersedia || props.isConfirmed) return;
    jam.value = j.waktu;
    emit('update:modelValue', j.waktu);
}
</script>

<template>
    <div class="space-y-3">
        <p class="text-sm font-semibold text-primary">Pilih Jam</p>

        <div class="grid grid-cols-2 gap-2 sm:flex sm:flex-wrap sm:gap-3">
            <button
                v-for="j in jamList"
                :key="j.waktu"
                @click="pilih(j)"
                :class="[
                    'w-full rounded border px-3 py-2 text-sm font-medium transition sm:w-auto sm:px-4',

                    // kalau tidak tersedia FULL (abu-abu)
                    !j.tersedia
                        ? 'cursor-not-allowed border-gray-200 bg-gray-200 text-gray-500'
                        : // Kalau tersedia dan sedang dipilih
                          j.waktu === jam
                          ? 'border-primary bg-primary text-white'
                          : 'border-green-200 bg-white text-primary hover:border-green-400 hover:text-green-800',
                ]"
            >
                {{ j.tersedia ? j.waktu : 'FULL' }}
            </button>
        </div>
    </div>
</template>
