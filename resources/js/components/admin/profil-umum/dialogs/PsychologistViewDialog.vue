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
    psychologist: {
        name: string;
        specialization?: string;
        photo_url?: string;
        image_url?: string;
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
                <DialogTitle>Detail Psikolog</DialogTitle>
            </DialogHeader>

            <div v-if="psychologist" class="space-y-4">
                <div class="flex justify-center">
                    <img
                        :src="
                            psychologist.photo_url ||
                            psychologist.image_url ||
                            '/images/logo_putik.webp'
                        "
                        :alt="psychologist.name"
                        class="h-32 w-32 rounded-lg border object-cover shadow"
                    />
                </div>

                <div>
                    <Label class="text-gray-600">Nama Psikolog</Label>
                    <p class="mt-1 text-lg font-semibold">
                        {{ psychologist.name || '-' }}
                    </p>
                </div>

                <div>
                    <Label class="text-gray-600">Spesialisasi</Label>
                    <p class="mt-1 text-gray-700">
                        {{ psychologist.specialization || '-' }}
                    </p>
                </div>

                <div class="flex justify-end pt-4">
                    <Button @click="emit('update:open', false)">Tutup</Button>
                </div>
            </div>
        </DialogContent>
    </Dialog>
</template>
