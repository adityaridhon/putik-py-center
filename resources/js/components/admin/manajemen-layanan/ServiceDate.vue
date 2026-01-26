<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';

import { Calendar } from '@/components/ui/calendar';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { CalendarDate } from '@internationalized/date';
import { SquarePen } from 'lucide-vue-next';

const datacard = [
    {
        title: 'Artikel Draft',
        value: '12',
        icon: SquarePen,
    },
];

const schedules = [
    {
        id: 1,
        jam: '10:00',
        status: 'Tersedia',
    },
    {
        id: 2,
        jam: '16:00',
        status: 'Terisi',
    },
    {
        id: 3,
        jam: '18:00',
        status: 'Batal',
    },
];

const getStatusVariant = (status: string) => {
    switch (status) {
        case 'Tersedia':
            return 'default';
        case 'Terisi':
            return 'secondary';
        case 'Batal':
            return 'destructive';
        default:
            return 'outline';
    }
};
</script>

<template>
    <div class="grid gap-4 md:grid-cols-3">
        <div
            class="col-span-1 overflow-hidden rounded-lg border border-gray-200 shadow-sm"
        >
            <Calendar
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
                        <TableHead
                            class="w-32 text-center font-semibold text-white"
                            >Jam</TableHead
                        >
                        <TableHead class="text-center font-semibold text-white">
                            Status
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow
                        v-for="schedule in schedules"
                        :key="schedule.id"
                        class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                    >
                        <TableCell class="text-center font-semibold">
                            {{ schedule.jam }}
                        </TableCell>

                        <TableCell class="w-32 text-center">
                            <Badge :variant="getStatusVariant(schedule.status)">
                                {{ schedule.status }}
                            </Badge>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </div>
</template>
