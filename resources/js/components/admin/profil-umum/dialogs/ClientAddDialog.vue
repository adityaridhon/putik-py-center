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
import { store } from '@/routes/clients';
import { useForm } from '@inertiajs/vue3';

defineProps<{
    open: boolean;
}>();

const emit = defineEmits<{
    'update:open': [value: boolean];
}>();

const form = useForm({
    name: '',
    location: '',
    logo: null as File | null,
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
                <DialogTitle>Tambah Klien Baru</DialogTitle>
                <DialogDescription>
                    Isi form di bawah ini untuk menambahkan klien baru
                </DialogDescription>
            </DialogHeader>
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <Label>Nama Klien</Label>
                    <Input
                        v-model="form.name"
                        placeholder="Contoh: Pertamina"
                        required
                    />
                    <span v-if="form.errors.name" class="text-sm text-red-500">
                        {{ form.errors.name }}
                    </span>
                </div>
                <div>
                    <Label>Domisili</Label>
                    <Input
                        v-model="form.location"
                        placeholder="Contoh: Balikpapan"
                    />
                    <span
                        v-if="form.errors.location"
                        class="text-sm text-red-500"
                    >
                        {{ form.errors.location }}
                    </span>
                </div>
                <div>
                    <Label>Logo Klien</Label>
                    <Input
                        type="file"
                        accept="image/*"
                        @change="
                            form.logo =
                                ($event.target as HTMLInputElement)
                                    .files?.[0] || null
                        "
                    />
                    <span v-if="form.errors.logo" class="text-sm text-red-500">
                        {{ form.errors.logo }}
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
