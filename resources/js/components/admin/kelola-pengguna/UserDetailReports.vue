<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';
import { User } from 'lucide-vue-next';
import { ref } from 'vue';

import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';

interface UserReportDetail {
    id: number;
    token: string;
    jenisTes: string;
    tanggal: string;
    status: 'Selesai' | 'Menunggu Analisis';
}

const reports = ref<UserReportDetail[]>([
    {
        id: 1,
        token: 'ABC123',
        jenisTes: 'Tes Kepribadian',
        tanggal: '2024-06-01',
        status: 'Selesai',
    },
    {
        id: 2,
        token: 'DEF456',
        jenisTes: 'Tes Kecerdasan Emosional',
        tanggal: '2024-06-05',
        status: 'Menunggu Analisis',
    },
    {
        id: 3,
        token: 'GHI789',
        jenisTes: 'Tes Minat Bakat',
        tanggal: '2024-06-10',
        status: 'Selesai',
    },
]);
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
                <h1 class="text-2xl font-bold">Andi Fadhilah</h1>
                <p class="text-gray-400">andifadhilah@example.com</p>
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
                        v-for="(report, index) in reports"
                        :key="report.id"
                        class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                    >
                        <TableCell
                            class="text-center font-semibold text-gray-600 dark:text-gray-400"
                            >{{ index + 1 }}
                        </TableCell>
                        <TableCell class="text-center">
                            {{ report.jenisTes }}
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
