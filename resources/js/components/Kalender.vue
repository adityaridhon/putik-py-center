<script setup lang="ts">
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';
import { computed, ref } from 'vue';

interface BookedSlot {
    booking_date: string;
    booking_time: string;
    status: string;
}

const props = defineProps<{ isConfirmed?: boolean; bookedSlots?: BookedSlot[] }>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: string): void;
}>();

const selected = ref<string>('');

const currentDate = ref(new Date());
const availableTimes = ['09:30', '13:00', '15:00', '16:30'];

const formatLocalDate = (date: Date) => {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
};

function prevMonth() {
    const d = new Date(currentDate.value);
    d.setMonth(d.getMonth() - 1);
    currentDate.value = d;
}

function nextMonth() {
    const d = new Date(currentDate.value);
    d.setMonth(d.getMonth() + 1);
    currentDate.value = d;
}

const monthYear = computed(() =>
    currentDate.value.toLocaleDateString('id-ID', {
        month: 'long',
        year: 'numeric',
    }),
);

function generateCalendar(date: Date) {
    const year = date.getFullYear();
    const month = date.getMonth();

    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);

    const startDay = (firstDay.getDay() + 6) % 7;
    const totalDays = lastDay.getDate();

    const days = [];

    for (let i = 0; i < startDay; i++) {
        const d = new Date(year, month, -startDay + i + 1);
        days.push({
            value: formatLocalDate(d),
            date: d.getDate(),
            currentMonth: false,
            tersedia: false,
        });
    }

    for (let i = 1; i <= totalDays; i++) {
        const d = new Date(year, month, i);
        days.push({
            value: formatLocalDate(d),
            date: i,
            currentMonth: true,
            tersedia: true,
        });
    }

    return days;
}

const calendarDays = computed(() =>
    generateCalendar(currentDate.value).map((item) => {
        if (!item.currentMonth) {
            return item;
        }

        const confirmedTimes = new Set(
            (props.bookedSlots || [])
                .filter(
                    (slot) =>
                        (slot.status === 'confirmed' ||
                            slot.status === 'completed') &&
                        slot.booking_date === item.value,
                )
                .map((slot) => (slot.booking_time || '').substring(0, 5)),
        );

        const isFull = availableTimes.every((time) => confirmedTimes.has(time));

        return {
            ...item,
            tersedia: !isFull,
        };
    }),
);

function pilih(item: any) {
    if (!item.tersedia || !item.currentMonth || props.isConfirmed) return;
    selected.value = item.value;
    emit('update:modelValue', item.value);
}
</script>

<template>
    <div class="space-y-4 rounded-xl border bg-white p-4 sm:p-5 md:p-6">
        <h2 class="font-semibold text-green-800">Pilih Jadwal</h2>

        <div class="flex items-center justify-between">
            <button class="rounded p-1 hover:bg-slate-100" @click="prevMonth">
                <ChevronLeft class="h-5 w-5" />
            </button>

            <p class="text-sm font-medium capitalize sm:text-base">
                {{ monthYear }}
            </p>

            <button class="rounded p-1 hover:bg-slate-100" @click="nextMonth">
                <ChevronRight class="h-5 w-5" />
            </button>
        </div>

        <div
            class="grid grid-cols-7 text-center text-[10px] font-medium text-gray-600 sm:text-xs md:text-sm"
        >
            <div>Sen</div>
            <div>Sel</div>
            <div>Rab</div>
            <div>Kam</div>
            <div>Jum</div>
            <div>Sab</div>
            <div>Min</div>
        </div>

        <div class="grid grid-cols-7 text-center text-xs sm:text-sm">
            <div
                v-for="item in calendarDays"
                :key="item.value"
                @click="pilih(item)"
                :class="[
                    'flex aspect-square items-center justify-center border p-1 text-xs sm:p-2 sm:text-sm',
                    !item.currentMonth && 'bg-gray-50 text-gray-300',
                    item.currentMonth && item.tersedia && 'cursor-pointer',
                    item.currentMonth &&
                        !item.tersedia &&
                        'cursor-not-allowed bg-gray-200 text-gray-400',
                    selected === item.value &&
                        !props.isConfirmed &&
                        'bg-primary text-white ring-2 ring-primary',
                ]"
            >
                {{ item.date }}
            </div>
        </div>

        <div class="flex flex-wrap gap-4 pt-2 text-xs sm:gap-6 sm:text-sm">
            <span class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-full bg-primary"></span>
                Tersedia
            </span>
            <span class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-full bg-gray-200"></span>
                Penuh
            </span>
        </div>
    </div>
</template>
