<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { bankSoal } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Bank Soal',
        href: bankSoal().url,
    },
];
</script>

<template>
    <Head title="Manajemen Tes Gaya Belajar" />

    <AppLayout :breadcrumbs="breadcrumbs"> <div></div></AppLayout>
</template>
