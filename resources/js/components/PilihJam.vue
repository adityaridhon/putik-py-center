<script setup lang="ts">
import { ref, watch } from 'vue';

const props = defineProps<{ isConfirmed?: boolean }>();
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

const jamList = ref<JamItem[]>(defaultJamList.map((slot) => ({ ...slot })));

const resetAvailability = () => {
    jamList.value = defaultJamList.map((slot) => ({ ...slot }));
};

const disableSlot = (selectedTime: string) => {
    const index = jamList.value.findIndex(
        (slot) => slot.waktu === selectedTime,
    );
    if (index !== -1) {
        jamList.value[index] = {
            ...jamList.value[index],
            tersedia: false,
        };
    }
};

watch(
    () => props.isConfirmed,
    (confirmed) => {
        if (confirmed && jam.value) {
            disableSlot(jam.value);
        } else if (!confirmed) {
            resetAvailability();
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
    <div class="flex gap-4">
        <button
            v-for="j in jamList"
            :key="j.waktu"
            @click="pilih(j)"
            :class="[
                'rounded border px-4 py-2 text-sm font-medium transition',

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
</template>
