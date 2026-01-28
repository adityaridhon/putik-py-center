<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Label } from '@/components/ui/label';

defineProps<{
    open: boolean;
    client: {
        name: string;
        location?: string;
        logo_url?: string;
    } | null;
}>();

const emit = defineEmits<{
    'update:open': [value: boolean];
}>();
</script>

<template>
    <Dialog :open="open" @update:open="emit('update:open', $event)">
        <DialogContent class="max-w-2xl">
            <DialogHeader>
                <DialogTitle>Detail Klien</DialogTitle>
            </DialogHeader>
            <div v-if="client" class="space-y-4">
                <div class="flex justify-center">
                    <img
                        :src="client.logo_url || '/images/logo_putik.webp'"
                        :alt="client.name"
                        class="h-32 w-32 rounded-lg border object-cover shadow"
                    />
                </div>
                <div>
                    <Label class="text-gray-600">Nama Klien</Label>
                    <p class="mt-1 text-lg font-semibold">{{ client.name }}</p>
                </div>
                <div>
                    <Label class="text-gray-600">Domisili</Label>
                    <p class="mt-1 text-gray-700">
                        {{ client.location || '-' }}
                    </p>
                </div>
                <div class="flex justify-end pt-4">
                    <Button @click="emit('update:open', false)">Tutup</Button>
                </div>
            </div>
        </DialogContent>
    </Dialog>
</template>
