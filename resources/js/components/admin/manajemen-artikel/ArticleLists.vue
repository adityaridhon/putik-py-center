<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { article } from '@/routes';
import { router } from '@inertiajs/vue3';
import { Eye, Pencil, Plus, Trash } from 'lucide-vue-next';

const props = defineProps<{
    articles?: {
        data: any[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
        from: number;
        to: number;
    };
}>();
</script>

<template>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Daftar Artikel
            </h2>
            <Button>
                <Plus class="mr-2 h-4 w-4" />
                Tambah Artikel
            </Button>
        </div>

        <div
            class="overflow-hidden rounded-lg border border-gray-200 shadow-sm dark:border-gray-800"
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
                        <TableHead class="font-semibold text-white">
                            Judul Artikel
                        </TableHead>
                        <TableHead class="font-semibold text-white">
                            Penulis
                        </TableHead>
                        <TableHead class="font-semibold text-white">
                            Tanggal Terbit
                        </TableHead>
                        <!-- <TableHead
                            class="w-32 text-center font-semibold text-white"
                            >Status</TableHead
                        > -->
                        <TableHead
                            class="w-32 text-center font-semibold text-white"
                        >
                            Aksi
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow
                        v-for="(article, index) in articles?.data"
                        :key="article.id"
                        class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                    >
                        <TableCell
                            class="text-center font-semibold text-gray-600 dark:text-gray-400"
                        >
                            {{ (articles?.from || 0) + index }}
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
                        <TableCell class="font-semibold">
                            {{ article.title }}
                        </TableCell>
                        <TableCell class="text-gray-600">
                            {{ article.author }}
                        </TableCell>
                        <TableCell class="text-gray-600">
                            {{ article.published_at }}
                        </TableCell>
                        <!-- <TableCell class="w-32 text-center">
                            <Badge :variant="getStatusVariant(article.status)">
                                {{ article.category_id }}
                            </Badge>
                        </TableCell> -->
                        <TableCell class="align-middle">
                            <div class="flex items-center justify-center gap-1">
                                <Button variant="default" size="sm">
                                    <Eye class="h-4 w-4" />
                                </Button>
                                <Button
                                    variant="secondary"
                                    size="sm"
                                    class="bg-yellow-400 text-white hover:bg-yellow-400/80"
                                >
                                    <Pencil class="h-4 w-4" />
                                </Button>
                                <Button variant="destructive" size="sm">
                                    <Trash class="h-4 w-4" />
                                </Button>
                            </div>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>

        <!-- Pagination -->
        <div v-if="articles && articles.last_page > 1" class="mt-4">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    Menampilkan {{ articles.from }} - {{ articles.to }} dari
                    {{ articles.total }} artikel
                </div>
                <div class="flex items-center gap-2">
                    <!-- Previous Button -->
                    <button
                        @click="
                            () =>
                                articles &&
                                router.get(
                                    article().url,
                                    { page: articles.current_page - 1 },
                                    {
                                        preserveState: true,
                                        preserveScroll: true,
                                    },
                                )
                        "
                        :disabled="articles.current_page === 1"
                        :class="[
                            'inline-flex items-center justify-center rounded-md px-3 py-2 text-sm font-medium transition-colors',
                            articles.current_page === 1
                                ? 'cursor-not-allowed bg-gray-100 text-gray-400'
                                : 'border bg-white text-gray-900 hover:bg-gray-100',
                        ]"
                    >
                        Previous
                    </button>

                    <!-- Page Numbers -->
                    <div class="flex gap-1">
                        <button
                            v-for="page in articles.last_page"
                            :key="page"
                            @click="
                                () =>
                                    router.get(
                                        article().url,
                                        { page },
                                        {
                                            preserveState: true,
                                            preserveScroll: true,
                                        },
                                    )
                            "
                            :class="[
                                'inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors',
                                'h-9 w-9',
                                page === articles.current_page
                                    ? 'bg-primary text-white hover:bg-primary/90'
                                    : 'border bg-white text-gray-900 hover:bg-gray-100',
                            ]"
                        >
                            {{ page }}
                        </button>
                    </div>

                    <!-- Next Button -->
                    <button
                        @click="
                            () =>
                                articles &&
                                router.get(
                                    article().url,
                                    { page: articles.current_page + 1 },
                                    {
                                        preserveState: true,
                                        preserveScroll: true,
                                    },
                                )
                        "
                        :disabled="articles.current_page === articles.last_page"
                        :class="[
                            'inline-flex items-center justify-center rounded-md px-3 py-2 text-sm font-medium transition-colors',
                            articles.current_page === articles.last_page
                                ? 'cursor-not-allowed bg-gray-100 text-gray-400'
                                : 'border bg-white text-gray-900 hover:bg-gray-100',
                        ]"
                    >
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
