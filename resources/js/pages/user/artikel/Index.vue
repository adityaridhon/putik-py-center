<script setup lang="ts">
import Artikel from '@/components/Artikel.vue';
import Footer from '@/components/Footer.vue';
import Navbar from '@/components/Navbar.vue';
import ScrollProgressBar from '@/components/ScrollProgressBar.vue';

import {
    Pagination,
    PaginationContent,
    PaginationEllipsis,
    PaginationItem,
    PaginationNext,
    PaginationPrevious,
} from '@/components/ui/pagination';
import { artikel } from '@/routes';
import { router } from '@inertiajs/vue3';

const props = defineProps<{
    articles: {
        data: {
            judul: string;
            deskripsi: string;
            gambar: string;
            kategori: string;
            tanggal: string;
            slug: string;
        }[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
        from: number;
        to: number;
    };
}>();

const goToArticlesPage = (page: number) => {
    router.get(
        artikel().url,
        { page: page },
        { preserveState: true, preserveScroll: true },
    );
};
</script>

<template>
    <Navbar />
    <ScrollProgressBar />
    <main class="pt-4">
        <Artikel :articles="props.articles.data" />

        <!-- Pagination -->
        <div
            v-if="props.articles && props.articles.last_page > 1"
            class="mx-auto max-w-6xl px-4 py-8 sm:px-6"
        >
            <div class="flex flex-col items-center justify-center gap-4">
                <div class="text-center text-sm text-gray-600">
                    Menampilkan {{ props.articles.from }} -
                    {{ props.articles.to }} dari
                    {{ props.articles.total }} artikel
                </div>

                <Pagination
                    :total="props.articles.total"
                    :items-per-page="props.articles.per_page"
                    :default-page="props.articles.current_page"
                    v-slot="{ page }"
                >
                    <PaginationContent v-slot="{ items }">
                        <PaginationPrevious
                            :disabled="props.articles.current_page === 1"
                            @click="
                                goToArticlesPage(
                                    props.articles.current_page - 1,
                                )
                            "
                        />

                        <template v-for="(item, index) in items" :key="index">
                            <PaginationItem
                                v-if="item.type === 'page'"
                                :value="item.value"
                                :is-active="
                                    item.value === props.articles.current_page
                                "
                                @click="goToArticlesPage(item.value)"
                            >
                                {{ item.value }}
                            </PaginationItem>

                            <PaginationEllipsis v-else />
                        </template>

                        <PaginationNext
                            :disabled="
                                props.articles.current_page ===
                                props.articles.last_page
                            "
                            @click="
                                goToArticlesPage(
                                    props.articles.current_page + 1,
                                )
                            "
                        />
                    </PaginationContent>
                </Pagination>
            </div>
        </div>
    </main>
    <Footer />
</template>
