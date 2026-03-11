<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';
import { User } from 'lucide-vue-next';
import { computed } from 'vue';

import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';

// Props dari parent (backend)
const props = defineProps<{
    user: {
        id: number;
        nama: string;
        email: string;
        created_at: string;
    };
    testHistory: any[];
}>();

// Default data jika backend tidak ada
const defaultHistory = [
    {
        id: 1,
        token: 'ABC123',
        jenis_tes: 'Tes Kepribadian',
        tanggal: '2024-06-01',
        status: 'Selesai',
    },
    {
        id: 2,
        token: 'DEF456',
        jenis_tes: 'Tes Kecerdasan Emosional',
        tanggal: '2024-06-05',
        status: 'Menunggu Analisis',
    },
    {
        id: 3,
        token: 'GHI789',
        jenis_tes: 'Tes Minat Bakat',
        tanggal: '2024-06-10',
        status: 'Selesai',
    },
];

const reports = computed(() => props.testHistory || defaultHistory);
</script>

<template>
    <section>
        <!-- Avatar nama -->
        <div class="flex flex-col items-center justify-center gap-4">
            <div
                class="flex h-20 w-20 items-center justify-center rounded-full bg-primary text-white"
            >
                <User />
            </div>
            <div class="text-center">
                <h1 class="text-2xl font-bold">{{ user.nama }}</h1>
                <p class="text-gray-400">{{ user.email }}</p>
                <p class="mt-1 text-xs text-gray-500">Terdaftar sejak {{ user.created_at }}</p>
            </div>
        </div>
        <!-- Table riwayat -->
        <h1 class="my-4 text-xl font-semibold">Riwayat Tes</h1>
        <div
            class="overflow-hidden rounded-lg border border-gray-200 shadow-sm dark:border-gray-800"
        >
            <Table>
                <TableHeader class="bg-primary">
                    <TableRow class="border-0 hover:bg-transparent">
                        <TableHead class="text-center font-semibold text-white">
                            No
                        </TableHead>
                        <TableHead class="text-center font-semibold text-white">
                            Jenis Tes
                        </TableHead>
                        <TableHead class="text-center font-semibold text-white">
                            Tanggal Tes
                        </TableHead>
                        <TableHead class="text-center font-semibold text-white">
                            Status
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow
                        v-if="reports.length === 0"
                        class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                    >
                        <TableCell colspan="4" class="text-center text-gray-500 py-8">
                            Belum ada riwayat tes
                        </TableCell>
                    </TableRow>
                    <TableRow
                        v-for="(report, index) in reports"
                        :key="report.id"
                        class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                    >
                        <TableCell
                            class="text-center font-semibold text-gray-600 dark:text-gray-400"
                            >{{ index + 1 }}
                        </TableCell>
                        <TableCell class="text-center">
                            {{ report.jenis_tes }}
                        </TableCell>
                        <TableCell class="text-center">
                            {{ report.tanggal }}
                        </TableCell>
                        <TableCell class="text-center">
                            <Badge
                                :variant="
                                    report.status === 'Selesai'
                                        ? 'default'
                                        : 'secondary'
                                "
                                :class="
                                    report.status === 'Menunggu Analisis'
                                        ? 'bg-yellow-500 text-white hover:bg-yellow-500/80'
                                        : ''
                                "
                            >
                                {{ report.status }}
                            </Badge>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </section>

</template>
