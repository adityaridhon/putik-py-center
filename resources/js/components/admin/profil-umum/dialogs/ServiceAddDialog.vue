<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Checkbox } from '@/components/ui/checkbox';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { store } from '@/routes/service';
import { useForm } from '@inertiajs/vue3';

defineProps<{
    open: boolean;
}>();

const emit = defineEmits<{
    'update:open': [value: boolean];
}>();

const form = useForm({
    name: '',
    description: '',
    image: null as File | null,
    is_active: true,
});

const submit = () => {
    form.post(store.url(), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            emit('update:open', false);
            form.reset();
        },
    });
};
</script>

<template>
    <Dialog :open="open" @update:open="emit('update:open', $event)">
        <DialogContent class="max-w-2xl">
            <DialogHeader>
                <DialogTitle>Tambah Layanan Baru</DialogTitle>
                <DialogDescription>
                    Isi form di bawah ini untuk menambahkan layanan baru
                </DialogDescription>
            </DialogHeader>
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <Label>Nama Layanan</Label>
                    <Input
                        v-model="form.name"
                        placeholder="Contoh: Konseling Psikologi"
                        required
                    />
                    <span v-if="form.errors.name" class="text-sm text-red-500">
                        {{ form.errors.name }}
                    </span>
                </div>
                <div>
                    <Label>Deskripsi</Label>
                    <Textarea
                        v-model="form.description"
                        placeholder="Deskripsi layanan..."
                        class="resize-none"
                    />
                    <span
                        v-if="form.errors.description"
                        class="text-sm text-red-500"
                    >
                        {{ form.errors.description }}
                    </span>
                </div>
                <div>
                    <Label>Gambar Layanan</Label>
                    <Input
                        type="file"
                        accept="image/*"
                        @change="
                            form.image =
                                ($event.target as HTMLInputElement)
                                    .files?.[0] || null
                        "
                    />
                    <span v-if="form.errors.image" class="text-sm text-red-500">
                        {{ form.errors.image }}
                    </span>
                </div>
                <div class="flex items-center space-x-2">
                    <Checkbox
                        :checked="form.is_active"
                        @update:checked="form.is_active = $event"
                    />
                    <Label>Aktif</Label>
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
