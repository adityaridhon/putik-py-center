<script setup lang="ts">
import { artikel } from '@/routes';
import { Link } from '@inertiajs/vue3';
import { ArrowRight } from 'lucide-vue-next';
import { computed } from 'vue';
const aboutcards = [
    {
        judul: 'Mengenali Tanda-Tanda Depresi pada Remaja',
        deskripsi:
            'Depresi pada remaja sering kali tidak terdeteksi karena dianggap sebagai bagian dari fase pubertas.',
        gambar: '/images/Artikel_1.jpg',
        kategori: 'Kesehatan Mental Remaja',
        tanggal: '20 Januari 2026',
        slug: 'mengenali-tanda-depresi-pada-remaja',
    },
    {
        judul: 'Mengenal Diri Lewat Jurnal Harian',
        deskripsi:
            'Tidur yang cukup bantu otakmu pulih dan bikin kamu lebih siap menghadapi hari esok.',
        gambar: '/images/Artikel_1.jpg',
        kategori: 'Kesehatan Mental Anak',
        tanggal: '18 Januari 2026',
        slug: 'mengenal-diri-lewat-jurnal-harian',
    },
    {
        judul: 'Manajemen Stres untuk Mahasiswa',
        deskripsi:
            'Tekanan akademik bisa berdampak pada kesehatan mental jika tidak dikelola dengan baik.',
        gambar: '/images/Artikel_1.jpg',
        kategori: 'Kesehatan Mental',
        tanggal: '15 Januari 2026',
        slug: 'manajemen-stres-untuk-mahasiswa',
    },
    {
        judul: 'Mengenali Tanda-Tanda Depresi pada Remaja',
        deskripsi:
            'Depresi pada remaja sering kali tidak terdeteksi karena dianggap sebagai bagian dari fase pubertas.',
        gambar: '/images/Artikel_1.jpg',
        kategori: 'Kesehatan Mental Remaja',
        tanggal: '20 Januari 2026',
        slug: 'mengenali-tanda-depresi-pada-remaja-2',
    },
    {
        judul: 'Mengenal Diri Lewat Jurnal Harian',
        deskripsi:
            'Tidur yang cukup bantu otakmu pulih dan bikin kamu lebih siap menghadapi hari esok.',
        gambar: '/images/Artikel_1.jpg',
        kategori: 'Kesehatan Mental Anak',
        tanggal: '18 Januari 2026',
        slug: 'mengenal-diri-lewat-jurnal-harian-2',
    },
    {
        judul: 'Manajemen Stres untuk Mahasiswa',
        deskripsi:
            'Tekanan akademik bisa berdampak pada kesehatan mental jika tidak dikelola dengan baik.',
        gambar: '/images/Artikel_1.jpg',
        kategori: 'Kesehatan Mental',
        tanggal: '15 Januari 2026',
        slug: 'manajemen-stres-untuk-mahasiswa-2',
    },
];

const truncate = (text: string, limit = 80) => {
    if (!text) return '';
    return text.length > limit ? `${text.slice(0, limit).trimEnd()}...` : text;
};

const props = defineProps<{
    limit?: number;
    showMoreButton?: boolean;
    hideHeader?: boolean;
}>();
const visibleCards = computed(() =>
    aboutcards.slice(0, props.limit ?? aboutcards.length),
);
</script>

<template>
    <section class="bg-white py-14 sm:py-16 md:py-20">
        <div v-if="!props.hideHeader">
            <h1
                class="font-title px-4 text-center text-3xl font-bold sm:text-4xl"
            >
                ARTIKEL
            </h1>

            <p
                class="mx-auto max-w-3xl px-4 py-6 text-center text-sm text-primary sm:text-base"
            >
                Baca artikel edukatif dari para psikolog profesional kami
                tentang berbagai topik kesehatan mental dan psikologi.
            </p>
        </div>

        <div
            class="mx-auto grid max-w-6xl grid-cols-1 gap-8 px-4 sm:px-6 md:grid-cols-2 lg:grid-cols-3"
        >
            <div
                v-for="card in visibleCards"
                :key="card.judul"
                class="group flex h-full flex-col overflow-hidden rounded-2xl bg-white shadow-md transition hover:shadow-xl"
            >
                <div class="relative">
                    <img
                        :src="card.gambar"
                        :alt="card.judul"
                        class="h-56 w-full object-cover"
                    />
                </div>

                <div class="flex flex-1 flex-col p-6 text-left">
                    <span
                        class="inline-flex w-fit items-center rounded-full bg-emerald-100 px-4 py-1 text-sm font-medium text-emerald-700"
                    >
                        {{ card.kategori }}
                    </span>

                    <h3
                        class="mt-4 text-lg font-bold text-gray-900 group-hover:text-primary"
                    >
                        {{ card.judul }}
                    </h3>

                    <p class="mt-2 line-clamp-3 text-sm text-gray-600">
                        {{ truncate(card.deskripsi, 80) }}
                    </p>

                    <div
                        class="mt-auto flex items-center justify-between pt-6 text-sm text-gray-500"
                    >
                        <div class="flex items-center gap-2">
                            <span>{{ card.tanggal }}</span>
                        </div>

                        <Link
                            :href="`/artikel/${card.slug}`"
                            class="inline-flex items-center justify-center px-4 text-primary transition-colors focus:outline-none"
                            aria-label="Baca artikel"
                        >
                            <ArrowRight />
                        </Link>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="props.showMoreButton" class="flex justify-center pt-14">
            <Link
                :href="artikel().url"
                class="rounded-full bg-primary px-6 py-3 text-sm font-semibold text-white transition hover:bg-green-900"
            >
                Lihat lebih banyak artikel
            </Link>
        </div>
    </section>
</template>
