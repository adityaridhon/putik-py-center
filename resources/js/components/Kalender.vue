<script setup lang="ts">
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

const props = defineProps<{ isConfirmed?: boolean }>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: string): void;
}>();

const selected = ref<string>('');

const currentDate = ref(new Date());
const confirmedDates = ref<Record<string, boolean>>({});

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
            value: d.toISOString().split('T')[0],
            date: d.getDate(),
            currentMonth: false,
            tersedia: false,
        });
    }

    for (let i = 1; i <= totalDays; i++) {
        const d = new Date(year, month, i);
        days.push({
            value: d.toISOString().split('T')[0],
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

        return {
            ...item,
            tersedia: !confirmedDates.value[item.value],
        };
    }),
);

function pilih(item: any) {
    if (!item.tersedia || !item.currentMonth || props.isConfirmed) return;
    selected.value = item.value;
    emit('update:modelValue', item.value);
}

watch(
    () => props.isConfirmed,
    (confirmed) => {
        if (confirmed && selected.value) {
            confirmedDates.value = {
                ...confirmedDates.value,
                [selected.value]: true,
            };
        } else if (!confirmed) {
            confirmedDates.value = {};
        }
    },
    { immediate: true },
);
</script>

<template>
    <div class="space-y-4 rounded-xl border bg-white p-6">
        <h2 class="font-semibold text-green-800">Pilih Jadwal</h2>

        <div class="flex items-center justify-between">
            <button @click="prevMonth">
                <ChevronLeft class="h-5 w-5" />
            </button>

            <p class="font-medium capitalize">
                {{ monthYear }}
            </p>

            <button @click="nextMonth">
                <ChevronRight class="h-5 w-5" />
            </button>
        </div>

        <div
            class="grid grid-cols-7 text-center text-sm font-medium text-gray-600"
        >
            <div>Sen</div>
            <div>Sel</div>
            <div>Rab</div>
            <div>Kam</div>
            <div>Jum</div>
            <div>Sab</div>
            <div>Min</div>
        </div>

        <div class="grid grid-cols-7 text-center text-sm">
            <div
                v-for="item in calendarDays"
                :key="item.value"
                @click="pilih(item)"
                :class="[
                    'border p-2 text-sm',
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

        <div class="flex gap-6 pt-2 text-sm">
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
