<script setup lang="ts">
import PageHeader from '@/components/PageHeader.vue';
import TestResults from '@/components/admin/laporan-psikologi/TestResults.vue';
import UploadReport from '@/components/admin/laporan-psikologi/UploadReport.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { laporanPsikologi } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

// Terima props dari backend
const props = defineProps<{
    session: {
        id: number;
        participant: {
            name: string;
            email: string;
            test_date: string;
            completion_time?: string;
        };
    };
    intelligenceResults?: any;
    learningStyleResults?: any;
    interestResults?: any;
    report?: {
        id: number;
        file_name: string;
        file_size: string;
        uploaded_at: string;
        uploaded_by: string;
    } | null;
}>();

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
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <PageHeader
                title="Unggah Laporan Psikologi"
                :backUrl="laporanPsikologi().url"
                backText="Kembali"
            />

            <!-- Test Results -->
            <TestResults
                :participant="session.participant"
                :intelligenceResults="intelligenceResults"
                :learningStyleResults="learningStyleResults"
                :interestResults="interestResults"
            />

            <!-- Upload Section -->
            <div class="mt-6">
                <h2 class="mb-4 text-xl font-bold">
                    Unggah Laporan Hasil Tes Psikologi
                </h2>

                <UploadReport
                    :sessionId="session.id"
                    :existingReport="report"
                />
            </div>
        </div>
    </AppLayout>
</template>
