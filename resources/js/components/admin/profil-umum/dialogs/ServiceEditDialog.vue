<script setup lang="ts">
import ServiceController from '@/actions/App/Http/Controllers/Admin/ServiceController';
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
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import { Textarea } from '@/components/ui/textarea';
import { Form } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps<{
    open: boolean;
    service: {
        id: number;
        name: string;
        description?: string;
        image_url?: string;
        is_active: boolean | number;
    } | null;
}>();

const emit = defineEmits<{
    'update:open': [value: boolean];
}>();

const isActive = ref('1');

watch(
    () => props.service,
    (newService) => {
        if (newService) {
            isActive.value = newService.is_active ? '1' : '0';
        }
    },
    { immediate: true },
);

const handleSuccess = () => {
    emit('update:open', false);
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
            <Form
                v-if="service"
                v-bind="ServiceController.update.form(service.id)"
                class="space-y-4"
                preserve-scroll
                @success="handleSuccess"
                v-slot="{ errors, processing }"
            >
                <div>
                    <Label>Nama Layanan</Label>
                    <Input name="name" :default-value="service.name" required />
                    <span v-if="errors.name" class="text-sm text-red-500">
                        {{ errors.name }}
                    </span>
                </div>
                <div>
                    <Label>Deskripsi</Label>
                    <Textarea
                        name="description"
                        :default-value="service.description"
                        class="resize-none"
                    />
                    <span
                        v-if="errors.description"
                        class="text-sm text-red-500"
                    >
                        {{ errors.description }}
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
                    <Input name="image" type="file" accept="image/*" />
                    <span v-if="errors.image" class="text-sm text-red-500">
                        {{ errors.image }}
                    </span>
                </div>
                <div class="space-y-3">
                    <Label>Status Layanan</Label>
                    <RadioGroup v-model="isActive" class="flex gap-4">
                        <div class="flex items-center space-x-2">
                            <RadioGroupItem
                                :id="`active_yes_${service.id}`"
                                value="1"
                            />
                            <Label
                                :for="`active_yes_${service.id}`"
                                class="cursor-pointer font-normal"
                            >
                                Aktif
                            </Label>
                        </div>
                        <div class="flex items-center space-x-2">
                            <RadioGroupItem
                                :id="`active_no_${service.id}`"
                                value="0"
                            />
                            <Label
                                :for="`active_no_${service.id}`"
                                class="cursor-pointer font-normal"
                            >
                                Nonaktif
                            </Label>
                        </div>
                    </RadioGroup>
                    <!-- Hidden input untuk form submission -->
                    <input type="hidden" name="is_active" :value="isActive" />
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
