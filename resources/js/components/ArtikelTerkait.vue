<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { artikel } from '@/routes';
import { Link } from '@inertiajs/vue3';
import Artikel from './Artikel.vue';

type ArticleCard = {
    judul: string;
    deskripsi: string;
    gambar: string;
    kategori: string;
    tanggal: string;
    slug: string;
};

defineProps<{
    articles: ArticleCard[];
}>();
</script>

<template>
    <div class="mt-16">
        <h3 class="text-2xl font-semibold text-primary">Artikel Lainnya</h3>

        <Artikel :articles="articles" :limit="3" :hide-header="true" />

        <div class="mt-4 text-center">
            <Link :href="artikel().url">
                <Button> Kembali ke Halaman Artikel </Button>
            </Link>
        </div>
    </div>
</template>
