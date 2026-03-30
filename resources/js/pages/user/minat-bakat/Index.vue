<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import FormMulaiTes from '@/components/FormMulaiTes.vue';
import NavbarTes from '@/components/NavbarTes.vue';
</script>

<template>
    <div class="overflow-x-hidden">
        <NavbarTes judul="TES MINAT BAKAT" />
        <FormMulaiTes redirect-to="/tes-online/minat-bakat/tes" />
        <Footer />
    </div>
</template>
