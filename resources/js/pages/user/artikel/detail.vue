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
        class="mx-auto w-full max-w-5xl space-y-2 px-6 py-8 sm:px-8 sm:py-10 md:max-w-6xl md:px-10"
    >
        <ArtikelHero :article="article" />

        <ArtikelContent :article="article" />

        <ArtikelTerkait :articles="articles" />
    </div>
</template>
