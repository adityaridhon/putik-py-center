<script setup lang="ts">
const items = [
    {
        judul: 'CHILDREN CENTER',
        deskripsi:
            'Memberikan segala bentuk pelayanan yang berkaitan dengan anak, yang berupa Taman Bermain',
        logo: '/images/Children_Center.png',
        color: 'bg-white',
    },
    {
        judul: 'KONSELING DAN TERAPI',
        deskripsi:
            'Memberikan segala bentuk pelayanan yang berkaitan dengan tumbuh kembang anak dan aplikasinya, remaja dan permasalahannya, dewasa, orangtua dan klinis yang dilakukan baik secara individu & kelompok.',
        logo: '/images/Konseling.png',
        color: 'bg-white',
    },
    {
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
</script>

<template>
    <section class="bg-gray-50 py-12 text-center">
        <h1 class="font-title text-4xl font-bold md:text-4xl">
            LAYANAN KAMI
        </h1>
        <p class="mx-auto grid max-w-5xl grid-cols-1 gap-12 px-6 py-8 sm:px-8 md:gap-8 lg:px-4 text-primary">
            Layanan Psikologi untuk Berbagai Kebutuhan. 
            Kami menyediakan berbagai layanan psikologi dengan pendekatan
            yang disesuaikan dengan kebutuhan unik setiap klien.
        </p>
        <div
            class="mx-auto grid max-w-5xl grid-cols-1 gap-12 px-6 sm:px-8 md:gap-8 lg:px-4"
        >
            <div
                v-for="item in items"
                :key="item.judul"
                :class="`rounded-2xl p-7 shadow-lg ${item.color} transform cursor-pointer transition duration-300 hover:-translate-y-2 hover:scale-[1.02] hover:shadow-2xl`"
            >
                <img
                    :src="item.logo"
                    :alt="item.judul"
                    class="mx-auto mb-1 w-8"
                />
                <h3 class="font-primary mb-1 text-xl font-bold text-primary">
                    {{ item.judul }}
                </h3>
                <p
                    class="mx-auto max-w-md text-center whitespace-pre-line text-primary"
                >
                    {{ item.deskripsi }}
                </p>
            </div>
        </div>
    </section>
</template>
