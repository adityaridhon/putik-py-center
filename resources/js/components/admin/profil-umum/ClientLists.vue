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
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Eye, Pencil, Plus, Trash } from 'lucide-vue-next';
import { router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps<{
    clients?: any[];
}>();

// State untuk modal
const showAddModal = ref(false);
const showEditModal = ref(false);
const showViewModal = ref(false);
const selectedClient = ref<any>(null);

// Form untuk tambah klien
const addForm = useForm({
    name: '',
    location: '',
    logo: null as File | null,
});

// Form untuk edit klien
const editForm = useForm({
    name: '',
    location: '',
    logo: null as File | null,
});

// Fungsi untuk membuka modal tambah
const openAddModal = () => {
    addForm.reset();
    showAddModal.value = true;
};

// Fungsi untuk membuka modal view
const openViewModal = (client: any) => {
    selectedClient.value = client;
    showViewModal.value = true;
};

// Fungsi untuk membuka modal edit
const openEditModal = (client: any) => {
    selectedClient.value = client;
    editForm.name = client.name;
    editForm.location = client.location || '';
    editForm.logo = null;
    showEditModal.value = true;
};

// Fungsi untuk submit tambah klien
const submitAdd = () => {
    addForm.post('/clients', {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            showAddModal.value = false;
            addForm.reset();
        },
    });
};

// Fungsi untuk submit edit klien
const submitEdit = () => {
    editForm.post(`/clients/${selectedClient.value.id}`, {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            showEditModal.value = false;
            editForm.reset();
        },
    });
};

// Fungsi untuk delete klien
const deleteClient = (id: number) => {
    if (confirm('Apakah Anda yakin ingin menghapus klien ini?')) {
        router.delete(`/clients/${id}`, {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Daftar Klien
            </h2>
            <Button @click="openAddModal">
                <Plus class="mr-2 h-4 w-4" />
                Tambah Klien
            </Button>
        </div>

        <div
            class="overflow-hidden rounded-lg border border-gray-200 shadow-sm dark:border-gray-800"
        >
            <Table>
                <TableHeader
                    class="bg-linear-to-r from-primary/90 to-primary/80"
                >
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
                        v-for="(client, index) in clients"
                        :key="client.id"
                        class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                    >
                        <TableCell
                            class="text-center font-semibold text-gray-600 dark:text-gray-400"
                        >
                            {{ index + 1 }}
                        </TableCell>
                        <TableCell class="text-center">
                            <div class="flex justify-center">
                                <img
                                    :src="client.logo_url || '/images/logo_putik.webp'"
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

        <!-- Modal Tambah Klien -->
        <Dialog v-model:open="showAddModal">
            <DialogContent class="max-w-2xl">
                <DialogHeader>
                    <DialogTitle>Tambah Klien Baru</DialogTitle>
                    <DialogDescription>
                        Isi form di bawah ini untuk menambahkan klien baru
                    </DialogDescription>
                </DialogHeader>
                <form @submit.prevent="submitAdd" class="space-y-4">
                    <div>
                        <Label>Nama Klien</Label>
                        <Input v-model="addForm.name" placeholder="Contoh: Pertamina" required />
                        <span v-if="addForm.errors.name" class="text-red-500 text-sm">{{ addForm.errors.name }}</span>
                    </div>
                    <div>
                        <Label>Domisili</Label>
                        <Input v-model="addForm.location" placeholder="Contoh: Balikpapan" />
                        <span v-if="addForm.errors.location" class="text-red-500 text-sm">{{ addForm.errors.location }}</span>
                    </div>
                    <div>
                        <Label>Logo Klien</Label>
                        <Input 
                            type="file" 
                            accept="image/*"
                            @change="addForm.logo = ($event.target as HTMLInputElement).files?.[0] || null"
                        />
                        <span v-if="addForm.errors.logo" class="text-red-500 text-sm">{{ addForm.errors.logo }}</span>
                    </div>
                    <div class="flex justify-end gap-2 pt-4">
                        <Button type="button" variant="outline" @click="showAddModal = false">Batal</Button>
                        <Button type="submit" :disabled="addForm.processing">
                            {{ addForm.processing ? 'Menyimpan...' : 'Simpan' }}
                        </Button>
                    </div>
                </form>
            </DialogContent>
        </Dialog>

        <!-- Modal Edit Klien -->
        <Dialog v-model:open="showEditModal">
            <DialogContent class="max-w-2xl">
                <DialogHeader>
                    <DialogTitle>Edit Klien</DialogTitle>
                    <DialogDescription>
                        Ubah informasi klien di bawah ini
                    </DialogDescription>
                </DialogHeader>
                <form @submit.prevent="submitEdit" class="space-y-4">
                    <div>
                        <Label>Nama Klien</Label>
                        <Input v-model="editForm.name" required />
                        <span v-if="editForm.errors.name" class="text-red-500 text-sm">{{ editForm.errors.name }}</span>
                    </div>
                    <div>
                        <Label>Domisili</Label>
                        <Input v-model="editForm.location" />
                        <span v-if="editForm.errors.location" class="text-red-500 text-sm">{{ editForm.errors.location }}</span>
                    </div>
                    <div>
                        <Label>Logo Klien (Kosongkan jika tidak ingin mengubah)</Label>
                        <div v-if="selectedClient?.logo_url" class="mb-2">
                            <img :src="selectedClient.logo_url" alt="Current" class="h-20 w-20 object-cover rounded border" />
                        </div>
                        <Input 
                            type="file" 
                            accept="image/*"
                            @change="editForm.logo = ($event.target as HTMLInputElement).files?.[0] || null"
                        />
                        <span v-if="editForm.errors.logo" class="text-red-500 text-sm">{{ editForm.errors.logo }}</span>
                    </div>
                    <div class="flex justify-end gap-2 pt-4">
                        <Button type="button" variant="outline" @click="showEditModal = false">Batal</Button>
                        <Button type="submit" :disabled="editForm.processing">
                            {{ editForm.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                        </Button>
                    </div>
                </form>
            </DialogContent>
        </Dialog>

        <!-- Modal View Detail Klien -->
        <Dialog v-model:open="showViewModal">
            <DialogContent class="max-w-2xl">
                <DialogHeader>
                    <DialogTitle>Detail Klien</DialogTitle>
                </DialogHeader>
                <div v-if="selectedClient" class="space-y-4">
                    <div class="flex justify-center">
                        <img 
                            :src="selectedClient.logo_url || '/images/logo_putik.webp'" 
                            :alt="selectedClient.name"
                            class="h-32 w-32 rounded-lg object-cover border shadow"
                        />
                    </div>
                    <div>
                        <Label class="text-gray-600">Nama Klien</Label>
                        <p class="text-lg font-semibold mt-1">{{ selectedClient.name }}</p>
                    </div>
                    <div>
                        <Label class="text-gray-600">Domisili</Label>
                        <p class="mt-1 text-gray-700">{{ selectedClient.location || '-' }}</p>
                    </div>
                    <div class="flex justify-end pt-4">
                        <Button @click="showViewModal = false">Tutup</Button>
                    </div>
                </div>
            </DialogContent>
        </Dialog>
    </div>
</template>
