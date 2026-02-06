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
import { Pencil, Trash } from 'lucide-vue-next';
</script>

<template>
    <h1 class="text-2xl font-bold">Daftar pekerjaan</h1>
    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
        <Table>
            <TableHeader class="bg-primary">
                <TableRow class="border-0 hover:bg-transparent">
                    <TableHead
                        class="w-16 text-center font-semibold text-white"
                    >
                        No
                    </TableHead>
                    <TableHead class="font-semibold text-white">
                        Nama Pekerjaan
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
                    class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                >
                    <TableCell
                        class="text-center font-semibold text-gray-600 dark:text-gray-400"
                        >1
                    </TableCell>
                    <TableCell class=""> 2 </TableCell>

                    <TableCell class="align-middle">
                        <div class="flex items-center justify-center gap-1">
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
</template>
