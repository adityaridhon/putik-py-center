<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';

const props = defineProps<{
    activities?: Array<{
        id: number | string;
        nama_pengguna: string;
        aktivitas: string;
        tanggal: string;
        status: string;
    }>;
}>();

const getBadgeClass = (status: string) => {
    switch (status) {
        case 'Selesai':
            return 'bg-green-100 text-green-800 hover:bg-green-100 dark:bg-green-900/30 dark:text-green-400 border-none px-2.5 flex justify-center py-0.5 rounded-full';
        case 'Menunggu':
        case 'Menunggu Analisis':
            return 'bg-yellow-100 text-yellow-800 hover:bg-yellow-100 dark:bg-yellow-900/30 dark:text-yellow-400 border-none px-2.5 flex justify-center py-0.5 rounded-full';
        case 'Booked':
            return 'bg-blue-100 text-blue-800 hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 border-none px-2.5 flex justify-center py-0.5 rounded-full';
        case 'Batal':
            return 'bg-red-100 text-red-800 hover:bg-red-100 dark:bg-red-900/30 dark:text-red-400 border-none px-2.5 flex justify-center py-0.5 rounded-full';
        default:
            return 'bg-gray-100 text-gray-800 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-300 border-none px-2.5 flex justify-center py-0.5 rounded-full';
    }
};
</script>

<template>
    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">   
        <Table>
            <TableHeader class="bg-primary">
                <TableRow class="border-0 hover:bg-transparent">
                    <TableHead class="font-semibold text-white">
                        Nama Pengguna
                    </TableHead>
                    <TableHead class="font-semibold text-white">
                        Aktivitas
                    </TableHead>
                    <TableHead class="font-semibold text-white">
                        Tanggal
                    </TableHead>
                    <TableHead class="w-32 text-center font-semibold text-white">
                        Status
                    </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-if="(props.activities || []).length === 0">
                    <TableCell colspan="4" class="h-20 text-center text-gray-500">
                        Belum ada aktivitas.
                    </TableCell>
                </TableRow>
                <TableRow
                    v-for="activity in props.activities || []"
                    :key="activity.id"
                    class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                >
                    <TableCell class="font-semibold">
                        {{ activity.nama_pengguna }}
                    </TableCell>
                    <TableCell class="text-gray-600">
                        {{ activity.aktivitas }}
                    </TableCell>
                    <TableCell class="text-gray-600">
                        {{ activity.tanggal }}
                    </TableCell>
                    <TableCell class="text-center">
                        <Badge variant="outline" :class="getBadgeClass(activity.status)">
                            {{ activity.status }}
                        </Badge>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>
