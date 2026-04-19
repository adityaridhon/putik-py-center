<script setup lang="ts">
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
import { store } from '@/routes/psychologists';
import { useForm } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';

defineProps<{
    open: boolean;
}>();

const emit = defineEmits<{
    'update:open': [value: boolean];
}>();

const form = useForm({
    name: '',
    specialization: '',
    photo: null as File | null,
});

const submit = () => {
    form.post(store.url(), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Psikolog berhasil ditambahkan!', { duration: 3000 });
            emit('update:open', false);
            form.reset();
        },
        onError: () => {
            toast.error('Gagal menambahkan psikolog. Coba lagi.', {
                duration: 3000,
            });
        },
    });
};
</script>

<template>
    <Dialog :open="open" @update:open="emit('update:open', $event)">
        <DialogContent class="max-w-2xl">
            <DialogHeader>
                <DialogTitle>Tambah Psikolog Baru</DialogTitle>
                <DialogDescription>
                    Isi form di bawah ini untuk menambahkan data psikolog
                </DialogDescription>
            </DialogHeader>

            <form @submit.prevent="submit" class="space-y-4">
                <div class="space-y-2">
                    <Label
                        >Nama Psikolog
                        <span class="text-red-500">*</span></Label
                    >
                    <Input
                        v-model="form.name"
                        placeholder="Contoh: Dr. Aisyah, M.Psi"
                        required
                    />
                    <span v-if="form.errors.name" class="text-sm text-red-500">
                        {{ form.errors.name }}
                    </span>
                </div>

                <div class="space-y-2">
                    <Label
                        >Spesialisasi <span class="text-red-500">*</span></Label
                    >
                    <Input
                        v-model="form.specialization"
                        placeholder="Contoh: Psikologi Klinis"
                        required
                    />
                    <span
                        v-if="form.errors.specialization"
                        class="text-sm text-red-500"
                    >
                        {{ form.errors.specialization }}
                    </span>
                </div>

                <div class="space-y-2">
                    <Label
                        >Foto Psikolog<span class="text-red-500">*</span></Label
                    >
                    <Input
                        type="file"
                        accept="image/*"
                        required
                        @change="
                            form.photo =
                                ($event.target as HTMLInputElement)
                                    .files?.[0] || null
                        "
                    />
                    <span v-if="form.errors.photo" class="text-sm text-red-500">
                        {{ form.errors.photo }}
                    </span>
                </div>

                <div class="flex justify-end gap-2 pt-4">
                    <Button
                        type="button"
                        variant="outline"
                        @click="emit('update:open', false)"
                    >
                        Batal
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Menyimpan...' : 'Simpan' }}
                    </Button>
                </div>
            </form>
        </DialogContent>
    </Dialog>
</template>
