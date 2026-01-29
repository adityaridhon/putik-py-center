<script setup lang="ts">
import { BookOpen, Brain, HeartHandshake } from 'lucide-vue-next';

const services = [
    {
        id: 1,
        title: 'Konseling dan Terapi',
        description:
            'Layanan konseling dan terapi profesional untuk membantu Anda mengatasi kecemasan, depresi, trauma, dan masalah hubungan.',
        icon: Brain,
        images: [
            '/images/Company_Profile.png',
            '/images/Company_Profile.png',
            '/images/Company_Profile.png',
        ],
        primaryAction: 'Jadwalkan Layanan',
        secondaryAction: 'Pelajari Lebih Lanjut',
    },
    {
        id: 2,
        title: 'Meditasi & Relaksasi',
        description:
            'Program meditasi terpandu untuk membantu menenangkan pikiran dan menjaga keseimbangan emosional.',
        icon: HeartHandshake,
        images: [
            '/images/Company_Profile.png',
            '/images/Company_Profile.png',
            '/images/Company_Profile.png',
        ],
        primaryAction: 'Mulai Meditasi',
        secondaryAction: 'Lihat Program',
    },
    {
        id: 3,
        title: 'Jurnal Harian',
        description:
            'Fitur jurnal harian untuk refleksi diri dan pemantauan kesehatan mental.',
        icon: BookOpen,
        images: [
            '/images/Company_Profile.png',
            '/images/Company_Profile.png',
            '/images/Company_Profile.png',
        ],
        primaryAction: 'Tulis Jurnal',
        secondaryAction: 'Pelajari Fitur',
    },
];
</script>

<template>
    <section class="space-y-32 px-20 py-8">
        <div
            v-for="service in services"
            :key="service.id"
            class="mx-auto grid max-w-7xl grid-cols-1 gap-12 px-6 lg:grid-cols-2"
            :class="service.id % 2 === 0 ? '' : 'lg:auto-cols-max'"
        >
            <!-- KONTEN (Tampil di kiri untuk ID ganjil, kanan untuk ID genap) -->
            <div
                class="flex flex-col justify-center"
                :class="service.id % 2 === 0 ? 'lg:order-2' : ''"
            >
                <div
                    class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100"
                >
                    <component
                        :is="service.icon"
                        class="h-6 w-6 text-emerald-600"
                    />
                </div>

                <h3 class="mb-4 text-2xl font-semibold">
                    {{ service.title }}
                </h3>

                <p class="mb-8 max-w-xl text-slate-600">
                    {{ service.description }}
                </p>

                <div class="flex gap-4">
                    <button
                        class="rounded-xl bg-emerald-600 px-6 py-3 text-white hover:bg-emerald-700"
                    >
                        {{ service.primaryAction }}
                    </button>

                    <button
                        class="rounded-xl border px-6 py-3 text-slate-700 hover:bg-slate-100"
                    >
                        {{ service.secondaryAction }}
                    </button>
                </div>
            </div>

            <!-- GAMBAR (Tampil di kanan untuk ID ganjil, kiri untuk ID genap) -->
            <div
                class="grid grid-cols-2 gap-4"
                :class="service.id % 2 === 0 ? 'lg:order-1' : ''"
            >
                <img
                    :src="service.images[0]"
                    class="col-span-2 h-64 w-full rounded-2xl object-cover"
                />
                <img
                    :src="service.images[1]"
                    class="h-56 w-full rounded-2xl object-cover"
                />
                <img
                    :src="service.images[2]"
                    class="h-56 w-full rounded-2xl object-cover"
                />
            </div>
        </div>
    </section>
</template>
