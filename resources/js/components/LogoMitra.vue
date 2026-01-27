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
    <div class="mt-10 text-center pb-10">
        <h1 class="font-title mb-4 text-4xl font-bold md:text-4xl">
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
                    class="mx-10"
                    alt="partner-luar"
                />
            </div>
        </Vue3Marquee>
    </div>
</template>
