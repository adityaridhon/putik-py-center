<script setup lang="ts">
import { Vue3Marquee } from 'vue3-marquee';

const props = defineProps<{
    partnerLogos?: string[];
}>();
</script>
<template>
    <div class="mt-10 pb-10 text-center">
        <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 md:px-8 lg:px-10">
            <h1 class="font-title mb-4 text-3xl font-bold sm:text-4xl">
                Klien Partner Kami
            </h1>
        </div>
        <Vue3Marquee v-if="props.partnerLogos?.length" :pause-on-hover="true">
            <div
                class="card"
                v-for="companyClient in props.partnerLogos"
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
        <p v-else class="text-sm text-gray-500">Belum ada logo partner.</p>
    </div>
</template>
