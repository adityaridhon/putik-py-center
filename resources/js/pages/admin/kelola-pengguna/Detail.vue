<script setup lang="ts">
import UserDetailReports from '@/components/admin/kelola-pengguna/UserDetailReports.vue';
import PageHeader from '@/components/PageHeader.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { kelolaPengguna } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Kelola Pengguna',
        href: kelolaPengguna().url,
    },
    {
        title: 'Detail Pengguna',
        href: '',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Detail Pengguna" />

        <PageHeader :back-url="kelolaPengguna.url()" title="Detail Pengguna" />
        <div class="p-6">
            <UserDetailReports />
        </div>
    </AppLayout>
</template>
