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
import { Eye, Pencil, Plus, Trash } from 'lucide-vue-next';

const services = [
    {
        id: 1,
        image: '/images/logo_putik.webp',
        nama: 'Pertamina',
        domisili: 'Balikpapan',
    },
    {
        id: 2,
        image: '/images/logo_putik.webp',
        nama: 'Astra ',
        domisili: 'Balikpapan',
    },
    {
        id: 3,
        image: '/images/logo_putik.webp',
        nama: 'SMP Patra Dharma',
        domisili: 'Balikpapan',
    },
];
</script>

<template>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Daftar Klien
            </h2>
            <Button>
                <Plus class="mr-2 h-4 w-4" />
                Tambah Klien
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
                        >
                            Gambar
                        </TableHead>
                        <TableHead class="font-semibold text-white">
                            Nama Klien
                        </TableHead>
                        <TableHead class="font-semibold text-white">
                            Domisili Klien
                        </TableHead>
                        <TableHead
                            class="w-32 text-center font-semibold text-white"
                        >
                            Aksi
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow
                        v-for="service in services"
                        :key="service.id"
                        class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                    >
                        <TableCell
                            class="text-center font-semibold text-gray-600 dark:text-gray-400"
                        >
                            {{ service.id }}
                        </TableCell>
                        <TableCell class="text-center">
                            <div class="flex justify-center">
                                <img
                                    :src="service.image"
                                    :alt="service.nama"
                                    class="h-16 w-16 rounded-lg border border-gray-200 object-cover shadow-sm dark:border-gray-700"
                                />
                            </div>
                        </TableCell>
                        <TableCell class="font-semibold">
                            {{ service.nama }}
                        </TableCell>
                        <TableCell
                            class="max-w-md text-gray-600 dark:text-gray-300"
                        >
                            <div class="line-clamp-2">
                                {{ service.domisili }}
                            </div>
                        </TableCell>
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
    </div>
</template>
