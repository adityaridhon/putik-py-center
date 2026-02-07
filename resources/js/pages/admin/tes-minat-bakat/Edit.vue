<script setup lang="ts">
import PageHeader from '@/components/PageHeader.vue';
import Button from '@/components/ui/button/Button.vue';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { minatBakat } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Pencil, Plus, Trash } from 'lucide-vue-next';

const props = defineProps<{
    id: string;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Manajemen Tes Minat Bakat', href: minatBakat().url },
    { title: 'Kelola Soal', href: '#' },
];

// Helper untuk mendapatkan nama kategori berdasarkan id (A-I)
const getCategoryName = (id: string) => {
    const categoryIndex = parseInt(id);
    return String.fromCharCode(64 + categoryIndex); // 1 -> A, 2 -> B, dst.
};

// Data dummy untuk demonstrasi
// Nanti akan diganti dengan data dari backend
const instruction =
    'Pilih pekerjaan yang paling Anda minati dari daftar berikut.';
const workList = [
    { id: 1, name: 'Guru' },
    { id: 2, name: 'Dokter' },
    { id: 3, name: 'Programmer' },
    { id: 4, name: 'Desainer Grafis' },
    { id: 5, name: 'Akuntan' },
];

const handleEdit = (workId: number) => {
    console.log('Edit work:', workId);
    // TODO: Implementasi edit
};

const handleDelete = (workId: number) => {
    console.log('Delete work:', workId);
    // TODO: Implementasi delete
};

const handleAddWork = () => {
    console.log('Add new work');
    // TODO: Implementasi tambah pekerjaan baru
};

const handleSave = () => {
    console.log('Save changes');
    // TODO: Implementasi save
};
</script>

<template>
    <Head title="Kelola Soal" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <PageHeader title="Kelola Soal" :back-url="minatBakat().url" />
        <div class="flex flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <!-- Heading -->
            <div class="space-y-2">
                <h1 class="text-2xl font-bold">
                    Kategori {{ getCategoryName(id) }}
                </h1>
            </div>

            <!-- Instruksi Tes -->
            <div class="space-y-2">
                <h2 class="text-xl font-bold">Instruksi Tes</h2>
                <p class="text-sm text-gray-600">
                    Masukkan instruksi tes sesuai dengan kebutuhan tes minat dan
                    bakat
                </p>
                <Textarea
                    :model-value="instruction"
                    class="h-25 resize-none"
                    placeholder="Masukkan instruksi tes di sini..."
                />
            </div>

            <!-- Daftar Pekerjaan -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold">Daftar Pekerjaan</h2>
                    <Button variant="default" size="sm" @click="handleAddWork">
                        <Plus class="h-4 w-4" />
                        Tambah Pekerjaan
                    </Button>
                </div>

                <div
                    class="overflow-hidden rounded-lg border border-gray-200 shadow-sm"
                >
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
                                v-for="(work, index) in workList"
                                :key="work.id"
                                class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                            >
                                <TableCell
                                    class="text-center font-semibold text-gray-600 dark:text-gray-400"
                                >
                                    {{ index + 1 }}
                                </TableCell>
                                <TableCell>
                                    {{ work.name }}
                                </TableCell>
                                <TableCell class="align-middle">
                                    <div
                                        class="flex items-center justify-center gap-1"
                                    >
                                        <Button
                                            variant="secondary"
                                            size="sm"
                                            class="bg-yellow-400 text-white hover:bg-yellow-400/80"
                                            @click="handleEdit(work.id)"
                                        >
                                            <Pencil class="h-4 w-4" />
                                        </Button>
                                        <Button
                                            variant="destructive"
                                            size="sm"
                                            @click="handleDelete(work.id)"
                                        >
                                            <Trash class="h-4 w-4" />
                                        </Button>
                                    </div>
                                </TableCell>
                            </TableRow>
                            <TableRow
                                v-if="workList.length === 0"
                                class="hover:bg-transparent"
                            >
                                <TableCell colspan="3" class="text-center">
                                    <p class="py-4 text-gray-500">
                                        Belum ada data pekerjaan. Klik tombol
                                        "Tambah Pekerjaan" untuk menambahkan.
                                    </p>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="flex justify-end gap-2 p-4">
            <Button
                variant="outline"
                @click="() => $inertia.visit(minatBakat().url)"
            >
                Batal
            </Button>
            <Button @click="handleSave"> Simpan Perubahan </Button>
        </div>
    </AppLayout>
</template>
