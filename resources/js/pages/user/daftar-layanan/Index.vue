<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import Navbar from '@/components/Navbar.vue';
import TestList from '@/components/TestList.vue';
</script>

<template>
    <Navbar />
    <section class="bg-gray-50 pt-32 pb-24">
        <div class="mx-auto max-w-4xl text-center">
            <h2 class="text-3xl font-bold text-gray-800">Tes Online</h2>

            <p class="mt-4 text-gray-600">
                Pilih jenis tes psikologi yang sesuai dengan kebutuhan Anda.
                Semua tes dilakukan secara profesional dan hasil akan dianalisis
                oleh psikolog berpengalaman.
            </p>
        </div>

        <div class="mx-auto mt-12 max-w-4xl">
            <TestList />
        </div>
    </section>
    <Footer />
</template>
