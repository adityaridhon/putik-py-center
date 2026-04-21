<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import KontakCard from '@/components/KontakCard.vue';
import LokasiCard from '@/components/LokasiCard.vue';
import Navbar from '@/components/Navbar.vue';
import ScrollProgressBar from '@/components/ScrollProgressBar.vue';
</script>

<template>
    <div class="overflow-x-hidden">
        <Navbar />
        <ScrollProgressBar />
        <KontakCard />
        <LokasiCard />
        <Footer />
    </div>
</template>
