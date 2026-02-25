<script setup lang="ts">
import GenerateToken from '@/components/admin/bank-soal/GenerateToken.vue';
import PageHeader from '@/components/PageHeader.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { bankSoal } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Bank Soal',
        href: bankSoal().url,
    },
    {
        title: 'Generate Token',
        href: '#',
    },
];
</script>

<template>
    <Head title="Generate Token Soal" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <PageHeader
            title="Generate Token Soal"
            description="Buat token untuk bank soal tes gaya belajar."
            :back-url="bankSoal().url"
        />

        <!-- Form -->
        <div class="p-6">
            <GenerateToken />
        </div>
    </AppLayout>
</template>
