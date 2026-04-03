<script setup lang="ts">
type ArticleCard = {
    judul: string;
    gambar: string;
    kategori: string;
    tanggal: string;
};

defineProps<{
    article: ArticleCard;
}>();
</script>

<template>
    <div class="space-y-6">
        <img
            :src="article.gambar"
            :alt="article.judul"
            class="h-72 w-full rounded-2xl object-cover"
        />

        <div class="space-y-3">
            <span
                class="rounded-full bg-emerald-100 px-4 py-1 text-sm text-emerald-700"
            >
                {{ article.kategori }}
            </span>

            <h1 class="mt-5 text-4xl leading-tight font-bold text-emerald-900">
                {{ article.judul }}
            </h1>

            <p class="text-sm text-gray-500">
                {{ article.tanggal }} • 5 menit membaca
            </p>
        </div>
    </div>
</template>
