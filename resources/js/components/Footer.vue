<script setup lang="ts">
import { Instagram, Mail, MapPin, Phone } from 'lucide-vue-next';
</script>

<template>
    <footer class="bg-primary text-white">
        <div
            class="mx-auto w-full max-w-screen-xl p-4 px-4 py-6 sm:px-6 md:px-20 lg:py-8"
        >
            <div class="flex flex-wrap gap-6 md:gap-8 lg:gap-10">
                <!-- Logo dan Deskripsi -->
                <div
                    class="w-full text-center md:w-auto md:min-w-[250px] md:text-left"
                >
                    <a class="inline-block">
                        <img
                            src="/images/logo_putik.webp"
                            width="250"
                            alt="logo"
                        />
                    </a>
                </div>

                <!-- Grid Kontak dan Social Media -->
                <div class="w-full md:w-auto md:max-w-[500px] md:min-w-[300px]">
                    <!-- Kontak -->
                    <div class="text-center md:text-left">
                        <h2
                            class="text-heading mb-4 text-xl font-semibold uppercase md:mb-6"
                        >
                            HUBUNGI KAMI
                        </h2>
                        <ul class="text-body space-y-3 font-medium">
                            <li>
                                <a
                                    class="flex items-center justify-center gap-3 transition-colors hover:underline md:justify-start"
                                    ><Phone class="h-5 w-5" />0812 5581 350
                                </a>
                            </li>
                            <li>
                                <a
                                    href="mailto:putik_pc@yahoo.com"
                                    target="_blank"
                                    class="flex items-center justify-center gap-3 transition-colors hover:underline md:justify-start"
                                    ><Mail class="h-5 w-5" />putik_pc@yahoo.com
                                    | shofijati@gmail.com</a
                                >
                            </li>
                            <li>
                                <a
                                    href="https://www.instagram.com/putikpsycenter?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="
                                    target="_blank"
                                    class="flex items-center justify-center gap-3 transition-colors hover:underline md:justify-start"
                                    ><Instagram
                                        class="h-5 w-5"
                                    />@putikpsycenter</a
                                >
                            </li>
                            <li>
                                <a
                                    href="https://maps.app.goo.gl/kRRqRavvEHMZkYGHA"
                                    target="_blank"
                                    class="flex items-center justify-center gap-3 transition-colors hover:underline md:justify-start"
                                >
                                    <MapPin class="h-5 w-5" /> Jl. Telindung No.
                                    141 B RT. 086 Kota Balikpapan 76125,
                                    Kalimantan Timur
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr class="border-default my-6 sm:mx-auto lg:my-8" />
            <div class="text-center">
                <span class="text-body text-sm"
                    >© 2026
                    <a href="https://flowbite.com/" class="hover:underline"
                        >Flowbite™</a
                    >. All Rights Reserved.
                </span>
            </div>
        </div>
    </footer>
</template>
