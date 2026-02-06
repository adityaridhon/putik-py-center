<script setup lang="ts">
import EditArticleForm from '@/components/admin/manajemen-artikel/EditArticleForm.vue';
import PageHeader from '@/components/PageHeader.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { article as articleRoute } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

// Receive props from controller
const props = defineProps<{
    artikel: {
        id: number;
        title: string;
        slug: string;
        author: string;
        category_id: number;
        description: string;
        status: 'draft' | 'published' | 'archived';
        file_path?: string;
        cover_image?: string;
        cover_image_url?: string;
        file_path_url?: string;
    };
    categories: Array<{ id: number; name: string }>;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Manajemen Artikel', href: articleRoute().url },
    { title: 'Edit Artikel', href: '#' },
];
</script>

<template>
    <Head title="Edit Artikel" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <PageHeader title="Edit Artikel" :back-url="articleRoute().url" />
        <div class="p-6">
            <EditArticleForm :article="artikel" :categories="categories" />
        </div>
    </AppLayout>
</template>
