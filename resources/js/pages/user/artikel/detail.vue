<script setup lang="ts">
import ArtikelContent from '@/components/ArtikelContent.vue';
import ArtikelHero from '@/components/ArtikelHero.vue';
import ArtikelQuote from '@/components/ArtikelQuote.vue';
import ArtikelTerkait from '@/components/ArtikelTerkait.vue';
</script>

<template>
    <div class="px-24 py-10">
        <ArtikelHero />

        <ArtikelContent />

        <ArtikelQuote />

        <ArtikelTerkait />
    </div>
</template>
