<script setup lang="ts">
import UserLists from '@/components/admin/kelola-pengguna/UserLists.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { kelolaPengguna } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

// Terima props dari backend
const props = defineProps<{
    users?: any;
    filters?: {
        search?: string;
        sort?: string;
    };
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Kelola Pengguna',
        href: kelolaPengguna().url,
    },
];
</script>

<template>
    <Head title="Kelola Pengguna" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col overflow-x-auto rounded-xl p-4">
            <h1 class="mb-1 text-2xl font-bold">Pengguna</h1>
            <p class="mb-4">
                Daftar pengguna terdaftar dan riwayat tes online pengguna.
            </p>
            <UserLists :users="users" :filters="filters" />
        </div>
    </AppLayout>
</template>
