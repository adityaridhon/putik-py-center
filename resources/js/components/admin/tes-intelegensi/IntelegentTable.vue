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
import { Link } from '@inertiajs/vue3';
import { Eye, Pencil, Trash, TriangleAlert } from 'lucide-vue-next';
import { ref } from 'vue';

const ist = [
    {
        no: 1,
        kategori: 'SE',
        jumlahSoal: 20,
        tipeJawaban: 'Pilihan Ganda (Teks)',
        durasi: '6 Menit',
    },
    {
        no: 2,
        kategori: 'WA',
        jumlahSoal: 20,
        tipeJawaban: 'Pilihan Ganda (Teks)',
        durasi: '6 Menit',
    },
    {
        no: 3,
        kategori: 'AN',
        jumlahSoal: 20,
        tipeJawaban: 'Pilihan Ganda (Teks)',
        durasi: '7 Menit',
    },
    {
        no: 4,
        kategori: 'GE',
        jumlahSoal: 20,
        tipeJawaban: 'Pilihan Ganda (Teks)',
        durasi: '8 Menit',
    },
    {
        no: 5,
        kategori: 'RA',
        jumlahSoal: 20,
        tipeJawaban: 'Pilihan Ganda (Numerik)',
        durasi: '10 Menit',
    },
    {
        no: 6,
        kategori: 'ZR',
        jumlahSoal: 20,
        tipeJawaban: 'Pilihan Ganda (Deret Angka)',
        durasi: '10 Menit',
    },
    {
        no: 7,
        kategori: 'FA',
        jumlahSoal: 20,
        tipeJawaban: 'Pilihan Ganda (Gambar)',
        durasi: '7 Menit',
    },
    {
        no: 8,
        kategori: 'WU',
        jumlahSoal: 20,
        tipeJawaban: 'Pilihan Ganda (Klasifikasi Kata)',
        durasi: '9 Menit',
    },
    {
        no: 9,
        kategori: 'ME',
        jumlahSoal: 20,
        tipeJawaban: 'Pilihan Ganda (Memori)',
        durasi: '6 Menit',
    },
];

// State modal
const showDeleteDialog = ref(false);
const selectedSubtest = ref<any>(null);

// Open delete dialog
const openDeleteDialog = (subtest: any) => {
    selectedSubtest.value = subtest;
    showDeleteDialog.value = true;
};

// Confirm delete (dummy function)
const confirmDeleteSubtest = () => {
    if (!selectedSubtest.value) return;

    alert(`Subtest ${selectedSubtest.value.kategori} berhasil dihapus!`);

    showDeleteDialog.value = false;
    selectedSubtest.value = null;
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
                    v-for="item in ist"
                    :key="item.no"
                    class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                >
                    <TableCell
                        class="text-center font-semibold text-gray-600 dark:text-gray-400"
                    >
                        {{ item.no }}
                    </TableCell>
                    <TableCell> {{ item.kategori }} </TableCell>
                    <TableCell> {{ item.jumlahSoal }} Soal </TableCell>
                    <TableCell> {{ item.tipeJawaban }} </TableCell>
                    <TableCell> {{ item.durasi }} </TableCell>
                    <TableCell class="align-middle">
                        <div class="flex items-center justify-center gap-1">
                            <Button variant="default" size="sm">
                                <Eye class="h-4 w-4" />
                            </Button>
                            <Link :href="edit()">
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
                <!-- <TableRow
                        v-if="!statements || statements.length === 0"
                        class="hover:bg-transparent"
                    >
                        <TableCell colspan="3" class="text-center">
                            <p class="py-4 text-gray-500">
                                Belum ada data pernyataan. Klik tombol "Tambah
                                Pernyataan" untuk menambahkan.
                            </p>
                        </TableCell>
                    </TableRow> -->
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
                        <strong>{{ selectedSubtest?.kategori }}</strong> ?
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
