<script setup lang="ts">
import StatementLists from '@/components/admin/tes-gaya-belajar/StatementLists.vue';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { gayaBelajar } from '@/routes';
import { create } from '@/routes/gayaBelajar';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';

// Terima props dari backend
const props = defineProps<{
    statements?: any;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Manajemen Tes Gaya Belajar',
        href: gayaBelajar().url,
    },
];
</script>

<template>
    <Head title="Manajemen Tes Gaya Belajar" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <!-- Heading -->
            <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <h1 class="text-2xl font-bold">Daftar Pernyataan</h1>
                    <p class="text-sm text-gray-600">
                        Peserta dapat memilih tingkat kesesuaian (1-3) untuk
                        setiap pernyataan yang ada.
                    </p>
                </div>
                <div>
                    <Link :href="create().url">
                        <Button>
                            <Plus class="h-4 w-4" /> Tambah Pernyataan</Button
                        >
                    </Link>
                </div>
            </div>

            <!-- Content -->
            <div>
                <StatementLists :statements="statements" />
            </div>
        </div>
    </AppLayout>
</template>
