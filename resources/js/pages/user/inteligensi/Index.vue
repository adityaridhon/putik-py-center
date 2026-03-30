<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import FormMulaiTes from '@/components/FormMulaiTes.vue';
import NavbarTes from '@/components/NavbarTes.vue';
</script>

<template>
    <div class="flex min-h-screen flex-col bg-slate-50">
        <NavbarTes judul="TES INTELIGENSI" />

        <main class="flex-1 py-4 sm:py-6 md:py-8">
            <FormMulaiTes redirect-to="/tes-online/inteligensi/tes" />
        </main>

        <Footer />
    </div>
</template>
