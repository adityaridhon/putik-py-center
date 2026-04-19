<script setup lang="ts">
import { bookingLayanan } from '@/routes';
import { Link } from '@inertiajs/vue3';
import {
    BookOpen,
    Brain,
    BriefcaseBusiness,
    GraduationCap,
    HeartHandshake,
    MessageCircle,
} from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
    services?: Array<{
        id: number;
        name: string;
        description: string | null;
        image_url?: string | null;
    }>;
}>();

const bookingHref = bookingLayanan().url;

// const defaultServices = [
//     {
//         id: 1,
//         title: 'Konseling dan Terapi',
//         description:
//             'Memberikan segala bentuk pelayanan yang berkaitan dengan tumbuh kembang anak dan aplikasinya, remaja dan permasalahannya, dewasa, orangtua dan klinis yang dilakukan baik secara individu & kelompok.',
//         icon: MessageCircle,
//         images: [
//             '/images/Konseling_1.png',
//             '/images/Konseling_2.png',
//             '/images/Konseling_3.png',
//         ],
//         primaryAction: 'Jadwalkan Layanan',
//     },
//     {
//         id: 2,
//         title: 'Tes Kepribadian ',
//         description:
//             'Memberikan segala bentuk pelayanan yang berkaitan dengan tumbuh kembang anak dan aplikasinya, remaja dan permasalahannya, dewasa, orangtua dan klinis yang dilakukan baik secara individu & kelompok.',
//         icon: HeartHandshake,
//         images: [
//             '/images/TesKep_1.png',
//             '/images/TesKep_2.png',
//             '/images/TesKep_1.png',
//         ],
//         primaryAction: 'Jadwalkan Layanan',
//     },
//     {
//         id: 3,
//         title: 'Tes Kesiapan Masuk SD',
//         description:
//             'Memperoleh gambaran mengenai kematangan aspek-aspek perkembangan atau fungsi psikologis anak untuk mengikuti kegiatan pendidikan di SD.',
//         icon: BookOpen,
//         images: [
//             '/images/TesSD_1.png',
//             '/images/TesSD_2.png',
//             '/images/TesSD_1.png',
//         ],
//         primaryAction: 'Jadwalkan Layanan',
//     },
//     {
//         id: 4,
//         title: 'Tes Penjurusan Bimbingan Karir',
//         description:
//             'Mencari potensi kesesuaian bakat dan minat dalam mengikuti pendidikan pada jurusan di SMA maupun Perguruan Tinggi.',
//         icon: GraduationCap,
//         images: [
//             '/images/Penjurusan_1.png',
//             '/images/Penjurusan_2.png',
//             '/images/Penjurusan_1.png',
//         ],
//         primaryAction: 'Jadwalkan Layanan',
//     },
//     {
//         id: 5,
//         title: 'Tes Perusahaan',
//         description:
//             'Mencari potensi, minat dan bakat, kecakapan intelektual,emosi serta motivasi dari pribadi seseorang sesuai dengan tuntutan tugas agar nantinya tercapai kepuasan kerja.',
//         icon: BriefcaseBusiness,
//         images: [
//             '/images/TesPer_1.png',
//             '/images/TesPer_2.png',
//             '/images/TesPer_1.png',
//         ],
//         primaryAction: 'Jadwalkan Layanan',
//     },
//     {
//         id: 6,
//         title: 'Talent Mapping',
//         description:
//             'Asesmen ini berguna untuk memetakan bakat alami, potensi, dan kekuatan unik seseorang melalui identifikasi urutan bakat dari yang paling dominan hingga terlemah, guna membantu menentukan karier atau jurusan yang tepat serta mengoptimalkan kinerja individu dan tim dalam organisasi.',
//         icon: Brain,
//         images: [
//             '/images/Mapping_1.png',
//             '/images/Mapping_1.png',
//             '/images/Mapping_1.png',
//         ],
//         primaryAction: 'Jadwalkan Layanan',
//     },
// ];

const iconList = [
    MessageCircle,
    HeartHandshake,
    BookOpen,
    GraduationCap,
    BriefcaseBusiness,
    Brain,
];

const defaultServiceImages = [
    '/images/Konseling_1.png',
    '/images/TesKep_1.png',
    '/images/TesSD_1.png',
    '/images/Penjurusan_1.png',
    '/images/TesPer_1.png',
    '/images/Mapping_1.png',
];

const serviceItems = computed(() => {
    if (props.services && props.services.length > 0) {
        return props.services.map((service, index) => ({
            id: service.id,
            title: service.name,
            description:
                service.description ||
                'Deskripsi layanan tidak tersedia. Silakan hubungi admin untuk informasi lebih lanjut.',
            icon: iconList[index % iconList.length],
            image:
                service.image_url && service.image_url.trim().length > 0
                    ? service.image_url
                    : defaultServiceImages[index % defaultServiceImages.length],
            primaryAction: 'Jadwalkan Layanan',
        }));
    }

    return [];
});
</script>

<template>
    <section
        class="space-y-16 px-4 py-8 sm:px-6 md:space-y-20 md:px-8 lg:space-y-24 lg:px-10"
    >
        <div
            v-for="service in serviceItems"
            :key="service.id"
            class="mx-auto grid max-w-7xl grid-cols-1 items-center gap-8 md:gap-10 lg:grid-cols-2 lg:gap-12"
        >
            <div
                class="flex justify-center"
                :class="service.id % 2 === 0 ? 'lg:order-2' : ''"
            >
                <div
                    class="w-full max-w-md overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-slate-200"
                >
                    <img
                        :src="service.image"
                        :alt="service.title"
                        class="h-72 w-full object-cover sm:h-80"
                    />
                </div>
            </div>

            <div class="flex flex-col justify-center">
                <div
                    class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-primary"
                >
                    <component :is="service.icon" class="h-6 w-6 text-white" />
                </div>

                <h3 class="mb-4 text-xl font-semibold sm:text-2xl">
                    {{ service.title }}
                </h3>

                <p
                    class="mb-6 max-w-xl text-sm text-slate-600 sm:mb-8 sm:text-base"
                >
                    {{ service.description }}
                </p>

                <div class="flex gap-4">
                    <Link
                        :href="bookingHref"
                        class="rounded-xl bg-primary px-5 py-3 text-sm text-white transition hover:bg-[#22352A] sm:px-6 sm:text-base"
                    >
                        {{ service.primaryAction }}
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
