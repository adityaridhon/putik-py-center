<script setup lang="ts">
import PageHeader from '@/components/PageHeader.vue';
import Button from '@/components/ui/button/Button.vue';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { gayaBelajar } from '@/routes';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tambah Pernyataan Gaya Belajar',
        href: gayaBelajar().url,
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <PageHeader
            title="Tambah Pernyataan Gaya Belajar"
            :back-url="gayaBelajar().url"
        />
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-6"
        >
            <div class="space-y-2">
                <h1 class="text-xl font-bold">Pernyataan Tes</h1>
                <Textarea
                    class="h-25 resize-none"
                    placeholder="Masukkan pernyataan tes di sini..."
                />
            </div>
            <div class="flex justify-end">
                <Button>Simpan Pernyataan</Button>
            </div>
        </div>
    </AppLayout>
</template>
