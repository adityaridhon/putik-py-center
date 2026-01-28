<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
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
    service: {
        name: string;
        description?: string;
        image_url?: string;
        is_active: boolean;
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
                <DialogTitle>Detail Layanan</DialogTitle>
            </DialogHeader>
            <div v-if="service" class="space-y-4">
                <div class="flex justify-center">
                    <img
                        :src="service.image_url || '/images/logo_putik.webp'"
                        :alt="service.name"
                        class="h-32 w-32 rounded-lg border object-cover shadow"
                    />
                </div>
                <div>
                    <Label class="text-gray-600">Nama Layanan</Label>
                    <p class="mt-1 text-lg font-semibold">{{ service.name }}</p>
                </div>
                <div>
                    <Label class="text-gray-600">Deskripsi</Label>
                    <p class="mt-1 text-gray-700">
                        {{ service.description || '-' }}
                    </p>
                </div>
                <div>
                    <Label class="text-gray-600">Status</Label>
                    <p class="mt-1">
                        <Badge
                            :variant="
                                service.is_active ? 'default' : 'destructive'
                            "
                        >
                            {{ service.is_active ? 'Aktif' : 'Nonaktif' }}
                        </Badge>
                    </p>
                </div>
                <div class="flex justify-end pt-4">
                    <Button @click="emit('update:open', false)">Tutup</Button>
                </div>
            </div>
        </DialogContent>
    </Dialog>
</template>
