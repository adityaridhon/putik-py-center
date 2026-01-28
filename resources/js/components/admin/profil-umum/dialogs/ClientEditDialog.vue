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
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

const props = defineProps<{
    open: boolean;
    client: {
        id: number;
        name: string;
        location?: string;
        logo_url?: string;
    } | null;
}>();

const emit = defineEmits<{
    'update:open': [value: boolean];
}>();

const form = useForm({
    name: '',
    location: '',
    logo: null as File | null,
});

watch(
    () => props.client,
    (newClient) => {
        if (newClient) {
            form.name = newClient.name;
            form.location = newClient.location || '';
            form.logo = null;
        }
    },
    { immediate: true },
);

const submit = () => {
    if (!props.client) return;

    form.post(`/admin/clients/${props.client.id}`, {
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
                <DialogTitle>Edit Klien</DialogTitle>
                <DialogDescription>
                    Ubah informasi klien di bawah ini
                </DialogDescription>
            </DialogHeader>
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <Label>Nama Klien</Label>
                    <Input v-model="form.name" required />
                    <span v-if="form.errors.name" class="text-sm text-red-500">
                        {{ form.errors.name }}
                    </span>
                </div>
                <div>
                    <Label>Domisili</Label>
                    <Input v-model="form.location" />
                    <span
                        v-if="form.errors.location"
                        class="text-sm text-red-500"
                    >
                        {{ form.errors.location }}
                    </span>
                </div>
                <div>
                    <Label
                        >Logo Klien (Kosongkan jika tidak ingin mengubah)</Label
                    >
                    <div v-if="client?.logo_url" class="mb-2">
                        <img
                            :src="client.logo_url"
                            alt="Current"
                            class="h-20 w-20 rounded border object-cover"
                        />
                    </div>
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
