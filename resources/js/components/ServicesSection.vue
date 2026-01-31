<script setup lang="ts">
import {
    BookOpen,
    Brain,
    BriefcaseBusiness,
    GraduationCap,
    HeartHandshake,
    MessageCircle,
} from 'lucide-vue-next';

const services = [
    {
        id: 1,
        title: 'Konseling dan Terapi',
        description:
            'Memberikan segala bentuk pelayanan yang berkaitan dengan tumbuh kembang anak dan aplikasinya, remaja dan permasalahannya, dewasa, orangtua dan klinis yang dilakukan baik secara individu & kelompok.',
        icon: MessageCircle,
        images: [
            '/images/Konseling_1.png',
            '/images/Konseling_2.png',
            '/images/Konseling_3.png',
        ],
        primaryAction: 'Jadwalkan Layanan',
    },
    {
        id: 2,
        title: 'Tes Kepribadian ',
        description:
            'Memberikan segala bentuk pelayanan yang berkaitan dengan tumbuh kembang anak dan aplikasinya, remaja dan permasalahannya, dewasa, orangtua dan klinis yang dilakukan baik secara individu & kelompok.',
        icon: HeartHandshake,
        images: [
            '/images/TesKep_1.png',
            '/images/TesKep_2.png',
            '/images/TesKep_1.png',
        ],
        primaryAction: 'Jadwalkan Layanan',
    },
    {
        id: 3,
        title: 'Tes Kesiapan Masuk SD',
        description:
            'Memperoleh gambaran mengenai kematangan aspek-aspek perkembangan atau fungsi psikologis anak untuk mengikuti kegiatan pendidikan di SD.',
        icon: BookOpen,
        images: [
            '/images/TesSD_1.png',
            '/images/TesSD_2.png',
            '/images/TesSD_1.png',
        ],
        primaryAction: 'Jadwalkan Layanan',
    },
    {
        id: 4,
        title: 'Tes Penjurusan Bimbingan Karir',
        description:
            'Mencari potensi kesesuaian bakat dan minat dalam mengikuti pendidikan pada jurusan di SMA maupun Perguruan Tinggi.',
        icon: GraduationCap,
        images: [
            '/images/Penjurusan_1.png',
            '/images/Penjurusan_2.png',
            '/images/Penjurusan_1.png',
        ],
        primaryAction: 'Jadwalkan Layanan',
    },
    {
        id: 5,
        title: 'Tes Perusahaan',
        description:
            'Mencari potensi, minat dan bakat, kecakapan intelektual,emosi serta motivasi dari pribadi seseorang sesuai dengan tuntutan tugas agar nantinya tercapai kepuasan kerja.',
        icon: BriefcaseBusiness,
        images: [
            '/images/TesPer_1.png',
            '/images/TesPer_2.png',
            '/images/TesPer_1.png',
        ],
        primaryAction: 'Jadwalkan Layanan',
    },
    {
        id: 6,
        title: 'Talent Mapping',
        description:
            'Asesmen ini berguna untuk memetakan bakat alami, potensi, dan kekuatan unik seseorang melalui identifikasi urutan bakat dari yang paling dominan hingga terlemah, guna membantu menentukan karier atau jurusan yang tepat serta mengoptimalkan kinerja individu dan tim dalam organisasi.',
        icon: Brain,
        images: [
            '/images/Mapping_1.png',
            '/images/Mapping_1.png',
            '/images/Mapping_1.png',
        ],
        primaryAction: 'Jadwalkan Layanan',
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
                </div>
            </div>

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
