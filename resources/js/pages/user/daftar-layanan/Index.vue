<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import Navbar from '@/components/Navbar.vue';
import ScrollProgressBar from '@/components/ScrollProgressBar.vue';
import TestList from '@/components/TestList.vue';
</script>

<template>
    <div class="overflow-x-hidden">
        <Navbar />
        <ScrollProgressBar />

        <section class="bg-gray-50 pt-28 pb-16 sm:pt-32 sm:pb-20 md:pb-24">
            <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 md:px-8 lg:px-10">
                <div class="mx-auto max-w-4xl text-center">
                    <h2 class="text-2xl font-bold text-gray-800 sm:text-3xl">
                        Tes Online
                    </h2>

                    <p
                        class="mt-4 text-sm leading-relaxed text-gray-600 sm:text-base"
                    >
                        Pilih jenis tes psikologi yang sesuai dengan kebutuhan
                        Anda. Semua tes dilakukan secara profesional dan hasil
                        akan dianalisis oleh psikolog berpengalaman.
                    </p>
                </div>

                <div class="mx-auto mt-10 max-w-4xl sm:mt-12">
                    <TestList />
                </div>
            </div>
        </section>
        <Footer />
    </div>
</template>
