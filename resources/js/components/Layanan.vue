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
        judul: 'KONSELING DAN TERAPI',
        deskripsi: `
        1. Tes Kepribadian
        2. Tes Penjurusan Bimbingan Karir
        3. Tes Kematangan Kesiapan Masuk SD
        4. Tes Perusahaan
        5. Tes Talent Mapping
        6. Tes Inteligensi
        7. Tes Gaya Belajar
        8. Tes Minat Bakat
    `,
        logo: '/images/Pemeriksaan_Sikologi.png',
        color: 'bg-white',
    },
];
</script>

<template>
    <section class="py-12 text-center">
        <div
            class="mx-auto grid max-w-4xl grid-cols-1 gap-12 px-6 sm:px-8 md:gap-8 lg:px-4"
        >
            <div
                v-for="item in items"
                :key="item.judul"
                :class="`rounded-2xl p-6 shadow-lg ${item.color} transform cursor-pointer transition duration-300 hover:-translate-y-2 hover:scale-[1.02] hover:shadow-2xl`"
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
                    class="whitespace-pre-line text-primar"
                    :class="
                        item.judul === 'Visi' ? 'mt-6 text-center' : 'text-left'
                    "
                >
                    {{ item.deskripsi }}
                </p>
            </div>
        </div>
    </section>
</template>
