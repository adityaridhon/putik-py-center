<script setup lang="ts">
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import ArticleChart from './ArticleChart.vue';

defineProps<{
    articles?: any[];
    articlesByCategory?: any[];
}>();

const formatDate = (dateString: string) => {
    if (!dateString) return '-';

    const date = new Date(dateString);
    return new Intl.DateTimeFormat('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    }).format(date);
};
</script>

<template>
    <div class="grid gap-4 md:grid-cols-3">
        <div
            class="col-span-2 overflow-hidden rounded-lg border border-gray-200 shadow-sm"
        >
            <Table>
                <TableHeader class="bg-primary">
                    <TableRow class="border-0 hover:bg-transparent">
                        <TableHead
                            class="w-16 text-center font-semibold text-white"
                        >
                            No
                        </TableHead>
                        <TableHead
                            class="w-32 text-center font-semibold text-white"
                            >Cover Artikel</TableHead
                        >
                        <TableHead class="max-w-48 font-semibold text-white">
                            Judul Artikel
                        </TableHead>
                        <TableHead class="font-semibold text-white">
                            Penulis
                        </TableHead>
                        <TableHead class="font-semibold text-white">
                            Tanggal Terbit
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow
                        v-for="(article, index) in articles"
                        :key="article.id"
                        class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                    >
                        <TableCell
                            class="text-center font-semibold text-gray-600 dark:text-gray-400"
                        >
                            {{ index + 1 }}
                        </TableCell>
                        <TableCell class="text-center">
                            <div class="flex justify-center">
                                <img
                                    :src="
                                        article.image_url ||
                                        '/images/logo_putik.webp'
                                    "
                                    :alt="article.title"
                                    class="h-16 w-16 rounded-lg border border-gray-200 object-cover shadow-sm dark:border-gray-700"
                                />
                            </div>
                        </TableCell>
                        <TableCell class="max-w-48 font-semibold">
                            <div class="truncate">
                                {{ article.title }}
                            </div>
                        </TableCell>
                        <TableCell class="text-gray-600">
                            {{ article.author }}
                        </TableCell>
                        <TableCell class="text-gray-600">
                            {{ formatDate(article.published_at) }}
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
        <ArticleChart :data="articlesByCategory" />
    </div>
</template>
