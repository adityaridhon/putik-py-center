<script setup lang="ts">
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { computed, ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { toast } from '@/composables/useToast';

import { Calendar } from '@/components/ui/calendar';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { CalendarDate, getLocalTimeZone, today } from '@internationalized/date';

const props = defineProps<{ bookings?: any[] }>();

const selectedDate = ref(today(getLocalTimeZone()));
const updatingId = ref<number | null>(null);

// Format date into YYYY-MM-DD
const formattedDate = computed(() => {
    if (!selectedDate.value) return '';
    const y = selectedDate.value.year;
    const m = String(selectedDate.value.month).padStart(2, '0');
    const d = String(selectedDate.value.day).padStart(2, '0');
    return `${y}-${m}-${d}`;
});

const schedules = computed(() => {
    if (!props.bookings) return [];

    return props.bookings
        .filter((b) => b.booking_date === formattedDate.value)
        .map((b) => {
            // substring(0, 5) converts "15:00:00" -> "15:00"
            const jam = b.booking_time ? b.booking_time.substring(0, 5) : '';

            return {
                id: b.id,
                jam: jam,
                nama: b.customer_name,
                layanan: b.service_category,
                status: b.status,
            };
        });
});

const getStatusLabel = (status: string) => {
    switch (status) {
        case 'pending':
            return 'Menunggu';
        case 'confirmed':
            return 'Booked';
        case 'completed':
            return 'Selesai';
        case 'cancelled':
            return 'Batal';
        default:
            return 'Menunggu';
    }
};

const getStatusOptions = (currentStatus: string) => {
    if (currentStatus === 'pending') {
        return [
            { value: 'confirmed', label: 'Booked' },
            { value: 'cancelled', label: 'Batal' },
        ];
    }

    if (currentStatus === 'confirmed') {
        return [
            { value: 'completed', label: 'Selesai' },
            { value: 'cancelled', label: 'Batal' },
        ];
    }

    if (currentStatus === 'completed') {
        return [{ value: 'completed', label: 'Selesai' }];
    }

    return [{ value: 'cancelled', label: 'Batal' }];
};

const updateStatus = (bookingId: number, value: string) => {
    if (!['pending', 'confirmed', 'completed', 'cancelled'].includes(value)) {
        return;
    }

    const currentBooking = schedules.value.find((item) => item.id === bookingId);
    if (currentBooking?.status === value) {
        return;
    }

    updatingId.value = bookingId;

    router.put(
        `/admin/bookings/${bookingId}/status`,
        { status: value },
        {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Status booking berhasil diperbarui.');
            },
            onError: (errors) => {
                const message =
                    (errors?.status as string) ||
                    'Gagal memperbarui status booking. Silakan coba lagi.';
                toast.error(message);
            },
            onFinish: () => {
                updatingId.value = null;
            },
        },
    );
};
</script>

<template>
    <div class="grid gap-4 md:grid-cols-3">
        <div
            class="col-span-1 overflow-hidden rounded-lg border border-gray-200 shadow-sm"
        >
            <Calendar
                v-model="selectedDate"
                layout="month-and-year"
                :min-value="new CalendarDate(2025, 1, 1)"
                :max-value="new CalendarDate(2035, 1, 1)"
            />
        </div>
        <div
            class="col-span-2 overflow-hidden rounded-lg border border-gray-200 shadow-sm"
        >
            <Table>
                <TableHeader class="bg-primary">
                    <TableRow class="border-0 hover:bg-transparent">
                        <TableHead class="w-32 text-center font-semibold text-white">Jam</TableHead>
                        <TableHead class="font-semibold text-white">Nama Pemesan</TableHead>
                        <TableHead class="font-semibold text-white">Kategori</TableHead>
                        <TableHead class="text-center font-semibold text-white">Status</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-if="schedules.length === 0">
                        <TableCell colspan="4" class="h-24 text-center text-gray-500">
                            Tidak ada jadwal untuk tanggal ini.
                        </TableCell>
                    </TableRow>
                    <TableRow
                        v-for="schedule in schedules"
                        :key="schedule.id"
                        class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                    >
                        <TableCell class="text-center font-semibold">
                            {{ schedule.jam }}
                        </TableCell>
                        <TableCell>
                            {{ schedule.nama }}
                        </TableCell>
                        <TableCell class="capitalize">
                            {{ schedule.layanan.replaceAll('_', ' ') }}
                        </TableCell>
                        <TableCell class="w-32 text-center">
                            <Select
                                :model-value="schedule.status"
                                @update:modelValue="(value) => updateStatus(schedule.id, String(value))"
                                :disabled="updatingId === schedule.id"
                            >
                                <SelectTrigger class="h-9 w-36">
                                    <SelectValue :placeholder="getStatusLabel(schedule.status)" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem
                                        v-for="option in getStatusOptions(schedule.status)"
                                        :key="`${schedule.id}-${option.value}`"
                                        :value="option.value"
                                    >
                                        {{ option.label }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </div>
</template>
