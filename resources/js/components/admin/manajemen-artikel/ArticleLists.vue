<script setup lang="ts">
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import Button from '@/components/ui/button/Button.vue';
import {
    Pagination,
    PaginationContent,
    PaginationEllipsis,
    PaginationItem,
    PaginationNext,
    PaginationPrevious,
} from '@/components/ui/pagination';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { article } from '@/routes';
import { create, destroy, edit, show } from '@/routes/article';
import { getCategoryColor } from '@/utils/categoryColors';
import { Link, router } from '@inertiajs/vue3';
import { Eye, Pencil, Plus, Trash, TriangleAlert } from 'lucide-vue-next';
import { ref } from 'vue';

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

// State modal
const showDeleteDialog = ref(false);

const selectedArticle = ref<any>(null);

const openDeleteDialog = (article: any) => {
    selectedArticle.value = article;
    showDeleteDialog.value = true;
};

const confirmDeleteArticle = () => {
    if (!selectedArticle.value) return;

    router.delete(destroy.url(selectedArticle.value.slug), {
        onSuccess: () => {
            showDeleteDialog.value = false;
            selectedArticle.value = null;
        },
    });
};

const goToArticlesPage = (page: number) => {
    router.get(
        article().url,
        { page: page },
        { preserveState: true, preserveScroll: true },
    );
};

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
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Daftar Artikel
            </h2>
            <Link :href="create.url()">
                <Button>
                    <Plus class="mr-2 h-4 w-4" />
                    Tambah Artikel
                </Button>
            </Link>
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
                        <TableHead
                            class="w-32 text-center font-semibold text-white"
                            >Kategori</TableHead
                        >
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
                            {{ formatDate(article.published_at) }}
                        </TableCell>
                        <TableCell class="w-32 text-center">
                            <span
                                :class="[
                                    'inline-flex items-center rounded-full px-3 py-1 text-sm font-medium',
                                    getCategoryColor(article.category_id).badge,
                                ]"
                            >
                                {{ article.category?.name || '-' }}
                            </span>
                        </TableCell>
                        <TableCell class="align-middle">
                            <div class="flex items-center justify-center gap-1">
                                <Link :href="show.url(article.slug)">
                                    <Button variant="default" size="sm">
                                        <Eye class="h-4 w-4" />
                                    </Button>
                                </Link>
                                <Link :href="edit.url(article.slug)">
                                    <Button
                                        variant="secondary"
                                        size="sm"
                                        class="bg-yellow-400 text-white hover:bg-yellow-400/80"
                                    >
                                        <Pencil class="h-4 w-4" />
                                    </Button>
                                </Link>
                                <Button
                                    variant="destructive"
                                    size="sm"
                                    @click="openDeleteDialog(article)"
                                >
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
            <div class="w-full flex-col items-center justify-between">
                <div class="mb-2 text-center text-sm text-gray-600">
                    Menampilkan {{ articles.from }} - {{ articles.to }} dari
                    {{ articles.total }} artikel
                </div>

                <Pagination
                    :total="articles.total"
                    :items-per-page="articles.per_page"
                    :default-page="articles.current_page"
                    v-slot="{ page }"
                >
                    <PaginationContent v-slot="{ items }">
                        <PaginationPrevious
                            :disabled="articles.current_page === 1"
                            @click="goToArticlesPage(articles.current_page - 1)"
                        />

                        <template v-for="(item, index) in items" :key="index">
                            <PaginationItem
                                v-if="item.type === 'page'"
                                :value="item.value"
                                :is-active="
                                    item.value === articles.current_page
                                "
                                @click="goToArticlesPage(item.value)"
                            >
                                {{ item.value }}
                            </PaginationItem>

                            <PaginationEllipsis v-else />
                        </template>

                        <PaginationNext
                            :disabled="
                                articles.current_page === articles.last_page
                            "
                            @click="goToArticlesPage(articles.current_page + 1)"
                        />
                    </PaginationContent>
                </Pagination>
            </div>
        </div>

        <!-- Delete Confirmation Dialog -->
        <AlertDialog v-model:open="showDeleteDialog">
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>Konfirmasi Penghapusan</AlertDialogTitle>
                    <AlertDialogDescription class="text-center">
                        <TriangleAlert
                            class="mx-auto mb-4 h-24 w-24 text-yellow-400"
                        />
                        <p
                            class="rounded-md border border-red-200 bg-red-50 p-4 text-red-700"
                        >
                            Apakah Anda yakin ingin menghapus artikel ini ?
                        </p>
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel>Batal</AlertDialogCancel>
                    <AlertDialogAction
                        class="bg-destructive hover:bg-destructive/90"
                        @click="confirmDeleteArticle"
                    >
                        Hapus
                    </AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    </div>
</template>
