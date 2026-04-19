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
    Pagination,
    PaginationContent,
    PaginationEllipsis,
    PaginationItem,
    PaginationNext,
    PaginationPrevious,
} from '@/components/ui/pagination';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { konten } from '@/routes';
import { destroy } from '@/routes/psychologists';
import { router } from '@inertiajs/vue3';
import { Eye, Pencil, Plus, Trash, TriangleAlert } from 'lucide-vue-next';
import { ref } from 'vue';
import { toast } from 'vue-sonner';
import PsychologistAddDialog from './dialogs/PsychologistAddDialog.vue';
import PsychologistEditDialog from './dialogs/PsychologistEditDialog.vue';
import PsychologistViewDialog from './dialogs/PsychologistViewDialog.vue';

defineProps<{
    psychologists?: {
        data: any[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
        from: number;
        to: number;
    };
}>();

const showAddModal = ref(false);
const showEditModal = ref(false);
const showViewModal = ref(false);
const showDeleteDialog = ref(false);
const selectedPsychologist = ref<any>(null);

const openViewModal = (psychologist: any) => {
    selectedPsychologist.value = psychologist;
    showViewModal.value = true;
};

const openEditModal = (psychologist: any) => {
    selectedPsychologist.value = psychologist;
    showEditModal.value = true;
};

const openDeleteDialog = (psychologist: any) => {
    selectedPsychologist.value = psychologist;
    showDeleteDialog.value = true;
};

const confirmDeletePsychologist = () => {
    if (!selectedPsychologist.value) return;

    router.delete(destroy.url(selectedPsychologist.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Psikolog berhasil dihapus!', { duration: 3000 });
            showDeleteDialog.value = false;
            selectedPsychologist.value = null;
        },
        onError: () => {
            toast.error('Gagal menghapus psikolog. Coba lagi.', {
                duration: 3000,
            });
            showDeleteDialog.value = false;
            selectedPsychologist.value = null;
        },
    });
};

const goToPsychologistsPage = (page: number) => {
    router.get(
        konten().url,
        { psychologists_page: page },
        { preserveState: true, preserveScroll: true },
    );
};
</script>

<template>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Daftar Psikolog
            </h2>
            <Button @click="showAddModal = true">
                <Plus class="mr-2 h-4 w-4" />
                Tambah Psikolog
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
                            Foto
                        </TableHead>
                        <TableHead class="font-semibold text-white">
                            Nama
                        </TableHead>
                        <TableHead class="font-semibold text-white">
                            Spesialisasi
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
                        v-for="(psychologist, index) in psychologists?.data"
                        :key="
                            psychologist.id || `${psychologist.name}-${index}`
                        "
                        class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                    >
                        <TableCell
                            class="text-center font-semibold text-gray-600 dark:text-gray-400"
                        >
                            {{ (psychologists?.from || 0) + index }}
                        </TableCell>

                        <TableCell class="text-center">
                            <div class="flex justify-center">
                                <img
                                    :src="
                                        psychologist.photo_url ||
                                        psychologist.image_url ||
                                        '/images/logo_putik.webp'
                                    "
                                    :alt="psychologist.name || 'Psikolog'"
                                    class="h-16 w-16 rounded-lg border border-gray-200 object-cover shadow-sm dark:border-gray-700"
                                />
                            </div>
                        </TableCell>

                        <TableCell class="font-semibold">
                            {{ psychologist.name || '-' }}
                        </TableCell>

                        <TableCell
                            class="max-w-md text-gray-600 dark:text-gray-300"
                        >
                            <div class="line-clamp-2">
                                {{
                                    psychologist.specialization ||
                                    psychologist.speciality ||
                                    psychologist.spesialisasi ||
                                    '-'
                                }}
                            </div>
                        </TableCell>

                        <TableCell class="align-middle">
                            <div class="flex items-center justify-center gap-1">
                                <Button
                                    variant="default"
                                    size="sm"
                                    @click="openViewModal(psychologist)"
                                >
                                    <Eye class="h-4 w-4" />
                                </Button>
                                <Button
                                    variant="secondary"
                                    size="sm"
                                    class="bg-yellow-400 text-white hover:bg-yellow-400/80"
                                    @click="openEditModal(psychologist)"
                                >
                                    <Pencil class="h-4 w-4" />
                                </Button>
                                <Button
                                    variant="destructive"
                                    size="sm"
                                    @click="openDeleteDialog(psychologist)"
                                >
                                    <Trash class="h-4 w-4" />
                                </Button>
                            </div>
                        </TableCell>
                    </TableRow>

                    <TableRow
                        v-if="
                            !psychologists?.data ||
                            psychologists.data.length === 0
                        "
                    >
                        <TableCell
                            colspan="5"
                            class="py-8 text-center text-gray-500 dark:text-gray-400"
                        >
                            Belum ada data psikolog.
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>

        <div v-if="psychologists && psychologists.last_page > 1" class="mt-4">
            <div class="w-full flex-col items-center justify-between">
                <div class="mb-2 text-center text-sm text-gray-600">
                    Menampilkan {{ psychologists.from }} -
                    {{ psychologists.to }} dari
                    {{ psychologists.total }} psikolog
                </div>

                <Pagination
                    :total="psychologists.total"
                    :items-per-page="psychologists.per_page"
                    :default-page="psychologists.current_page"
                    v-slot="{ page }"
                >
                    <PaginationContent v-slot="{ items }">
                        <PaginationPrevious
                            :disabled="psychologists.current_page === 1"
                            @click="
                                goToPsychologistsPage(
                                    psychologists.current_page - 1,
                                )
                            "
                        />

                        <template v-for="(item, index) in items" :key="index">
                            <PaginationItem
                                v-if="item.type === 'page'"
                                :value="item.value"
                                :is-active="
                                    item.value === psychologists.current_page
                                "
                                @click="goToPsychologistsPage(item.value)"
                            >
                                {{ item.value }}
                            </PaginationItem>

                            <PaginationEllipsis v-else />
                        </template>

                        <PaginationNext
                            :disabled="
                                psychologists.current_page ===
                                psychologists.last_page
                            "
                            @click="
                                goToPsychologistsPage(
                                    psychologists.current_page + 1,
                                )
                            "
                        />
                    </PaginationContent>
                </Pagination>
            </div>
        </div>

        <PsychologistViewDialog
            v-model:open="showViewModal"
            :psychologist="selectedPsychologist"
        />
        <PsychologistAddDialog v-model:open="showAddModal" />
        <PsychologistEditDialog
            v-model:open="showEditModal"
            :psychologist="selectedPsychologist"
        />

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
                            Apakah Anda yakin ingin menghapus psikolog
                            <span class="font-semibold text-foreground">
                                {{ selectedPsychologist?.name }}
                            </span>
                            ?
                        </p>
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel>Batal</AlertDialogCancel>
                    <AlertDialogAction
                        class="bg-destructive hover:bg-destructive/90"
                        @click="confirmDeletePsychologist"
                    >
                        Hapus
                    </AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    </div>
</template>
