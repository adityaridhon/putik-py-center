<script setup lang="ts">
import PageHeader from '@/components/PageHeader.vue';
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
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { minatBakat } from '@/routes';
import { update as minatBakatUpdate } from '@/routes/minatBakat';
import {
    destroy as jobsDestroy,
    store as jobsStore,
    update as jobsUpdate,
} from '@/routes/minatBakat/jobs';
import { type BreadcrumbItem } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import { Pencil, Plus, Trash, TriangleAlert } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps<{
    category: any;
    jobs?: any[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Manajemen Tes Minat Bakat', href: minatBakat().url },
    { title: 'Kelola Soal', href: '#' },
];

// Form untuk update instruksi
const instructionForm = useForm({
    instruction: props.category.instruction || '',
});

// Modal state
const showJobModal = ref(false);
const isEditing = ref(false);
const editingJobId = ref<number | null>(null);
const showDeleteDialog = ref(false);
const selectedJob = ref<any>(null);

// Form untuk job (add/edit)
const jobForm = useForm({
    job_name: '',
    category_id: props.category.id,
});

const openAddModal = () => {
    isEditing.value = false;
    jobForm.reset();
    jobForm.category_id = props.category.id;
    editingJobId.value = null;
    showJobModal.value = true;
};

const openEditModal = (job: any) => {
    isEditing.value = true;
    jobForm.job_name = job.job_name;
    jobForm.category_id = props.category.id;
    editingJobId.value = job.id;
    showJobModal.value = true;
};

const submitJob = () => {
    if (isEditing.value && editingJobId.value) {
        jobForm.put(jobsUpdate(editingJobId.value).url, {
            preserveScroll: true,
            onSuccess: () => {
                showJobModal.value = false;
                jobForm.reset();
            },
        });
    } else {
        jobForm.post(jobsStore().url, {
            preserveScroll: true,
            onSuccess: () => {
                showJobModal.value = false;
                jobForm.reset();
            },
        });
    }
};

const openDeleteDialog = (job: any) => {
    selectedJob.value = job;
    showDeleteDialog.value = true;
};

const confirmDeleteJob = () => {
    if (!selectedJob.value) return;

    router.delete(jobsDestroy(selectedJob.value.id).url, {
        preserveScroll: true,
        onSuccess: () => {
            showDeleteDialog.value = false;
            selectedJob.value = null;
        },
    });
};

const saveInstruction = () => {
    instructionForm.put(minatBakatUpdate(props.category.id).url, {
        preserveScroll: true,
    });
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
                    {{ category.name }}
                </h1>
            </div>

            <!-- Instruksi Tes -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold">Instruksi Tes</h2>
                    <Button
                        size="sm"
                        @click="saveInstruction"
                        :disabled="instructionForm.processing"
                    >
                        {{
                            instructionForm.processing
                                ? 'Menyimpan...'
                                : 'Simpan Instruksi'
                        }}
                    </Button>
                </div>
                <p class="text-sm text-gray-600">
                    Masukkan instruksi tes sesuai dengan kebutuhan tes minat dan
                    bakat
                </p>
                <Textarea
                    v-model="instructionForm.instruction"
                    class="h-25 resize-none"
                    placeholder="Masukkan instruksi tes di sini..."
                />
                <span
                    v-if="instructionForm.errors.instruction"
                    class="text-sm text-red-500"
                    >{{ instructionForm.errors.instruction }}</span
                >
            </div>

            <!-- Daftar Pekerjaan (Hanya jika kategori memiliki jobs) -->
            <div v-if="category.has_jobs" class="space-y-2">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold">Daftar Pekerjaan</h2>
                    <Button variant="default" size="sm" @click="openAddModal">
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
                                v-for="(job, index) in jobs"
                                :key="job.id"
                                class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                            >
                                <TableCell
                                    class="text-center font-semibold text-gray-600 dark:text-gray-400"
                                >
                                    {{ index + 1 }}
                                </TableCell>
                                <TableCell>
                                    {{ job.job_name }}
                                </TableCell>
                                <TableCell class="align-middle">
                                    <div
                                        class="flex items-center justify-center gap-1"
                                    >
                                        <Button
                                            variant="secondary"
                                            size="sm"
                                            class="bg-yellow-400 text-white hover:bg-yellow-400/80"
                                            @click="openEditModal(job)"
                                        >
                                            <Pencil class="h-4 w-4" />
                                        </Button>
                                        <Button
                                            variant="destructive"
                                            size="sm"
                                            @click="openDeleteDialog(job)"
                                        >
                                            <Trash class="h-4 w-4" />
                                        </Button>
                                    </div>
                                </TableCell>
                            </TableRow>
                            <TableRow
                                v-if="!jobs || jobs.length === 0"
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
            <div
                v-else
                class="rounded-lg border border-yellow-200 bg-yellow-50 p-4 text-yellow-800"
            >
                <p>
                    Kategori ini adalah kategori Esai/Isian Bebas. Tidak ada
                    daftar pekerjaan yang perlu dikelola. Cukup atur instruksi
                    tes di atas.
                </p>
            </div>
        </div>

        <!-- Modal Job -->
        <Dialog v-model:open="showJobModal">
            <DialogContent class="max-w-md">
                <DialogHeader>
                    <DialogTitle>{{
                        isEditing ? 'Edit Pekerjaan' : 'Tambah Pekerjaan'
                    }}</DialogTitle>
                    <DialogDescription>
                        {{
                            isEditing
                                ? 'Ubah nama pekerjaan.'
                                : 'Masukkan nama pekerjaan baru untuk kategori ini.'
                        }}
                    </DialogDescription>
                </DialogHeader>
                <form @submit.prevent="submitJob" class="space-y-4">
                    <div>
                        <Label>Nama Pekerjaan</Label>
                        <Input
                            v-model="jobForm.job_name"
                            placeholder="Contoh: Dokter"
                            required
                            autofocus
                        />
                        <span
                            v-if="jobForm.errors.job_name"
                            class="text-sm text-red-500"
                            >{{ jobForm.errors.job_name }}</span
                        >
                    </div>
                    <div class="flex justify-end gap-2 pt-4">
                        <Button
                            type="button"
                            variant="outline"
                            @click="showJobModal = false"
                            >Batal</Button
                        >
                        <Button type="submit" :disabled="jobForm.processing">
                            {{ jobForm.processing ? 'Menyimpan...' : 'Simpan' }}
                        </Button>
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
                            Apakah Anda yakin ingin menghapus pekerjaan ini?
                        </p>
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel>Batal</AlertDialogCancel>
                    <AlertDialogAction
                        class="bg-destructive hover:bg-destructive/90"
                        @click="confirmDeleteJob"
                    >
                        Hapus
                    </AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    </AppLayout>
</template>
