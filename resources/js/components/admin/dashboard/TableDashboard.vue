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
        id: number;
        nama_pengguna: string;
        aktivitas: string;
        tanggal: string;
        status: string;
    }>;
}>();

const getStatusVariant = (status: string) => {
    switch (status) {
        case 'Menunggu':
            return 'secondary';
        case 'Booked':
            return 'outline';
        case 'Selesai':
            return 'default';
        case 'Batal':
            return 'destructive';
        default:
            return 'outline';
    }
};
</script>

<template>
    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
        <Table>
            <TableHeader class="bg-primary">
                <TableRow class="border-0 hover:bg-transparent">
                    <TableHead
                        class="w-16 text-center font-semibold text-white"
                    >
                        No
                    </TableHead>
                    <TableHead class="font-semibold text-white">
                        Nama Pengguna
                    </TableHead>
                    <TableHead class="font-semibold text-white">
                        Aktivitas
                    </TableHead>
                    <TableHead class="font-semibold text-white">
                        Tanggal
                    </TableHead>
                    <TableHead class="font-semibold text-white">
                        Status
                    </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-if="(props.activities || []).length === 0">
                    <TableCell colspan="5" class="h-20 text-center text-gray-500">
                        Belum ada aktivitas booking.
                    </TableCell>
                </TableRow>
                <TableRow
                    v-for="activity in props.activities || []"
                    :key="activity.id"
                    class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                >
                    <TableCell class="text-center font-semibold text-gray-600">
                        {{ activity.id }}
                    </TableCell>
                    <TableCell class="font-semibold">
                        {{ activity.nama_pengguna }}
                    </TableCell>
                    <TableCell class="text-gray-600">
                        {{ activity.aktivitas }}
                    </TableCell>
                    <TableCell class="text-gray-600">
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
    </div>
</template>
