<script setup lang="ts">
import { computed } from 'vue';

type ArticleCard = {
    deskripsi: string;
};

const props = defineProps<{
    article: ArticleCard;
}>();

const plainText = computed(() =>
    props.article.deskripsi
        .replace(/<[^>]*>/g, ' ')
        .replace(/\s+/g, ' ')
        .trim(),
);
</script>

<template>
    <div class="mt-10 space-y-6 leading-relaxed text-gray-700">
        <p class="whitespace-pre-line">
            {{ plainText }}
        </p>
    </div>
</template>
