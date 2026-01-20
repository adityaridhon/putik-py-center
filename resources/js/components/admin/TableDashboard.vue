<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';

const activities = [
    {
        id: 1,
        nama_pengguna: 'Andi Fadillah',
        aktivitas: 'Tes Minat Bakat',
        tanggal: '14 Januari 2026',
        status: 'Selesai',
    },
    {
        id: 2,
        nama_pengguna: 'Yuni Astuti',
        aktivitas: 'Tes Intelegensi',
        tanggal: '14 Januari 2026',
        status: 'Proses',
    },
    {
        id: 3,
        nama_pengguna: 'Halim Setiawan',
        aktivitas: 'Tes Minat Bakat',
        tanggal: '14 Januari 2026',
        status: 'Batal',
    },
];

const getStatusVariant = (status: string) => {
    switch (status) {
        case 'Selesai':
            return 'default';
        case 'Proses':
            return 'secondary';
        case 'Batal':
            return 'destructive';
        default:
            return 'outline';
    }
};
</script>

<template>
    <Table>
        <TableHeader class="bg-primary/10 text-white">
            <TableRow class="text-center text-white">
                <TableHead> No </TableHead>
                <TableHead>Nama Pengguna</TableHead>
                <TableHead>Aktivitas</TableHead>
                <TableHead> Tanggal </TableHead>
                <TableHead>Status</TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="activity in activities" :key="activity.id">
                <TableCell class="font-medium">
                    {{ activity.id }}
                </TableCell>
                <TableCell>{{ activity.nama_pengguna }}</TableCell>
                <TableCell>{{ activity.aktivitas }}</TableCell>
                <TableCell>
                    {{ activity.tanggal }}
                </TableCell>
                <TableCell>
                    <Badge :variant="getStatusVariant(activity.status)">
                        {{ activity.status }}
                    </Badge>
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>
