<script setup lang="ts">
import { ArrowRight } from 'lucide-vue-next';
const aboutcards = [
    {
        judul: 'Mengenali Tanda-Tanda Depresi pada Remaja',
        deskripsi:
            'Depresi pada remaja sering kali tidak terdeteksi karena dianggap sebagai bagian dari fase pubertas.',
        gambar: '/images/Artikel_1.jpg',
        kategori: 'Kesehatan Mental Remaja',
        tanggal: '20 Januari 2026',
    },
    {
        judul: 'Mengenal Diri Lewat Jurnal Harian',
        deskripsi:
            'Tidur yang cukup bantu otakmu pulih dan bikin kamu lebih siap menghadapi hari esok.',
        gambar: '/images/Artikel_1.jpg',
        kategori: 'Kesehatan Mental Anak',
        tanggal: '18 Januari 2026',
    },
    {
        judul: 'Manajemen Stres untuk Mahasiswa',
        deskripsi:
            'Tekanan akademik bisa berdampak pada kesehatan mental jika tidak dikelola dengan baik.',
        gambar: '/images/Artikel_1.jpg',
        kategori: 'Kesehatan Mental',
        tanggal: '15 Januari 2026',
    },
];

const truncate = (text: string, limit = 80) => {
    if (!text) return '';
    return text.length > limit ? `${text.slice(0, limit).trimEnd()}...` : text;
};
</script>

<template>
    <section class="bg-gray-50 py-16">
        <h1 class="font-title text-center text-4xl font-bold">ARTIKEL</h1>

        <p class="mx-auto max-w-3xl py-6 text-center text-primary">
            Baca artikel edukatif dari para psikolog profesional kami tentang
            berbagai topik kesehatan mental dan psikologi.
        </p>

        <div
            class="mx-auto grid max-w-6xl grid-cols-1 gap-10 px-6 md:grid-cols-3"
        >
            <div
                v-for="card in aboutcards"
                :key="card.judul"
                class="group flex h-full flex-col overflow-hidden rounded-2xl bg-white shadow-md transition hover:shadow-xl"
            >
                <!-- IMAGE -->
                <div class="relative">
                    <img
                        :src="card.gambar"
                        :alt="card.judul"
                        class="h-56 w-full object-cover"
                    />
                </div>

                <!-- CONTENT -->
                <div class="flex flex-1 flex-col p-6 text-left">
                    <!-- KATEGORI -->
                    <span
                        class="inline-flex w-fit items-center rounded-full bg-emerald-100 px-4 py-1 text-sm font-medium text-emerald-700"
                    >
                        {{ card.kategori }}
                    </span>

                    <!-- TITLE -->
                    <h3
                        class="mt-4 text-lg font-bold text-gray-900 group-hover:text-primary"
                    >
                        {{ card.judul }}
                    </h3>

                    <!-- DESCRIPTION -->
                    <p class="mt-2 line-clamp-3 text-sm text-gray-600">
                        {{ truncate(card.deskripsi, 80) }}
                    </p>

                    <!-- FOOTER -->
                    <div
                        class="mt-auto flex items-center justify-between pt-6 text-sm text-gray-500"
                    >
                        <div class="flex items-center gap-2">
                            <span>{{ card.tanggal }}</span>
                        </div>

                        <!-- ARROW BUTTON -->
                        <button
                            type="button"
                            class="inline-flex items-center justify-center px-4 text-primary transition-colors focus:outline-none"
                            aria-label="Baca artikel"
                        >
                            <ArrowRight />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
