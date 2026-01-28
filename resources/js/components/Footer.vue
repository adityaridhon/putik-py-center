<script setup lang="ts">
import { Instagram, Mail, MapPin, Phone } from 'lucide-vue-next';

defineProps<{
    profile?: {
        phone?: string;
        email?: string;
        instagram?: string;
        address?: string;
        logo_url?: string;
    };
}>();
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
                            :src="
                                profile?.logo_url
                                    ? `/storage/${profile.logo_url}`
                                    : '/images/logo_putik.webp'
                            "
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
                            <li v-if="profile?.phone">
                                <a
                                    class="flex items-center justify-center gap-3 transition-colors hover:underline md:justify-start"
                                    ><Phone class="h-5 w-5" />{{
                                        profile.phone
                                    }}
                                </a>
                            </li>
                            <li v-if="profile?.email">
                                <a
                                    :href="`mailto:${profile.email}`"
                                    target="_blank"
                                    class="flex items-center justify-center gap-3 transition-colors hover:underline md:justify-start"
                                    ><Mail class="h-5 w-5" />{{
                                        profile.email
                                    }}</a
                                >
                            </li>
                            <li v-if="profile?.instagram">
                                <a
                                    :href="`https://www.instagram.com/${profile.instagram.replace('@', '')}`"
                                    target="_blank"
                                    class="flex items-center justify-center gap-3 transition-colors hover:underline md:justify-start"
                                    ><Instagram class="h-5 w-5" />{{
                                        profile.instagram
                                    }}</a
                                >
                            </li>
                            <li v-if="profile?.address">
                                <a
                                    href="https://maps.app.goo.gl/kRRqRavvEHMZkYGHA"
                                    target="_blank"
                                    class="flex items-center justify-center gap-3 transition-colors hover:underline md:justify-start"
                                >
                                    <MapPin class="h-5 w-5" />
                                    {{ profile.address }}
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
