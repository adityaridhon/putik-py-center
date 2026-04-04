<script setup lang="ts">
import DashboardCard from '@/components/admin/dashboard/DashboardCard.vue';
import TableDashboard from '@/components/admin/dashboard/TableDashboard.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const props = defineProps<{
    dashboardStats?: {
        janjiMingguIni: number;
        laporanPsikologi: number;
        artikelTerbit: number;
    };
    dashboardTrends?: {
        janjiMingguIni: number;
        laporanPsikologi: number;
        artikelTerbit: number;
    };
    activities?: Array<{
        id: number | string;
        nama_pengguna: string;
        aktivitas: string;
        tanggal: string;
        status: string;
    }>;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <DashboardCard
                    :stats="props.dashboardStats"
                    :trends="props.dashboardTrends"
                />
            </div>
            <div>
                <h1 class="my-4 text-2xl font-bold">Aktivitas terbaru</h1>
                <TableDashboard :activities="props.activities" />
            </div>
        </div>
    </AppLayout>
</template>
