<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import FormMulaiTes from '@/components/FormMulaiTes.vue';
import Navbar from '@/components/Navbar.vue';
</script>

<template>
    <div class="overflow-x-hidden">
        <Navbar title="TES MINAT BAKAT" />
        <FormMulaiTes submit-url="/tes-online/minat-bakat/mulai" />
        <Footer />
    </div>
</template>
