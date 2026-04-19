<script setup lang="ts">
import { MapPin } from 'lucide-vue-next';

const kontakItems = [
    {
        icon: MapPin,
        title: 'Alamat Klinik',
        description:
            'Jl. Telindung No 141 B Rt 086 Balikpapan 76125, Kalimantan Timur',
    },
];
</script>

<template>
    <div class="px-4 py-10 sm:px-6 md:px-8 md:py-12 lg:px-10 lg:py-14">
        <div
            v-for="(item, index) in kontakItems"
            :key="index"
            class="mx-auto w-full max-w-7xl rounded-xl border-2 border-[#7FB69E]/20 bg-[#F8FAF9] p-5 shadow-md sm:p-6"
        >
            <div class="mb-4 flex items-center gap-3">
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary"
                >
                    <component :is="item.icon" class="h-6 w-6 text-white" />
                </div>

                <h3 class="text-base font-semibold text-[#2C3E3A] sm:text-lg">
                    {{ item.title }}
                </h3>
            </div>

            <p class="text-sm leading-relaxed text-[#6B8E6F]">
                {{ item.description }}
            </p>

            <div class="mt-6 overflow-hidden rounded-xl">
                <a
                    href="https://maps.app.goo.gl/b472S3uove2MCo976"
                    target="_blank"
                >
                    <iframe
                        class="h-56 w-full sm:h-64 md:h-72"
                        src="https://www.google.com/maps/embed?pb=!4v1776425875708!6m8!1m7!1sYUWQfqrJqagcH8pmWpOUPw!2m2!1d-1.220575870818638!2d116.8364601231658!3f140.37!4f-17.590000000000003!5f0.7820865974627469"
                        style="border: 0"
                        loading="lazy"
                    ></iframe>
                </a>
            </div>
        </div>
    </div>
</template>
