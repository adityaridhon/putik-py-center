<script setup lang="ts">
import ClientController from '@/actions/App/Http/Controllers/Admin/ClientController';
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

const handleSuccess = () => {
    emit('update:open', false);
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
            <Form
                v-if="client"
                v-bind="ClientController.update.form(client.id)"
                class="space-y-4"
                preserve-scroll
                @success="handleSuccess"
                v-slot="{ errors, processing }"
            >
                <div>
                    <Label>Nama Klien</Label>
                    <Input name="name" :default-value="client.name" required />
                    <span v-if="errors.name" class="text-sm text-red-500">
                        {{ errors.name }}
                    </span>
                </div>
                <div>
                    <Label>Domisili</Label>
                    <Input name="location" :default-value="client.location" />
                    <span v-if="errors.location" class="text-sm text-red-500">
                        {{ errors.location }}
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
                    <Input name="logo" type="file" accept="image/*" />
                    <span v-if="errors.logo" class="text-sm text-red-500">
                        {{ errors.logo }}
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
