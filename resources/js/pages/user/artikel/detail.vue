<script setup lang="ts">
import ArtikelContent from '@/components/ArtikelContent.vue';
import ArtikelHero from '@/components/ArtikelHero.vue';
import ArtikelQuote from '@/components/ArtikelQuote.vue';
import ArtikelTerkait from '@/components/ArtikelTerkait.vue';
</script>

<template>
    <div
        class="mx-auto w-full max-w-5xl px-6 py-8 sm:px-8 sm:py-10 md:px-10 lg:px-14"
    >
        <ArtikelHero />

        <ArtikelContent />

        <ArtikelQuote />

        <ArtikelTerkait />
    </div>
</template>
