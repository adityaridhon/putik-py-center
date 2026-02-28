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
import { show, edit, destroy as destroyRoute } from '@/routes/bankSoal';
import { Link, router } from '@inertiajs/vue3';
import { Eye, Pencil, Trash } from 'lucide-vue-next';
import { type PropType } from 'vue';

export interface TestTokenBatch {
    id: number;
    test_type: string;
    total_tokens: number;
    expired_at: string;
    note?: string;
    tokens_count?: number;
}

const props = defineProps({
    batches: {
        type: Array as PropType<TestTokenBatch[]>,
        required: true,
    },
});

const handleDelete = (batch: TestTokenBatch) => {
    if (confirm('Apakah Anda yakin ingin menghapus batch ini?')) {
        router.delete(destroyRoute(batch).url);
    }
};

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('id-ID', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
    });
};

const testTypeLabel: Record<string, string> = {
    'minat-bakat': 'Tes Minat Bakat',
    'intelegensi': 'Tes Intelegensi',
    'gaya-belajar': 'Tes Gaya Belajar',
};
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
                        v-for="(batch, index) in batches"
                        :key="batch.id"
                        class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                    >
                        <TableCell
                            class="text-center font-semibold text-gray-600 dark:text-gray-400"
                            >{{ index + 1 }}
                        </TableCell>
                        <TableCell class="text-center">
                            {{ testTypeLabel[batch.test_type] || batch.test_type }}
                        </TableCell>
                        <TableCell class="text-center">
                            {{ batch.total_tokens }}
                        </TableCell>
                        <TableCell class="text-center">
                            {{ formatDate(batch.expired_at) }}
                        </TableCell>
                        <TableCell class="text-center">
                            {{ batch.note || '-' }}
                        </TableCell>
                        <TableCell class="align-middle">
                            <div class="flex items-center justify-center gap-1">
                                <Link :href="show(batch).url">
                                    <Button variant="default" size="sm">
                                        <Eye class="h-4 w-4" />
                                    </Button>
                                </Link>
                                <Link :href="edit(batch).url">
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
                                    @click="handleDelete(batch)"
                                >
                                    <Trash class="h-4 w-4" />
                                </Button>
                            </div>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
        <div
            v-if="batches.length === 0"
            class="rounded-lg border border-dashed border-gray-300 p-8 text-center dark:border-gray-700"
        >
            <p class="text-gray-500 dark:text-gray-400">
                Tidak ada data batch token.
            </p>
        </div>
    </div>
</template>
