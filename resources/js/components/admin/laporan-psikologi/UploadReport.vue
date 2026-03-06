<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Input } from '@/components/ui/input';
import { router, useForm } from '@inertiajs/vue3';
import { FileUp, FileCheck, Download } from 'lucide-vue-next';
import { ref } from 'vue';

// Props
const props = defineProps<{
    sessionId: number;
    existingReport?: {
        id: number;
        file_name: string;
        file_size: string;
        uploaded_at: string;
        uploaded_by:string;
    } | null;
}>();

const fileInput = ref<HTMLInputElement | null>(null);
const selectedFileName = ref<string>('');

const form = useForm({
    file: null as File | null,
});

const handleFileSelect = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form.file = target.files[0];
        selectedFileName.value = target.files[0].name;
    }
};

const triggerFileInput = () => {
    fileInput.value?.click();
};

const handleUpload = () => {
    if (!form.file) return;

    form.post(`/admin/laporan-psikologi/${props.sessionId}/upload`, {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            selectedFileName.value = '';
        },
    });
};

const handleDownload = () => {
    window.location.href = `/admin/laporan-psikologi/${props.sessionId}/download`;
};
</script>

<template>
    <div>
        <!-- Existing Report Display -->
        <div
            v-if="existingReport"
            class="mb-4 rounded-lg border border-green-200 bg-green-50 p-4"
        >
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-3">
                    <FileCheck class="h-8 w-8 text-green-600" />
                    <div>
                        <p class="font-semibold text-green-900">
                            Laporan sudah diunggah
                        </p>
                        <p class="text-sm text-green-700">
                            {{ existingReport.file_name }} ({{
                                existingReport.file_size
                            }})
                        </p>
                        <p class="mt-1 text-xs text-green-600">
                            Diunggah oleh {{ existingReport.uploaded_by }} pada
                            {{ existingReport.uploaded_at }}
                        </p>
                    </div>
                </div>
                <Button
                    variant="outline"
                    size="sm"
                    @click="handleDownload"
                    class="gap-2"
                >
                    <Download class="h-4 w-4" />
                    Unduh
                </Button>
            </div>
        </div>

        <!-- Upload Form -->
        <div class="rounded-xl border-2 border-dashed border-gray-300 p-6">
            <div class="flex flex-col items-center justify-center gap-4">
                <FileUp class="h-15 w-15 text-primary" />

                <div class="w-full max-w-md space-y-4">
                    <!-- File Input (Hidden) -->
                    <input
                        ref="fileInput"
                        type="file"
                        accept=".pdf"
                        @change="handleFileSelect"
                        class="hidden"
                    />

                    <!-- File Name Display -->
                    <div
                        v-if="selectedFileName"
                        class="rounded-lg bg-gray-100 p-3 text-center"
                    >
                        <p class="text-sm font-medium">{{ selectedFileName }}</p>
                    </div>

                    <!-- Upload Button -->
                    <Button
                        @click="triggerFileInput"
                        size="sm"
                        class="w-full"
                        :disabled="form.processing"
                    >
                        {{ existingReport ? 'Ganti Laporan' : 'Pilih File PDF' }}
                    </Button>

                    <!-- Submit Button -->
                    <Button
                        v-if="form.file"
                        @click="handleUpload"
                        class="w-full"
                        :disabled="form.processing"
                    >
                        {{
                            form.processing
                                ? 'Mengunggah...'
                                : 'Unggah Laporan'
                        }}
                    </Button>

                    <!-- Info -->
                    <p class="text-center text-xs text-gray-600">
                        <span class="text-red-500">*</span>
                        Unggah laporan psikologi berdasarkan hasil tes peserta
                        diatas dengan format file PDF. Pastikan file yang
                        diunggah sesuai dengan hasil tes yang ditampilkan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
