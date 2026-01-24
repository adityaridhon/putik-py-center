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
    services?: any[];
}>();

// State untuk modal
const showAddModal = ref(false);
const showEditModal = ref(false);
const showViewModal = ref(false);
const selectedService = ref<any>(null);

// Form untuk tambah layanan
const addForm = useForm({
    name: '',
    description: '',
    image: null as File | null,
    is_active: true,
});

// Form untuk edit layanan
const editForm = useForm({
    name: '',
    description: '',
    image: null as File | null,
    is_active: true,
});

// Fungsi untuk membuka modal tambah
const openAddModal = () => {
    addForm.reset();
    showAddModal.value = true;
};

// Fungsi untuk membuka modal view
const openViewModal = (service: any) => {
    selectedService.value = service;
    showViewModal.value = true;
};

// Fungsi untuk membuka modal edit
const openEditModal = (service: any) => {
    selectedService.value = service;
    editForm.name = service.name;
    editForm.description = service.description;
    editForm.is_active = service.is_active;
    editForm.image = null;
    showEditModal.value = true;
};

// Fungsi untuk submit tambah layanan
const submitAdd = () => {
    addForm.post('/services', {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            showAddModal.value = false;
            addForm.reset();
        },
    });
};

// Fungsi untuk submit edit layanan
const submitEdit = () => {
    editForm.post(`/services/${selectedService.value.id}`, {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            showEditModal.value = false;
            editForm.reset();
        },
    });
};

// Fungsi untuk delete layanan
const deleteService = (id: number) => {
    if (confirm('Apakah Anda yakin ingin menghapus layanan ini?')) {
        router.delete(`/services/${id}`, {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Daftar Layanan
            </h2>
            <Button @click="openAddModal">
                <Plus class="mr-2 h-4 w-4" />
                Tambah Layanan
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
                        v-for="(service, index) in services"
                        :key="service.id"
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
                                    :src="service.image_url || '/images/logo_putik.webp'"
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
                                    @click="deleteService(service.id)"
                                >
                                    <Trash class="h-4 w-4" />
                                </Button>
                            </div>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>

        <!-- Modal Tambah Layanan -->
        <Dialog v-model:open="showAddModal">
            <DialogContent class="max-w-2xl">
                <DialogHeader>
                    <DialogTitle>Tambah Layanan Baru</DialogTitle>
                    <DialogDescription>
                        Isi form di bawah ini untuk menambahkan layanan baru
                    </DialogDescription>
                </DialogHeader>
                <form @submit.prevent="submitAdd" class="space-y-4">
                    <div>
                        <Label>Nama Layanan</Label>
                        <Input v-model="addForm.name" placeholder="Contoh: Konseling Individual" required />
                        <span v-if="addForm.errors.name" class="text-red-500 text-sm">{{ addForm.errors.name }}</span>
                    </div>
                    <div>
                        <Label>Deskripsi</Label>
                        <textarea 
                            v-model="addForm.description" 
                            rows="4" 
                            class="flex min-h-[80px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
                            placeholder="Deskripsi lengkap layanan..."
                        ></textarea>
                        <span v-if="addForm.errors.description" class="text-red-500 text-sm">{{ addForm.errors.description }}</span>
                    </div>
                    <div>
                        <Label>Gambar Layanan</Label>
                        <Input 
                            type="file" 
                            accept="image/*"
                            @change="addForm.image = ($event.target as HTMLInputElement).files?.[0] || null"
                        />
                        <span v-if="addForm.errors.image" class="text-red-500 text-sm">{{ addForm.errors.image }}</span>
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

        <!-- Modal Edit Layanan -->
        <Dialog v-model:open="showEditModal">
            <DialogContent class="max-w-2xl">
                <DialogHeader>
                    <DialogTitle>Edit Layanan</DialogTitle>
                    <DialogDescription>
                        Ubah informasi layanan di bawah ini
                    </DialogDescription>
                </DialogHeader>
                <form @submit.prevent="submitEdit" class="space-y-4">
                    <div>
                        <Label>Nama Layanan</Label>
                        <Input v-model="editForm.name" required />
                        <span v-if="editForm.errors.name" class="text-red-500 text-sm">{{ editForm.errors.name }}</span>
                    </div>
                    <div>
                        <Label>Deskripsi</Label>
                        <textarea 
                            v-model="editForm.description" 
                            rows="4" 
                            class="flex min-h-[80px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
                        ></textarea>
                        <span v-if="editForm.errors.description" class="text-red-500 text-sm">{{ editForm.errors.description }}</span>
                    </div>
                    <div>
                        <Label>Gambar Layanan (Kosongkan jika tidak ingin mengubah)</Label>
                        <div v-if="selectedService?.image_url" class="mb-2">
                            <img :src="selectedService.image_url" alt="Current" class="h-20 w-20 object-cover rounded border" />
                        </div>
                        <Input 
                            type="file" 
                            accept="image/*"
                            @change="editForm.image = ($event.target as HTMLInputElement).files?.[0] || null"
                        />
                        <span v-if="editForm.errors.image" class="text-red-500 text-sm">{{ editForm.errors.image }}</span>
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

        <!-- Modal View Detail Layanan -->
        <Dialog v-model:open="showViewModal">
            <DialogContent class="max-w-2xl">
                <DialogHeader>
                    <DialogTitle>Detail Layanan</DialogTitle>
                </DialogHeader>
                <div v-if="selectedService" class="space-y-4">
                    <div class="flex justify-center">
                        <img 
                            :src="selectedService.image_url || '/images/logo_putik.webp'" 
                            :alt="selectedService.name"
                            class="h-32 w-32 rounded-lg object-cover border shadow"
                        />
                    </div>
                    <div>
                        <Label class="text-gray-600">Nama Layanan</Label>
                        <p class="text-lg font-semibold mt-1">{{ selectedService.name }}</p>
                    </div>
                    <div>
                        <Label class="text-gray-600">Deskripsi</Label>
                        <p class="mt-1 text-gray-700">{{ selectedService.description }}</p>
                    </div>
                    <div>
                        <Label class="text-gray-600">Status</Label>
                        <p class="mt-1">
                            <span :class="selectedService.is_active ? 'text-green-600' : 'text-red-600'" class="font-semibold">
                                {{ selectedService.is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </p>
                    </div>
                    <div class="flex justify-end pt-4">
                        <Button @click="showViewModal = false">Tutup</Button>
                    </div>
                </div>
            </DialogContent>
        </Dialog>
    </div>
</template>
