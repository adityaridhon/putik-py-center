<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import Navbar from '@/components/Navbar.vue';
import TestList from '@/components/TestList.vue';
</script>

<template>
    <div class="overflow-x-hidden">
        <Navbar />
        <section
            class="bg-gray-50 px-4 pt-28 pb-16 sm:px-6 sm:pt-32 sm:pb-20 md:px-8 md:pb-24 lg:px-10"
        >
            <div class="mx-auto max-w-4xl text-center">
                <h2 class="text-2xl font-bold text-gray-800 sm:text-3xl">
                    Tes Online
                </h2>

                <p
                    class="mt-4 text-sm leading-relaxed text-gray-600 sm:text-base"
                >
                    Pilih jenis tes psikologi yang sesuai dengan kebutuhan Anda.
                    Semua tes dilakukan secara profesional dan hasil akan
                    dianalisis oleh psikolog berpengalaman.
                </p>
            </div>

            <div class="mx-auto mt-10 max-w-4xl sm:mt-12">
                <TestList />
            </div>
        </section>
        <Footer />
    </div>
</template>
