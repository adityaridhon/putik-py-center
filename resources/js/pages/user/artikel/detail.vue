<script setup lang="ts">
import ArtikelContent from '@/components/ArtikelContent.vue';
import ArtikelHero from '@/components/ArtikelHero.vue';
import ArtikelTerkait from '@/components/ArtikelTerkait.vue';
import Footer from '@/components/Footer.vue';
import Navbar from '@/components/Navbar.vue';
import PageHeader from '@/components/PageHeader.vue';
import { FileText } from 'lucide-vue-next';

type ArticleCard = {
    judul: string;
    deskripsi: string;
    gambar: string;
    kategori: string;
    tanggal: string;
    slug: string;
    file_path_url?: string | null;
    penulis?: string;
};

defineProps<{
    article: ArticleCard;
    articles: ArticleCard[];
}>();
</script>

<template>
    <Navbar />
    <section class="py-18">
        <PageHeader title="Detail Artikel" :back-url="-1" />
        <div
            class="mx-auto w-full max-w-4xl space-y-8 px-4 py-8 sm:px-6 sm:py-10 md:px-8"
        >
            <ArtikelHero :article="article" />

            <div
                class="prose prose-lg max-w-none rounded-lg bg-white p-6 shadow-sm sm:p-8"
            >
                <ArtikelContent :article="article" />

                <!-- PDF Viewer Section -->
                <div v-if="article.file_path_url" class="border-t pt-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">File Artikel</h3>
                    <div class="rounded-lg border border-gray-200 overflow-hidden bg-gray-50">
                        <iframe
                            :src="article.file_path_url"
                            class="w-full h-96 rounded-lg"
                            title="PDF Artikel"
                        />
                    </div>
                    <div class="mt-4">
                        <a
                            :href="article.file_path_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-lg hover:bg-emerald-200 transition font-medium"
                        >
                            <FileText class="w-5 h-5" />
                            Buka PDF di Tab Baru
                        </a>
                    </div>
                </div>
            </div>

            <ArtikelTerkait :articles="articles" />
        </div>
    </section>
    <Footer />
</template>
