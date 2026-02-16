<script setup lang="ts">
import Label from '@/components/ui/label/Label.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import { Form } from '@inertiajs/vue3';
import { LockKeyhole } from 'lucide-vue-next';
</script>

<template>
    <Form class="space-y-4">
        <div class="space-y-2">
            <Label for="subtest-instruction"
                >Instruksi Subtest <span class="text-red-500">*</span></Label
            >
            <Textarea
                id="subtest-instruction"
                placeholder="Masukkan instruksi subtest"
                class="h-20 resize-none"
                required
            />
            <div
                class="flex items-center gap-2 rounded-md border border-green-200 bg-green-50 p-2 text-green-800"
            >
                <LockKeyhole class="h-4 w-4" />
                <h1 class="text-sm">Durasi baca instruksi adalah 3 menit</h1>
            </div>
        </div>
    </Form>
</template>
