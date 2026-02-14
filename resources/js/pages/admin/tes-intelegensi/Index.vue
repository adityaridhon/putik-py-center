<script setup lang="ts">
import IntelegentTable from '@/components/admin/tes-intelegensi/IntelegentTable.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { intelegensi } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Manajemen Tes Intelegensi',
        href: intelegensi().url,
    },
];
</script>

<template>
    <Head title="Manajemen Tes Intelegensi" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <h1 class="text-2xl font-bold">
                        Daftar Kategori Tes Intelegensi
                    </h1>
                    <p class="text-sm text-gray-600">
                        Admin dapat mengelola kategori tes intelegensi yang
                        tersedia untuk peserta.
                    </p>
                </div>
            </div>
            <IntelegentTable />
        </div>
    </AppLayout>
</template>
