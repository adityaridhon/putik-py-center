<script setup lang="ts">
import ManageServiceCard from '@/components/admin/manajemen-layanan/ManageServiceCard.vue';
import ServiceDate from '@/components/admin/manajemen-layanan/ServiceDate.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { layanan } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Manajemen Layanan',
        href: layanan().url,
    },
];
</script>

<template>
    <Head title="Manajemen Layanan" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                <ManageServiceCard />
            </div>
            <ServiceDate />
        </div>
    </AppLayout>
</template>
