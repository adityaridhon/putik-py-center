<script setup lang="ts">
import { Award, Shield, Users } from 'lucide-vue-next';

const benefits = [
    {
        icon: Shield,
        title: 'Profesional & Resmi',
        description:
            'Seluruh layanan diasuh oleh Psikolog dan tim yang memiliki Izin Praktek (SIPP) serta terdaftar resmi di HIMPSI',
    },
    {
        icon: Users,
        title: 'Berpengalaman',
        description:
            'Telah hadir melayani masyarakat Balikpapan sejak 2 Juni 2006, kami memahami kebutuhan psikologis lokal dengan mendalam',
    },
    {
        icon: Award,
        title: 'Layanan Terpadu',
        description:
            'Memberikan pelayanan psikologi lengkap mulai dari anak, remaja, hingga dewasa dan perusahaan dalam satu atap untuk kemudahan Anda',
    },
];
</script>

<template>
    <section class="bg-white px-14 py-8">
        <div class="mx-auto max-w-7xl px-6">
            <div class="mb-12 text-center">
                <h2 class="mb-4 text-3xl font-bold text-[#2C3E3A]">
                    MENGAPA MEMILIH KAMI?
                </h2>
                <p class="mx-auto max-w-2xl text-[#6B8E6F]">
                    Komitmen kami dalam memberikan layanan kesehatan mental
                    terbaik dengan standar profesional tertinggi
                </p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="(benefit, index) in benefits"
                    :key="index"
                    class="rounded-xl border-2 border-[#7FB69E]/20 bg-[#F8FAF9] p-6 transition-all hover:border-[#2D5F4F]/40 hover:shadow-md"
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
    </section>
</template>
