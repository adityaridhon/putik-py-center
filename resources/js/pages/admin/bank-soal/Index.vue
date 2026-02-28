<script setup lang="ts">
import BankSoalLists from '@/components/admin/bank-soal/BankSoalLists.vue';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { bankSoal } from '@/routes';
import { create } from '@/routes/bankSoal';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import { computed } from 'vue';

const page = usePage()

const batches = computed(() => page.props.batches as any)

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Bank Soal',
        href: bankSoal().url,
    },
];
</script>

<template>
    <Head title="Manajemen Tes Gaya Belajar" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6">
            <div class="mb-5 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-semibold tracking-tight">
                        Bank Soal
                    </h2>
                    <p class="mt-1 text-sm text-muted-foreground">
                        Kelola bank soal untuk tes gaya belajar.
                    </p>
                </div>
                <div>
                    <Link :href="create().url">
                        <Button variant="default">
                            <Plus class="h-4 w-4" />
                            Buat Token
                        </Button>
                    </Link>
                </div>
            </div>
            <BankSoalLists :batches="batches" />
        </div>
    </AppLayout>
</template>
