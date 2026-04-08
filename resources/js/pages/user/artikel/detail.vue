<script setup lang="ts">
import ArtikelContent from '@/components/ArtikelContent.vue';
import ArtikelHero from '@/components/ArtikelHero.vue';
import ArtikelTerkait from '@/components/ArtikelTerkait.vue';
import PageHeader from '@/components/PageHeader.vue';

type ArticleCard = {
    judul: string;
    deskripsi: string;
    gambar: string;
    kategori: string;
    tanggal: string;
    slug: string;
};

defineProps<{
    article: ArticleCard;
    articles: ArticleCard[];
}>();
</script>

<template>
    <PageHeader title="Detail Artikel" :back-url="-1" />
    <div
        class="mx-auto w-full max-w-4xl space-y-8 px-4 py-8 sm:px-6 sm:py-10 md:px-8"
    >
        <ArtikelHero :article="article" />

        <div class="prose prose-lg max-w-none rounded-lg bg-white p-6 sm:p-8 shadow-sm">
            <ArtikelContent :article="article" />
        </div>

        <ArtikelTerkait :articles="articles" />
    </div>
</template>
