<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { SquarePen } from 'lucide-vue-next';
import ArticleChart from './ArticleChart.vue';

const datacard = [
    {
        title: 'Artikel Draft',
        value: '12',
        icon: SquarePen,
    },
];

const articles = [
    {
        id: 1,
        judul_artikel: 'Mengenal Konseling Individual: Manfaat dan Prosesnya',
        image: '/images/logo_putik.webp',
        penulis: 'Admin Putik',
        tanggal_terbit: '14 Januari 2026',
        status: 'Terbit',
    },
    {
        id: 2,
        judul_artikel: 'Mengenal NPD',
        image: '/images/logo_putik.webp',
        penulis: 'Admin Putik',
        tanggal_terbit: '14 Januari 2026',
        status: 'Draft',
    },
    {
        id: 3,
        judul_artikel: 'Tes Psikologi: Jenis, Manfaat, dan Prosedurnya',
        image: '/images/logo_putik.webp',
        penulis: 'Admin Putik',
        tanggal_terbit: '14 Januari 2026',
        status: 'Terbit',
    },
    {
        id: 4,
        judul_artikel: 'Mengenal Konseling Individual: Manfaat dan Prosesnya',
        image: '/images/logo_putik.webp',
        penulis: 'Admin Putik',
        tanggal_terbit: '14 Januari 2026',
        status: 'Terbit',
    },
    {
        id: 5,
        judul_artikel: 'Mengenal NPD',
        image: '/images/logo_putik.webp',
        penulis: 'Admin Putik',
        tanggal_terbit: '14 Januari 2026',
        status: 'Draft',
    },
];

const getStatusVariant = (status: string) => {
    switch (status) {
        case 'Terbit':
            return 'default';
        case 'Draft':
            return 'secondary';
        case 'Batal':
            return 'destructive';
        default:
            return 'outline';
    }
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
                        <TableHead
                            class="w-32 text-center font-semibold text-white"
                            >Status</TableHead
                        >
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow
                        v-for="article in articles"
                        :key="article.id"
                        class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                    >
                        <TableCell
                            class="text-center font-semibold text-gray-600 dark:text-gray-400"
                        >
                            {{ article.id }}
                        </TableCell>
                        <TableCell class="text-center">
                            <div class="flex justify-center">
                                <img
                                    :src="article.image"
                                    :alt="article.judul_artikel"
                                    class="h-16 w-16 rounded-lg border border-gray-200 object-cover shadow-sm dark:border-gray-700"
                                />
                            </div>
                        </TableCell>
                        <TableCell class="max-w-48 font-semibold">
                            <div class="truncate">
                                {{ article.judul_artikel }}
                            </div>
                        </TableCell>
                        <TableCell class="text-gray-600">
                            {{ article.penulis }}
                        </TableCell>
                        <TableCell class="text-gray-600">
                            {{ article.tanggal_terbit }}
                        </TableCell>
                        <TableCell class="w-32 text-center">
                            <Badge :variant="getStatusVariant(article.status)">
                                {{ article.status }}
                            </Badge>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
        <ArticleChart />
    </div>
</template>
