<script setup lang="ts">
import TestInstruction from '@/components/admin/tes-minat-bakat/TestInstruction.vue';
import WorkLists from '@/components/admin/tes-minat-bakat/WorkLists.vue';
import PageHeader from '@/components/PageHeader.vue';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { minatBakat } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Manajemen Tes Minat Bakat', href: minatBakat().url },
    { title: 'Buat Soal', href: '#' },
];
</script>

<template>
    <Head title="Buat Soal" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <PageHeader title="Tambah Soal" :back-url="minatBakat().url" />
        <div class="flex flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <!-- Heading -->
            <div class="space-y-2">
                <h1 class="text-2xl font-bold">Kategori A</h1>
            </div>

            <!-- Content -->
            <div class="space-y-2">
                <TestInstruction />
                <WorkLists />
            </div>
        </div>
        <div class="flex justify-end p-4">
            <Button>Simpan tes </Button>
        </div>
    </AppLayout>
</template>
