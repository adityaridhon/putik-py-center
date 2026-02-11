<script setup lang="ts">
import { Clock, Mail, MessageCircle, Phone } from 'lucide-vue-next';

const kontakItems = [
    {
        icon: Phone,
        title: 'Telepon',
        description: '0812 5581 350',
        link: 'tel:08125581350',
    },
    {
        icon: MessageCircle,
        title: 'WhatsApp',
        description: '0812 5581 350',
        link: 'https://wa.me/628125581350',
    },
    {
        icon: Mail,
        title: 'Email',
        description: 'putik_pc@yahoo.com | shofijati@gmail.com',
        link: 'mailto:putik_pc@yahoo.com',
    },
    {
        icon: Clock,
        title: 'Jam Operasional',
        description: 'Senin - Jumat: 09:00 - 17:00',
        link: null,
    },
];
</script>

<template>
    <section class="bg-white px-14 pt-32">
        <div class="mx-auto max-w-7xl px-6">
            <div class="mb-12 text-center">
                <h2 class="mb-4 text-3xl font-bold text-[#2C3E3A]">
                    Hubungi Kami
                </h2>
                <p class="mx-auto max-w-2xl text-[#6B8E6F]">
                    Kami siap membantu Anda dalam perjalanan menuju kesehatan
                    mental yang lebih baik. Jangan ragu untuk menghubungi kami
                    kapan saja.
                </p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-2">
                <div v-for="(benefit, index) in kontakItems" :key="index">
                    <a
                        v-if="benefit.link"
                        :href="benefit.link"
                        target="_blank"
                        class="block rounded-xl border-2 border-[#7FB69E]/20 bg-[#F8FAF9] p-6 transition-all hover:border-[#2D5F4F]/40 hover:shadow-md"
                    >
                        <div
                            class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-[#2D5F4F]"
                        >
                            <component
                                :is="benefit.icon"
                                class="h-6 w-6 text-white"
                            />
                        </div>

                        <h4 class="mb-2 font-semibold text-[#2C3E3A]">
                            {{ benefit.title }}
                        </h4>

                        <p class="text-sm leading-relaxed text-[#6B8E6F]">
                            {{ benefit.description }}
                        </p>
                    </a>

                    <div
                        v-else
                        class="rounded-xl border-2 border-[#7FB69E]/20 bg-[#F8FAF9] p-6"
                    >
                        <div
                            class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-[#2D5F4F]"
                        >
                            <component
                                :is="benefit.icon"
                                class="h-6 w-6 text-white"
                            />
                        </div>

                        <h4 class="mb-2 font-semibold text-[#2C3E3A]">
                            {{ benefit.title }}
                        </h4>

                        <p class="text-sm leading-relaxed text-[#6B8E6F]">
                            {{ benefit.description }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
