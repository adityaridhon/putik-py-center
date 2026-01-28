<script setup lang="ts">
import AboutSection from '@/components/AboutSection.vue';
import Artikel from '@/components/Artikel.vue';
import Footer from '@/components/Footer.vue';
import HeroSection from '@/components/HeroSection.vue';
import Layanan from '@/components/Layanan.vue';
import LogoMitra from '@/components/LogoMitra.vue';
import Navbar from '@/components/Navbar.vue';
import TimKami from '@/components/TimKami.vue';

defineProps<{
    companyProfile?: {
        id?: number;
        company_name?: string;
        headline?: string;
        about?: string;
        phone?: string;
        email?: string;
        instagram?: string;
        address?: string;
        logo?: string;
        landing_image?: string;
        logo_url?: string;
        landing_image_url?: string;
    };
}>();
</script>

<template>
    <Navbar :profile="companyProfile" />
    <HeroSection :profile="companyProfile" />
    <AboutSection :profile="companyProfile" />
    <Layanan />
    <TimKami />
    <LogoMitra />
    <Artikel />
    <Footer :profile="companyProfile" />
</template>
