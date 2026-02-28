<script setup lang="ts">
import ReportLists from '@/components/admin/laporan-psikologi/ReportLists.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { laporanPsikologi } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

// Terima props dari backend
const props = defineProps<{
    sessions?: any;
    filters?: {
        search?: string;
        test_type?: string;
        status?: string;
    };
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Manajemen Laporan Psikologi',
        href: laporanPsikologi().url,
    },
];
</script>

<template>
    <Head title="Manajemen Laporan Psikologi" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <h1 class="my-2 text-2xl font-bold">Manajemen Laporan Psikologi</h1>
            <ReportLists :sessions="sessions" :filters="filters" />
        </div>
    </AppLayout>
</template>
