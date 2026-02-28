<script setup lang="ts">
import TokenDetail from '@/components/admin/bank-soal/TokenDetail.vue';
import PageHeader from '@/components/PageHeader.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { bankSoal } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage()

const batch = computed(() => page.props.batch as any)

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Bank Soal',
        href: bankSoal().url,
    },
    {
        title: 'Detail Token',
        href: '#',
    },
];
</script>

<template>
    <Head title="Detail Token Bank Soal" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <PageHeader
            title="Detail Token Bank Soal"
            description="Lihat detail token yang telah dibuat untuk bank soal."
            :back-url="bankSoal().url"
        />

        <!-- Token Details -->
        <div class="p-6">
            <TokenDetail :batch="batch" />
        </div>
    </AppLayout>
</template>
