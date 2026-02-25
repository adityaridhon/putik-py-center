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
import { detail } from '@/routes/bankSoal';
import { Link } from '@inertiajs/vue3';
import { Eye, Pencil, Trash } from 'lucide-vue-next';
</script>

<template>
    <div>
        <div
            class="overflow-hidden rounded-lg border border-gray-200 shadow-sm dark:border-gray-800"
        >
            <Table>
                <TableHeader class="bg-primary">
                    <TableRow class="border-0 hover:bg-transparent">
                        <TableHead class="text-center font-semibold text-white">
                            No
                        </TableHead>
                        <TableHead class="text-center font-semibold text-white"
                            >Jenis Tes</TableHead
                        >
                        <TableHead class="text-center font-semibold text-white">
                            Jumlah Token
                        </TableHead>
                        <TableHead class="text-center font-semibold text-white">
                            Masa Berlaku
                        </TableHead>
                        <TableHead class="text-center font-semibold text-white">
                            Catatan
                        </TableHead>
                        <TableHead
                            class="w-40 text-center font-semibold text-white"
                        >
                            Aksi
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow
                        class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                    >
                        <TableCell
                            class="text-center font-semibold text-gray-600 dark:text-gray-400"
                            >1
                        </TableCell>
                        <TableCell class="text-center"
                            >Tes Minat Bakat
                        </TableCell>
                        <TableCell class="text-center"> 5</TableCell>
                        <TableCell class="text-center"> 1 Bulan</TableCell>
                        <TableCell class="text-center">
                            SMA IT Istiqamah
                        </TableCell>
                        <TableCell class="align-middle">
                            <div class="flex items-center justify-center gap-1">
                                <Link :href="detail().url">
                                    <Button variant="default" size="sm">
                                        <Eye class="h-4 w-4" />
                                    </Button>
                                </Link>
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
