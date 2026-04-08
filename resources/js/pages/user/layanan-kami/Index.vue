<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import HeroLayanan from '@/components/HeroLayanan.vue';
import Navbar from '@/components/Navbar.vue';
import ServicesSection from '@/components/ServicesSection.vue';

const props = defineProps<{
    services?: Array<{
        id: number;
        name: string;
        description: string | null;
        image_url?: string | null;
    }>;
}>();
</script>

<template>
    <div class="overflow-x-hidden">
        <Navbar />
        <HeroLayanan />
        <ServicesSection :services="props.services" />
        <Footer />
    </div>
</template>
