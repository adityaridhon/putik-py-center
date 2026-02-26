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
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { edit } from '@/routes/intelegensi';
import { Link, router } from '@inertiajs/vue3';
import { Eye, Pencil, Trash, TriangleAlert } from 'lucide-vue-next';
import { computed, ref } from 'vue';

// Terima props dari parent
const props = defineProps<{
    categories?: any[];
}>();

// Dummy fallback
const defaultData = [
    {
        id: 1,
        code: 'SE',
        total_questions: 20,
        answer_type_text: 'Pilihan Ganda (Teks)',
        duration_text: '6 Menit',
    },
    {
        id: 2,
        code: 'WA',
        total_questions: 20,
        answer_type_text: 'Pilihan Ganda (Teks)',
        duration_text: '6 Menit',
    },
    {
        id: 3,
        code: 'AN',
        total_questions: 20,
        answer_type_text: 'Pilihan Ganda (Teks)',
        duration_text: '7 Menit',
    },
    {
        id: 4,
        code: 'GE',
        total_questions: 20,
        answer_type_text: 'Isian singkat',
        duration_text: '8 Menit',
    },
    {
        id: 5,
        code: 'RA',
        total_questions: 20,
        answer_type_text: '1-10 (Numerik)',
        duration_text: '10 Menit',
    },
    {
        id: 6,
        code: 'ZR',
        total_questions: 20,
        answer_type_text: '1-10 (Deret Angka)',
        duration_text: '10 Menit',
    },
    {
        id: 7,
        code: 'FA',
        total_questions: 20,
        answer_type_text: 'Pilihan Ganda (Gambar)',
        duration_text: '7 Menit',
    },
    {
        id: 8,
        code: 'WU',
        total_questions: 20,
        answer_type_text: 'Pilihan Ganda (Gambar)',
        duration_text: '9 Menit',
    },
    {
        id: 9,
        code: 'ME',
        total_questions: 20,
        answer_type_text: 'Pilihan Ganda (Memori)',
        duration_text: '6 Menit',
    },
];

const ist = computed(() => props.categories || defaultData);

// State modal
const showDeleteDialog = ref(false);
const selectedSubtest = ref<any>(null);

const openDeleteDialog = (subtest: any) => {
    selectedSubtest.value = subtest;
    showDeleteDialog.value = true;
};

const confirmDeleteSubtest = () => {
    if (!selectedSubtest.value) return;

    if (props.categories) {
        router.delete(
            `/admin/asesmen/intelegensi/${selectedSubtest.value.id}`,
            {
                onSuccess: () => {
                    showDeleteDialog.value = false;
                    selectedSubtest.value = null;
                },
            },
        );
    } else {
        alert(`Subtest ${selectedSubtest.value.code} berhasil dihapus!`);
        showDeleteDialog.value = false;
        selectedSubtest.value = null;
    }
};
</script>

<template>
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
                    <TableHead class="text-white"> Kategori </TableHead>
                    <TableHead class="text-white"> Deskripsi </TableHead>
                    <TableHead class="text-white"> Jumlah Soal </TableHead>
                    <TableHead class="text-white"> Tipe Jawaban</TableHead>
                    <TableHead class="text-white"> Durasi Pengerjaan</TableHead>
                    <TableHead
                        class="w-32 text-center font-semibold text-white"
                    >
                        Aksi
                    </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow
                    v-for="(item, index) in ist"
                    :key="item.id"
                    class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                >
                    <TableCell
                        class="text-center font-semibold text-gray-600 dark:text-gray-400"
                    >
                        {{ index + 1 }}
                    </TableCell>
                    <TableCell> {{ item.code }} </TableCell>
                    <TableCell> {{ item.description }} </TableCell>
                    <TableCell> {{ item.total_questions }} Soal </TableCell>
                    <TableCell> {{ item.answer_type_text }} </TableCell>
                    <TableCell> {{ item.duration_text }} </TableCell>
                    <TableCell class="align-middle">
                        <div class="flex items-center justify-center gap-1">
                            <Button variant="default" size="sm">
                                <Eye class="h-4 w-4" />
                            </Button>
                            <Link :href="edit(item.id).url">
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
                                @click="openDeleteDialog(item)"
                            >
                                <Trash class="h-4 w-4" />
                            </Button>
                        </div>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
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
                        Apakah Anda yakin ingin menghapus subtest
                        <strong>{{ selectedSubtest?.code }}</strong> ?
                        <br />
                        <small class="text-red-600"
                            >Semua soal dalam subtest ini akan ikut
                            terhapus.</small
                        >
                    </p>
                </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel>Batal</AlertDialogCancel>
                <AlertDialogAction
                    class="bg-destructive hover:bg-destructive/90"
                    @click="confirmDeleteSubtest"
                >
                    Hapus
                </AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
