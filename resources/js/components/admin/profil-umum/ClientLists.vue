<script setup lang="ts">
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
import { router } from '@inertiajs/vue3';
import { Eye, Pencil, Plus, Trash } from 'lucide-vue-next';
import { ref } from 'vue';
import ClientAddDialog from './dialogs/ClientAddDialog.vue';
import ClientEditDialog from './dialogs/ClientEditDialog.vue';
import ClientViewDialog from './dialogs/ClientViewDialog.vue';

defineProps<{
    clients?: {
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
const selectedClient = ref<any>(null);

// Fungsi untuk membuka modal view
const openViewModal = (client: any) => {
    selectedClient.value = client;
    showViewModal.value = true;
};

// Fungsi untuk membuka modal edit
const openEditModal = (client: any) => {
    selectedClient.value = client;
    showEditModal.value = true;
};

// Fungsi untuk delete klien
const deleteClient = (id: number) => {
    if (confirm('Apakah Anda yakin ingin menghapus klien ini?')) {
        router.delete(`/admin/clients/${id}`, {
            preserveScroll: true,
        });
    }
};

const goToClientsPage = (page: number) => {
    router.get(
        konten().url,
        { clients_page: page },
        { preserveState: true, preserveScroll: true },
    );
};
</script>

<template>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Daftar Klien
            </h2>
            <Button @click="showAddModal = true">
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
                        v-for="(client, index) in clients?.data"
                        :key="client.id"
                        class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                    >
                        <TableCell
                            class="text-center font-semibold text-gray-600 dark:text-gray-400"
                        >
                            {{ (clients?.from || 0) + index }}
                        </TableCell>
                        <TableCell class="text-center">
                            <div class="flex justify-center">
                                <img
                                    :src="
                                        client.logo_url ||
                                        '/images/logo_putik.webp'
                                    "
                                    :alt="client.name"
                                    class="h-16 w-16 rounded-lg border border-gray-200 object-cover shadow-sm dark:border-gray-700"
                                />
                            </div>
                        </TableCell>
                        <TableCell class="font-semibold">
                            {{ client.name }}
                        </TableCell>
                        <TableCell
                            class="max-w-md text-gray-600 dark:text-gray-300"
                        >
                            <div class="line-clamp-2">
                                {{ client.location || '-' }}
                            </div>
                        </TableCell>
                        <TableCell class="align-middle">
                            <div class="flex items-center justify-center gap-1">
                                <Button
                                    variant="default"
                                    size="sm"
                                    @click="openViewModal(client)"
                                >
                                    <Eye class="h-4 w-4" />
                                </Button>
                                <Button
                                    variant="secondary"
                                    size="sm"
                                    class="bg-yellow-400 text-white hover:bg-yellow-400/80"
                                    @click="openEditModal(client)"
                                >
                                    <Pencil class="h-4 w-4" />
                                </Button>
                                <Button
                                    variant="destructive"
                                    size="sm"
                                    @click="deleteClient(client.id)"
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
        <div v-if="clients && clients.last_page > 1" class="mt-4">
            <div class="w-full flex-col items-center justify-between">
                <div class="mb-2 text-center text-sm text-gray-600">
                    Menampilkan {{ clients.from }} - {{ clients.to }} dari
                    {{ clients.total }} klien
                </div>

                <Pagination
                    :total="clients.total"
                    :items-per-page="clients.per_page"
                    :default-page="clients.current_page"
                    v-slot="{ page }"
                >
                    <PaginationContent v-slot="{ items }">
                        <PaginationPrevious
                            :disabled="clients.current_page === 1"
                            @click="goToClientsPage(clients.current_page - 1)"
                        />

                        <template v-for="(item, index) in items" :key="index">
                            <PaginationItem
                                v-if="item.type === 'page'"
                                :value="item.value"
                                :is-active="item.value === clients.current_page"
                                @click="goToClientsPage(item.value)"
                            >
                                {{ item.value }}
                            </PaginationItem>

                            <PaginationEllipsis v-else />
                        </template>

                        <PaginationNext
                            :disabled="
                                clients.current_page === clients.last_page
                            "
                            @click="goToClientsPage(clients.current_page + 1)"
                        />
                    </PaginationContent>
                </Pagination>
            </div>
        </div>
        <!-- Dialogs -->
        <ClientViewDialog
            v-model:open="showViewModal"
            :client="selectedClient"
        />
        <ClientAddDialog v-model:open="showAddModal" />
        <ClientEditDialog
            v-model:open="showEditModal"
            :client="selectedClient"
        />
    </div>
</template>
