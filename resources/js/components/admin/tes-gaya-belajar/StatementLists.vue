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
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { Pencil, Trash, TriangleAlert } from 'lucide-vue-next';
import { ref, computed } from 'vue';
import { router, useForm } from '@inertiajs/vue3';

// Terima props dari parent
const props = defineProps<{
    statements?: any;
}>();

// Fallback ke dummy data jika backend belum tersambung
const defaultStatements = [
    {
        id: 1,
        statement: 'Saya suka belajar dengan melihat gambar atau diagram.',
    },
    {
        id: 2,
        statement:
            'Saya lebih mudah mengingat sesuatu jika saya mendengarkannya.',
    },
    {
        id: 3,
        statement: 'Saya suka belajar dengan melakukan praktik langsung.',
    },
    {
        id: 4,
        statement: 'Saya lebih suka membaca daripada mendengar penjelasan.',
    },
    {
        id: 5,
        statement:
            'Saya mudah mengingat wajah orang tetapi sulit mengingat nama.',
    },
];

const statements = computed(() => props.statements?.data || defaultStatements);

// Modal states
const showEditDialog = ref(false);
const showDeleteDialog = ref(false);
const selectedStatement = ref<any>(null);

// Form state for edit
const editForm = useForm({
    statement: '',
});

const openEditDialog = (statement: any) => {
    selectedStatement.value = statement;
    editForm.statement = statement.statement;
    showEditDialog.value = true;
};

const openDeleteDialog = (statement: any) => {
    selectedStatement.value = statement;
    showDeleteDialog.value = true;
};

const handleEditSubmit = () => {
    if (!selectedStatement.value) return;
    
    if (props.statements) {
        // Real API call to backend
        editForm.put(`/admin/asesmen/gaya-belajar/${selectedStatement.value.id}`, {
            onSuccess: () => {
                showEditDialog.value = false;
                selectedStatement.value = null;
                editForm.reset();
            }
        });
    } else {
        // Fallback: Update dummy data locally
        console.log('Edit statement (offline):', editForm.statement);
        showEditDialog.value = false;
        selectedStatement.value = null;
        editForm.reset();
    }
};

const confirmDeleteStatement = () => {
    if (!selectedStatement.value) return;
    
    if (props.statements) {
        // Real API call to backend
        router.delete(`/admin/asesmen/gaya-belajar/${selectedStatement.value.id}`, {
            onSuccess: () => {
                showDeleteDialog.value = false;
                selectedStatement.value = null;
            }
        });
    } else {
        // Fallback: Remove from dummy data locally
        console.log('Delete statement (offline):', selectedStatement.value);
        showDeleteDialog.value = false;
        selectedStatement.value = null;
    }
};

const addNewStatement = () => {
    // TODO: Implement add new statement
    console.log('Add new statement');
};
</script>

<template>
    <div class="space-y-4">
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
                        <TableHead class="text-white"> Pernyataan </TableHead>

                        <TableHead
                            class="w-32 text-center font-semibold text-white"
                        >
                            Aksi
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow
                        v-for="(statement, index) in statements"
                        :key="statement.id"
                        class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                    >
                        <TableCell
                            class="text-center font-semibold text-gray-600 dark:text-gray-400"
                        >
                            {{ index + 1 }}
                        </TableCell>
                        <TableCell>
                            {{ statement.statement }}
                        </TableCell>
                        <TableCell class="align-middle">
                            <div class="flex items-center justify-center gap-1">
                                <Button
                                    variant="secondary"
                                    size="sm"
                                    class="bg-yellow-400 text-white hover:bg-yellow-400/80"
                                    @click="openEditDialog(statement)"
                                >
                                    <Pencil class="h-4 w-4" />
                                </Button>

                                <Button
                                    variant="destructive"
                                    size="sm"
                                    @click="openDeleteDialog(statement)"
                                >
                                    <Trash class="h-4 w-4" />
                                </Button>
                            </div>
                        </TableCell>
                    </TableRow>
                    <TableRow
                        v-if="!statements || statements.length === 0"
                        class="hover:bg-transparent"
                    >
                        <TableCell colspan="3" class="text-center">
                            <p class="py-4 text-gray-500">
                                Belum ada data pernyataan. Klik tombol "Tambah
                                Pernyataan" untuk menambahkan.
                            </p>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>

        <!-- Edit Dialog -->
        <Dialog v-model:open="showEditDialog">
            <DialogContent class="max-w-2xl">
                <DialogHeader>
                    <DialogTitle>Edit Pernyataan</DialogTitle>
                    <DialogDescription>
                        Ubah pernyataan di bawah ini
                    </DialogDescription>
                </DialogHeader>
                <form @submit.prevent="handleEditSubmit" class="space-y-4">
                    <div>
                        <Label>Pernyataan</Label>
                        <Input
                            v-model="editForm.statement"
                            placeholder="Masukkan pernyataan"
                            required
                            autofocus
                        />
                    </div>
                    <div class="flex justify-end gap-2 pt-4">
                        <Button
                            type="button"
                            variant="outline"
                            @click="showEditDialog = false"
                        >
                            Batal
                        </Button>
                        <Button type="submit"> Simpan Perubahan </Button>
                    </div>
                </form>
            </DialogContent>
        </Dialog>

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
                            Apakah Anda yakin ingin menghapus pernyataan ini?
                        </p>
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel>Batal</AlertDialogCancel>
                    <AlertDialogAction
                        class="bg-destructive hover:bg-destructive/90"
                        @click="confirmDeleteStatement"
                    >
                        Hapus
                    </AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    </div>
</template>
