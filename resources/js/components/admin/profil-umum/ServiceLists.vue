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
import { destroy } from '@/routes/service';
import { router } from '@inertiajs/vue3';
import { Eye, Pencil, Plus, Trash, TriangleAlert } from 'lucide-vue-next';
import { ref } from 'vue';
import ServiceAddDialog from './dialogs/ServiceAddDialog.vue';
import ServiceEditDialog from './dialogs/ServiceEditDialog.vue';
import ServiceViewDialog from './dialogs/ServiceViewDialog.vue';

const props = defineProps<{
    services?: {
        data: any[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
        from: number;
        to: number;
    };
}>();

// State untuk modal
const showAddModal = ref(false);
const showEditModal = ref(false);
const showViewModal = ref(false);
const showDeleteDialog = ref(false);
const selectedService = ref<any>(null);

// Fungsi untuk membuka modal view
const openViewModal = (service: any) => {
    selectedService.value = service;
    showViewModal.value = true;
};

// Fungsi untuk membuka modal edit
const openEditModal = (service: any) => {
    selectedService.value = service;
    showEditModal.value = true;
};

// Fungsi untuk membuka dialog delete
const openDeleteDialog = (service: any) => {
    selectedService.value = service;
    showDeleteDialog.value = true;
};

// Fungsi untuk delete layanan menggunakan wayfinder
const confirmDeleteService = () => {
    if (!selectedService.value) return;

    router.delete(destroy.url(selectedService.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            showDeleteDialog.value = false;
            selectedService.value = null;
        },
    });
};

const goToServicesPage = (page: number) => {
    router.get(
        konten().url,
        { services_page: page },
        { preserveState: true, preserveScroll: true },
    );
};
</script>

<template>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Daftar Layanan
            </h2>
            <Button @click="showAddModal = true">
                <Plus class="mr-2 h-4 w-4" />
                Tambah Layanan
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
                        <TableHead
                            class="w-32 text-center font-semibold text-white"
                        >
                            Gambar
                        </TableHead>
                        <TableHead class="font-semibold text-white">
                            Nama Layanan
                        </TableHead>
                        <TableHead class="font-semibold text-white">
                            Deskripsi
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
                        v-for="(service, index) in services?.data"
                        :key="service.id"
                        class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                    >
                        <TableCell
                            class="text-center font-semibold text-gray-600 dark:text-gray-400"
                        >
                            {{ (services?.from || 0) + index }}
                        </TableCell>
                        <TableCell class="text-center">
                            <div class="flex justify-center">
                                <img
                                    :src="
                                        service.image_url ||
                                        '/images/logo_putik.webp'
                                    "
                                    :alt="service.name"
                                    class="h-16 w-16 rounded-lg border border-gray-200 object-cover shadow-sm dark:border-gray-700"
                                />
                            </div>
                        </TableCell>
                        <TableCell class="font-semibold">
                            {{ service.name }}
                        </TableCell>
                        <TableCell
                            class="max-w-md text-gray-600 dark:text-gray-300"
                        >
                            <div class="line-clamp-2">
                                {{ service.description }}
                            </div>
                        </TableCell>
                        <TableCell class="align-middle">
                            <div class="flex items-center justify-center gap-1">
                                <Button
                                    variant="default"
                                    size="sm"
                                    @click="openViewModal(service)"
                                >
                                    <Eye class="h-4 w-4" />
                                </Button>
                                <Button
                                    variant="secondary"
                                    size="sm"
                                    class="bg-yellow-400 text-white hover:bg-yellow-400/80"
                                    @click="openEditModal(service)"
                                >
                                    <Pencil class="h-4 w-4" />
                                </Button>
                                <Button
                                    variant="destructive"
                                    size="sm"
                                    @click="openDeleteDialog(service)"
                                >
                                    <Trash class="h-4 w-4" />
                                </Button>
                            </div>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>

        <!-- Pagination -->
        <div v-if="services && services.last_page > 1" class="mt-4">
            <div class="w-full flex-col items-center justify-between">
                <div class="mb-2 text-center text-sm text-gray-600">
                    Menampilkan {{ services.from }} - {{ services.to }} dari
                    {{ services.total }} layanan
                </div>

                <Pagination
                    :total="services.total"
                    :items-per-page="services.per_page"
                    :default-page="services.current_page"
                    v-slot="{ page }"
                >
                    <PaginationContent v-slot="{ items }">
                        <PaginationPrevious
                            :disabled="services.current_page === 1"
                            @click="goToServicesPage(services.current_page - 1)"
                        />

                        <template v-for="(item, index) in items" :key="index">
                            <PaginationItem
                                v-if="item.type === 'page'"
                                :value="item.value"
                                :is-active="
                                    item.value === services.current_page
                                "
                                @click="goToServicesPage(item.value)"
                            >
                                {{ item.value }}
                            </PaginationItem>

                            <PaginationEllipsis v-else />
                        </template>

                        <PaginationNext
                            :disabled="
                                services.current_page === services.last_page
                            "
                            @click="goToServicesPage(services.current_page + 1)"
                        />
                    </PaginationContent>
                </Pagination>
            </div>
        </div>

        <!-- Dialogs -->
        <ServiceViewDialog
            v-model:open="showViewModal"
            :service="selectedService"
        />
        <ServiceAddDialog v-model:open="showAddModal" />
        <ServiceEditDialog
            v-model:open="showEditModal"
            :service="selectedService"
        />

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
                            Apakah Anda yakin ingin menghapus layanan
                            <span class="font-semibold text-foreground">
                                {{ selectedService?.name }}
                            </span>
                            ?
                        </p>
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel>Batal</AlertDialogCancel>
                    <AlertDialogAction
                        class="bg-destructive hover:bg-destructive/90"
                        @click="confirmDeleteService"
                    >
                        Hapus
                    </AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    </div>
</template>
