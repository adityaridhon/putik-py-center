<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import FormMulaiTes from '@/components/FormMulaiTes.vue';
import Navbar from '@/components/Navbar.vue';
</script>

<template>
    <div class="flex min-h-screen flex-col bg-slate-50">
        <Navbar title="TES INTELIGENSI" />

        <main class="flex-1 py-4 sm:py-6 md:py-8">
            <FormMulaiTes submit-url="/tes-online/inteligensi/mulai" />
        </main>

        <Footer />
    </div>
</template>
