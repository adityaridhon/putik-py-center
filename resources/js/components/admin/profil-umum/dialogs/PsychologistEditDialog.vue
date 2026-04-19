<script setup lang="ts">
import PsychologistController from '@/actions/App/Http/Controllers/Admin/PsychologistController';
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
import { Form } from '@inertiajs/vue3';

import { toast } from 'vue-sonner';

const props = defineProps<{
    open: boolean;
    psychologist: {
        id: number;
        name: string;
        specialization?: string;
        photo_url?: string;
    } | null;
}>();

const emit = defineEmits<{
    'update:open': [value: boolean];
}>();

const handleSuccess = () => {
    toast.success('Psikolog berhasil diperbarui!', { duration: 3000 });
    emit('update:open', false);
};

const handleError = () => {
    toast.error('Gagal memperbarui psikolog. Coba lagi.', { duration: 3000 });
};
</script>

<template>
    <Dialog :open="open" @update:open="emit('update:open', $event)">
        <DialogContent class="max-w-2xl">
            <DialogHeader>
                <DialogTitle>Edit Psikolog</DialogTitle>
                <DialogDescription>
                    Ubah data psikolog di bawah ini
                </DialogDescription>
            </DialogHeader>

            <Form
                v-if="psychologist"
                v-bind="PsychologistController.update.form(psychologist.id)"
                preserve-scroll
                class="space-y-4"
                @success="handleSuccess"
                @error="handleError"
                v-slot="{ errors, processing }"
            >
                <div class="space-y-2">
                    <Label>Nama Psikolog</Label>
                    <Input
                        name="name"
                        :default-value="psychologist.name"
                        required
                    />
                    <span v-if="errors.name" class="text-sm text-red-500">
                        {{ errors.name }}
                    </span>
                </div>

                <div class="space-y-2">
                    <Label>Spesialisasi</Label>
                    <Input
                        name="specialization"
                        :default-value="psychologist.specialization"
                    />
                    <span
                        v-if="errors.specialization"
                        class="text-sm text-red-500"
                    >
                        {{ errors.specialization }}
                    </span>
                </div>

                <div class="space-y-2">
                    <Label>Foto (Kosongkan jika tidak ingin mengubah)</Label>
                    <div v-if="psychologist.photo_url" class="mb-2">
                        <img
                            :src="psychologist.photo_url"
                            alt="Current"
                            class="h-20 w-20 rounded border object-cover"
                        />
                    </div>
                    <Input type="file" name="photo" accept="image/*" />
                    <span v-if="errors.photo" class="text-sm text-red-500">
                        {{ errors.photo }}
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
                    <Button type="submit" :disabled="processing">
                        {{ processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                    </Button>
                </div>
            </Form>
        </DialogContent>
    </Dialog>
</template>
