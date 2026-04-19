<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import Label from '@/components/ui/label/Label.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import { Category } from '@/composables/useQuestionManagement';
import { useForm } from '@inertiajs/vue3';
import { ImagePlus, LockKeyhole, Save } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const props = defineProps<{
    category: Category;
}>();

const isMemoryTest = computed(() => props.category.question_type === 'memory' || props.category.code === 'ME');
const previewImage = ref<string | null>(
    isMemoryTest.value && props.category.instruction && props.category.instruction.includes('intelligence-test') 
    ? `/storage/${props.category.instruction}` 
    : null
);

// Form inisialisasi
const form = useForm({
    // inertia tidak bisa membaca method PUT langsung pada FormData ketika upload file
    _method: 'PUT',
    instruction: props.category.instruction || '',
    instruction_file: null as File | null,
});

const handleImageUpload = (event: Event) => {
    const file = (event.target as HTMLInputElement).files?.[0];
    if (file) {
        if (file.size > 2 * 1024 * 1024) {
            alert('Maksimal ukuran file adalah 2MB.');
            return;
        }
        form.instruction_file = file;
        previewImage.value = URL.createObjectURL(file);
    }
};

const saveInstruction = () => {
    // Karena kita bawa File, kita butuh submit sebagai post untuk multipart/form-data
    form.post(`/admin/asesmen/intelegensi/${props.category.id}`, {
        preserveScroll: true,
        onSuccess: () => alert('Instruksi subtest berhasil disimpan!'),
    });
};
</script>

<template>
    <div class="space-y-4 rounded-lg bg-white p-4 border border-gray-200">
        <form @submit.prevent="saveInstruction" class="space-y-4">
            <div class="space-y-2">
                <Label for="subtest-instruction">
                    Instruksi Subtest <span class="text-red-500">*</span>
                </Label>

                <!-- Input Khusus Memori (Upload Gambar) -->
                <div v-if="isMemoryTest" class="space-y-3">
                    <div v-if="previewImage" class="relative inline-block">
                        <img :src="previewImage" class="max-w-xs rounded-lg border object-cover" />
                    </div>
                    <div>
                        <label class="flex cursor-pointer items-center gap-2 rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 px-4 py-3 transition-colors hover:border-blue-400 hover:bg-blue-50 w-max">
                            <ImagePlus class="h-5 w-5 text-gray-600" />
                            <span class="text-sm font-medium text-gray-700">Upload Gambar Instruksi (Max 2MB)</span>
                            <input type="file" accept="image/*" class="hidden" @change="handleImageUpload" />
                        </label>
                    </div>
                    <p class="text-xs text-slate-500">Gunakan rasio gambar yang sesuai agar mudah dibaca (Misal: 16:9). Gambar secara otomatis akan menjadi media hafalan untuk user pada mode ME.</p>
                </div>

                <!-- Input Biasa (Textarea) -->
                <Textarea
                    v-else
                    id="subtest-instruction"
                    v-model="form.instruction"
                    placeholder="Masukkan instruksi subtest"
                    class="h-20 resize-none"
                    required
                />

                <!-- Info Waktu -->
                <div class="flex items-center gap-2 rounded-md border border-green-200 bg-green-50 p-2 text-green-800">
                    <LockKeyhole class="h-4 w-4" />
                    <h1 class="text-sm">Durasi baca instruksi adalah 3 menit</h1>
                </div>
            </div>

            <Button type="submit" :disabled="form.processing" size="sm">
                <Save class="mr-2 h-4 w-4" />
                {{ form.processing ? 'Menyimpan...' : 'Simpan Instruksi' }}
            </Button>
        </form>
    </div>
</template>
