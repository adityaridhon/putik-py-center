<script setup lang="ts">
import ArticleData from '@/components/admin/manajemen-artikel/ArticleData.vue';
import ArticleLists from '@/components/admin/manajemen-artikel/ArticleLists.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { article } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

defineProps<{
    articles?: any;
    recentArticles?: any[];
    articlesByCategory?: any[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Manajemen Artikel',
        href: article().url,
    },
];
</script>

<template>
    <Head title="Manajemen Artikel" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div>
                <h1 class="my-4 text-2xl font-bold">Artikel terbaru</h1>
                <ArticleData
                    :articles="recentArticles"
                    :articlesByCategory="articlesByCategory"
                />
                <ArticleLists :articles="articles" class="mt-10 mb-4" />
            </div>
        </div>
    </AppLayout>
</template>
