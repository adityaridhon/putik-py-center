<script setup lang="ts">
import ArticleCard from '@/components/admin/manajemen-artikel/ArticleCardHeader.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { artikel } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Manajemen Artikel',
        href: artikel().url,
    },
];
</script>

<template>
    <Head title="Manajemen Artikel" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                <ArticleCard />
            </div>
            <div>
                <h1 class="my-4 text-2xl font-bold">Artikel terbaru</h1>
                <h1 class="my-4 text-2xl font-bold">Daftar Artikel</h1>
            </div>
        </div>
    </AppLayout>
</template>
