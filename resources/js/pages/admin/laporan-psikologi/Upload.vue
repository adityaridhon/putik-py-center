<script setup lang="ts">
import TestResults from '@/components/admin/laporan-psikologi/TestResults.vue';
import UploadReport from '@/components/admin/laporan-psikologi/UploadReport.vue';
import PageHeader from '@/components/PageHeader.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { laporanPsikologi } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Manajemen Laporan Psikologi',
        href: laporanPsikologi().url,
    },
    {
        title: 'Unggah Laporan',
        href: '#',
    },
];
</script>

<template>
    <Head title="Unggah Laporan Psikologi" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <PageHeader
            title="Unggah Laporan Psikologi"
            :back-url="laporanPsikologi().url"
        />

        <!-- Isi -->
        <section class="flex flex-col p-6">
            <!-- Hasil tes -->
            <div class="flex flex-col gap-4">
                <h1 class="text-xl font-semibold">
                    Hasil Tes Minat Bakat Reza Auditore
                </h1>
                <TestResults />
            </div>
            <!-- Upload file hasil cek -->
            <div class="mt-6 flex flex-col gap-4">
                <h1 class="text-xl font-semibold">
                    Unggah Laporan Hasil Tes Psikologi
                </h1>
                <UploadReport />
            </div>
        </section>
    </AppLayout>
</template>
