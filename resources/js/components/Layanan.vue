<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps<{
    services?: Array<{
        id: number;
        name: string;
        description: string | null;
    }>;
}>();

const defaultItems = [
    {
        id: 1,
        judul: 'CHILDREN CENTER',
        deskripsi:
            'Memberikan segala bentuk pelayanan yang berkaitan dengan anak, yang berupa Taman Bermain',
        logo: '/images/Children_Center.png',
        color: 'bg-white',
    },
    {
        id: 2,
        judul: 'KONSELING DAN TERAPI',
        deskripsi:
            'Memberikan segala bentuk pelayanan yang berkaitan dengan tumbuh kembang anak dan aplikasinya, remaja dan permasalahannya, dewasa, orangtua dan klinis yang dilakukan baik secara individu & kelompok.',
        logo: '/images/Konseling.png',
        color: 'bg-white',
    },
    {
        id: 3,
        judul: 'PEMERIKSAAN PSIKOLOGI',
        deskripsi: `1. Tes Kepribadian
                    2. Tes Penjurusan Bimbingan Karir
                    3. Tes Kematangan Kesiapan Masuk SD
                    4. Tes Perusahaan
                    5. Tes Talent Mapping
                    6. Tes Inteligensi
                    7. Tes Gaya Belajar
                    8. Tes Minat Bakat`,
        logo: '/images/Pemeriksaan_Sikologi.png',
        color: 'bg-white',
    },
];

const logoMap = {
    1: '/images/Children_Center.png',
    2: '/images/Konseling.png',
    3: '/images/Pemeriksaan_Sikologi.png',
};

const items = computed(() => {
    if (props.services && props.services.length > 0) {
        return props.services.slice(0, 3).map((service, index) => ({
            id: service.id,
            judul: service.name.toUpperCase(),
            deskripsi:
                service.description ||
                'Deskripsi layanan tidak tersedia. Hubungi admin untuk detail lebih lanjut.',
            logo: logoMap[(index + 1) as keyof typeof logoMap] || '/images/Children_Center.png',
            color: 'bg-white',
        }));
    }

    return defaultItems;
});
</script>

<template>
    <section class="bg-gray-50 py-12 text-center">
        <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 md:px-8 lg:px-10">
            <h1 class="font-title text-3xl font-bold sm:text-4xl">
                LAYANAN KAMI
            </h1>
            <p
                class="mx-auto max-w-3xl py-6 text-sm leading-relaxed text-primary sm:text-base"
            >
                Layanan Psikologi untuk Berbagai Kebutuhan. Kami menyediakan
                berbagai layanan psikologi dengan pendekatan yang disesuaikan
                dengan kebutuhan unik setiap klien.
            </p>
            <div
                class="mx-auto grid max-w-5xl grid-cols-1 gap-8 md:grid-cols-3 md:gap-8"
            >
                <div
                    v-for="item in items"
                    :key="item.judul"
                    :class="`rounded-2xl p-7 shadow-lg ${item.color} transform cursor-pointer transition duration-300 hover:-translate-y-2 hover:scale-[1.02] hover:shadow-2xl`"
                >
                    <img
                        :src="item.logo"
                        :alt="item.judul"
                        class="mx-auto mb-3 w-14"
                    />
                    <h3
                        class="font-primary mb-1 text-xl font-bold text-primary"
                    >
                        {{ item.judul }}
                    </h3>
                    <p
                        class="mx-auto max-w-md text-center text-sm whitespace-pre-line text-primary"
                    >
                        {{ item.deskripsi }}
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
