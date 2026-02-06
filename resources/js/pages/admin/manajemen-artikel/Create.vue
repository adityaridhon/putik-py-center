<script setup lang="ts">
import CreateArticleForm from '@/components/admin/manajemen-artikel/CreateArticleForm.vue';
import PageHeader from '@/components/PageHeader.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { article } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

// Receive props from controller
const props = defineProps<{
    categories: Array<{ id: number; name: string }>;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Manajemen Artikel', href: article().url },
    { title: 'Tambah Artikel', href: '#' },
];
</script>

<template>
    <Head title="Tambah Artikel" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <PageHeader title="Tambah Artikel" :back-url="article().url" />
        <div class="p-6">
            <CreateArticleForm :categories="categories" />
        </div>
    </AppLayout>
</template>
