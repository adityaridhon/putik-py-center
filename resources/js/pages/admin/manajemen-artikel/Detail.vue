<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';
import { article as articleRoute } from '@/routes';
import { edit } from '@/routes/article';
import { type BreadcrumbItem } from '@/types';
import { getCategoryColor } from '@/utils/categoryColors';
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, Calendar, Download, FileText, Pencil, User } from 'lucide-vue-next';

const props = defineProps<{
    artikel: {
        id: number;
        title: string;
        slug: string;
        author: string;
        category_id: number;
        category?: { id: number; name: string };
        description: string;
        status: 'draft' | 'published' | 'archived';
        file_path?: string;
        cover_image?: string;
        cover_image_url?: string;
        file_path_url?: string;
        published_at?: string;
        created_at?: string;
        updated_at?: string;
    };
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Manajemen Artikel', href: articleRoute().url },
    { title: 'Detail Artikel', href: '#' },
];

const formatDate = (dateString?: string) => {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    }).format(date);
};

const getStatusBadge = (status: string) => {
    const badges = {
        draft: 'bg-gray-100 text-gray-700',
        published: 'bg-green-100 text-green-700',
        archived: 'bg-red-100 text-red-700',
    };
    return badges[status as keyof typeof badges] || badges.draft;
};

const getStatusText = (status: string) => {
    const statusText = {
        draft: 'Draft',
        published: 'Dipublikasikan',
        archived: 'Diarsipkan',
    };
    return statusText[status as keyof typeof statusText] || status;
};
</script>

<template>
    <Head :title="`Detail Artikel - ${artikel.title}`" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-6">
            <!-- Header Actions -->
            <div class="flex items-center justify-between">
                <Link :href="articleRoute().url">
                    <Button variant="outline" size="sm">
                        <ArrowLeft class="mr-2 h-4 w-4" />
                        Kembali
                    </Button>
                </Link>
                <Link :href="edit.url(artikel.slug)">
                    <Button size="sm">
                        <Pencil class="mr-2 h-4 w-4" />
                        Edit Artikel
                    </Button>
                </Link>
            </div>

            <!-- Main Content -->
            <div class="grid gap-6 lg:grid-cols-3">
                <!-- Left Column - Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Cover Image -->
                    <Card>
                        <CardContent class="p-0">
                            <img
                                :src="
                                    artikel.cover_image_url ||
                                    '/images/logo_putik.webp'
                                "
                                :alt="artikel.title"
                                class="h-96 w-full rounded-t-lg object-cover"
                            />
                        </CardContent>
                    </Card>

                    <!-- Article Content -->
                    <Card>
                        <CardHeader>
                            <CardTitle class="text-3xl">
                                {{ artikel.title }}
                            </CardTitle>
                            <CardDescription class="flex items-center gap-4 text-base">
                                <span class="flex items-center gap-1">
                                    <User class="h-4 w-4" />
                                    {{ artikel.author }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <Calendar class="h-4 w-4" />
                                    {{ formatDate(artikel.published_at) }}
                                </span>
                            </CardDescription>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div>
                                <h3 class="mb-2 text-lg font-semibold">
                                    Deskripsi
                                </h3>
                                <div
                                    class="prose prose-gray max-w-none dark:prose-invert"
                                >
                                    <p class="whitespace-pre-wrap text-gray-700 dark:text-gray-300">
                                        {{ artikel.description }}
                                    </p>
                                </div>
                            </div>

                            <!-- PDF File -->
                            <div v-if="artikel.file_path" class="pt-4 border-t">
                                <h3 class="mb-3 text-lg font-semibold">
                                    File Artikel
                                </h3>
                                <a
                                    :href="`/storage/${artikel.file_path}`"
                                    target="_blank"
                                    class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 transition-colors hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700"
                                >
                                    <FileText class="h-5 w-5 text-red-500" />
                                    <span class="font-medium">
                                        Lihat File PDF
                                    </span>
                                    <Download class="ml-2 h-4 w-4" />
                                </a>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Right Column - Metadata -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Article Info -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Informasi Artikel</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <!-- Status -->
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                    Status
                                </p>
                                <span
                                    :class="[
                                        'inline-flex items-center rounded-full px-3 py-1 text-sm font-medium',
                                        getStatusBadge(artikel.status),
                                    ]"
                                >
                                    {{ getStatusText(artikel.status) }}
                                </span>
                            </div>

                            <!-- Category -->
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                    Kategori
                                </p>
                                <span
                                    :class="[
                                        'inline-flex items-center rounded-full px-3 py-1 text-sm font-medium',
                                        getCategoryColor(artikel.category_id).badge,
                                    ]"
                                >
                                    {{ artikel.category?.name || '-' }}
                                </span>
                            </div>

                            <!-- Divider -->
                            <div class="border-t border-gray-200 dark:border-gray-700"></div>

                            <!-- Dates -->
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                    Tanggal Publikasi
                                </p>
                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ formatDate(artikel.published_at) }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                    Dibuat Pada
                                </p>
                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ formatDate(artikel.created_at) }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                    Terakhir Diperbarui
                                </p>
                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ formatDate(artikel.updated_at) }}
                                </p>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>