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
    <div class="px-20 py-14">
        <div
            v-for="(item, index) in kontakItems"
            :key="index"
            class="w-full rounded-xl border-2 border-[#7FB69E]/20 bg-[#F8FAF9] p-6 shadow-md"
        >
            <div class="mb-4 flex items-center gap-3">
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-lg bg-[#2D5F4F]"
                >
                    <component :is="item.icon" class="h-6 w-6 text-white" />
                </div>

                <h3 class="font-semibold text-[#2C3E3A]">
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
                        class="h-64 w-full"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.913805567909!2d116.83237247424891!3d-1.220048535555804!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df147d7b54024ed%3A0x1eafad990c3ce7d1!2sJl.%20Telindung%20No.141%2C%20Muara%20Rapak%2C%20Kec.%20Balikpapan%20Utara%2C%20Kota%20Balikpapan%2C%20Kalimantan%20Timur!5e0!3m2!1sen!2sid!4v1770785444609!5m2!1sen!2sid"
                        style="border: 0"
                        loading="lazy"
                    ></iframe>
                </a>
            </div>
        </div>
    </div>
</template>
