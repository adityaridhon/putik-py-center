<script setup lang="ts">
import { Vue3Marquee } from 'vue3-marquee';

const companyClients = [
    '/images/Logo_1.png',
    '/images/Logo_2.png',
    '/images/Logo_3.png',
    '/images/Logo_4.png',
    '/images/Logo_5.png',
    '/images/Logo_6.png',
];
</script>
<template>
    <div class="mt-10 pb-10 text-center">
        <h1 class="font-title mb-4 px-4 text-3xl font-bold sm:text-4xl">
            Klien Partner Kami
        </h1>
        <Vue3Marquee :pause-on-hover="true">
            <div
                class="card"
                v-for="companyClient in companyClients"
                :key="companyClient"
            >
                <img
                    :src="companyClient"
                    width="120"
                    class="mx-6 w-20 sm:mx-8 sm:w-24 md:mx-10 md:w-[120px]"
                    alt="partner-luar"
                />
            </div>
        </Vue3Marquee>
    </div>
</template>
