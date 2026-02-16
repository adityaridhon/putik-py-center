<script setup lang="ts">
import PageHeader from '@/components/PageHeader.vue';
import Button from '@/components/ui/button/Button.vue';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { gayaBelajar } from '@/routes';
import { store } from '@/routes/gayaBelajar';
import { type BreadcrumbItem } from '@/types';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    statement: '',
});

const handleSubmit = () => {
    form.post(store().url, {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Manajemen Tes Gaya Belajar',
        href: gayaBelajar().url,
    },
    {
        title: 'Tambah Pernyataan Gaya Belajar',
        href: '#',
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
            <form @submit.prevent="handleSubmit">
                <div class="space-y-2">
                    <h1 class="text-xl font-bold">Pernyataan Tes</h1>
                    <Textarea
                        v-model="form.statement"
                        class="h-25 resize-none"
                        placeholder="Masukkan pernyataan tes di sini..."
                        :disabled="form.processing"
                    />
                    <p
                        v-if="form.errors.statement"
                        class="text-sm text-red-600"
                    >
                        {{ form.errors.statement }}
                    </p>
                </div>
                <div class="mt-4 flex justify-end">
                    <Button
                        type="submit"
                        :disabled="form.processing || !form.statement.trim()"
                    >
                        {{
                            form.processing
                                ? 'Menyimpan...'
                                : 'Simpan Pernyataan'
                        }}
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
