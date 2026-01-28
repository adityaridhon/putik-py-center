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
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

const props = defineProps<{
    open: boolean;
    service: {
        id: number;
        name: string;
        description?: string;
        image_url?: string;
        is_active: boolean;
    } | null;
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

watch(
    () => props.service,
    (newService) => {
        if (newService) {
            form.name = newService.name;
            form.description = newService.description || '';
            form.is_active = newService.is_active;
            form.image = null;
        }
    },
    { immediate: true },
);

const submit = () => {
    if (!props.service) return;

    form.post(`/admin/services/${props.service.id}`, {
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
                <DialogTitle>Edit Layanan</DialogTitle>
                <DialogDescription>
                    Ubah informasi layanan di bawah ini
                </DialogDescription>
            </DialogHeader>
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <Label>Nama Layanan</Label>
                    <Input v-model="form.name" required />
                    <span v-if="form.errors.name" class="text-sm text-red-500">
                        {{ form.errors.name }}
                    </span>
                </div>
                <div>
                    <Label>Deskripsi</Label>
                    <Textarea v-model="form.description" class="resize-none" />
                    <span
                        v-if="form.errors.description"
                        class="text-sm text-red-500"
                    >
                        {{ form.errors.description }}
                    </span>
                </div>
                <div>
                    <Label
                        >Gambar Layanan (Kosongkan jika tidak ingin
                        mengubah)</Label
                    >
                    <div v-if="service?.image_url" class="mb-2">
                        <img
                            :src="service.image_url"
                            alt="Current"
                            class="h-20 w-20 rounded border object-cover"
                        />
                    </div>
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
                        {{
                            form.processing
                                ? 'Menyimpan...'
                                : 'Simpan Perubahan'
                        }}
                    </Button>
                </div>
            </form>
        </DialogContent>
    </Dialog>
</template>
