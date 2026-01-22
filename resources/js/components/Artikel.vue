<script setup lang="ts">
const aboutcards = [
    {
        judul: 'Mengenal Diri Lewat Jurnal Harian',
        deskripsi:
            'Tidur yang cukup bantu otakmu pulih dan bikin kamu lebih siap menghadapi hari esok',
        gambar: '/images/Artikel.png',
    },
    {
        judul: 'Mengenal Diri Lewat Jurnal Harian',
        deskripsi:
            'Tidur yang cukup bantu otakmu pulih dan bikin kamu lebih siap menghadapi hari esok',
        gambar: '/images/Artikel.png',
    },
    {
        judul: 'Mengenal Diri Lewat Jurnal Harian',
        deskripsi:
            'Tidur yang cukup bantu otakmu pulih dan bikin kamu lebih siap menghadapi hari esok',
        gambar: '/images/Artikel.png',
    },
];
</script>

<template>
    <section class="py-12 text-center">
        <h1 class="font-title mb-4 text-4xl font-bold md:text-6xl">ARTIKEL</h1>
        <div
            class="mx-auto grid max-w-4xl grid-cols-1 gap-12 px-6 sm:px-8 md:grid-cols-3 md:gap-10 lg:px-4"
        >
            <div
                class="transform cursor-pointer rounded-2xl bg-white p-6 shadow-lg transition duration-300 hover:-translate-y-2 hover:scale-[1.02] hover:shadow-2xl"
                v-for="card in aboutcards"
                :key="card.judul"
            >
                <img
                    :src="card.gambar"
                    :alt="card.judul"
                    class="mx-auto mb-1 w-8"
                />
                <h3 class="font-heading mb-1 text-xl font-bold text-primary">
                    {{ card.judul }}
                </h3>
                <p class="text-gray-700">
                    {{ card.deskripsi }}
                </p>
            </div>
        </div>
    </section>
</template>
