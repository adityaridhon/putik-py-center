<script setup lang="ts">
import AboutHeadline from '@/components/AboutHeadline.vue';
import Footer from '@/components/Footer.vue';
import Navbar from '@/components/Navbar.vue';
import OurStory from '@/components/OurStory.vue';
import ProfilTim from '@/components/ProfilTim.vue';
import VisiMisi from '@/components/VisiMisi.vue';
import WhyChooseUs from '@/components/WhyChooseUs.vue';

defineProps<{
    psychologists?: Array<{
        id: number;
        name: string;
        specialization?: string | null;
        photo_url?: string | null;
    }>;
}>();
</script>

<template>
    <div class="overflow-x-hidden">
        <Navbar />
        <AboutHeadline />
        <OurStory />
        <VisiMisi />
        <ProfilTim :psychologists="psychologists" />
        <WhyChooseUs />
        <Footer />
    </div>
</template>
