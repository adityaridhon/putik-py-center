<script setup lang="ts">
import CategoryCard from '@/components/admin/tes-minat-bakat/CategoryCard.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { minatBakat } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

defineProps<{
    categories: any[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Manajemen Tes Minat Bakat',
        href: minatBakat().url,
    },
];
</script>

<template>
    <Head title="Manajemen Tes Minat Bakat" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <!-- Heading -->
            <div class="space-y-2">
                <h1 class="text-2xl font-bold">Kategori Tes Minat Bakat</h1>
                <p class="text-sm text-gray-600">
                    Kategori yang tersedia adalah A - I dengan isi pilihan
                    bidang pekerjaan yang diminati.
                </p>
            </div>

            <!-- Content -->
            <div class="grid auto-rows-min gap-4 md:grid-cols-4">
                <CategoryCard v-for="category in categories" :key="category.id" :category="category" />
            </div>
        </div>
    </AppLayout>
</template>
