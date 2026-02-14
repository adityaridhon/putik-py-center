<script setup lang="ts">
import Label from '@/components/ui/label/Label.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import { Form } from '@inertiajs/vue3';
import { LockKeyhole } from 'lucide-vue-next';
</script>

<template>
    <Form class="space-y-4">
        <div class="space-y-2">
            <Label for="subtest-instruction">Instruksi Subtest</Label>
            <Textarea
                id="subtest-instruction"
                placeholder="Masukkan instruksi subtest"
                class="h-20 resize-none"
            />
            <div
                class="flex items-center gap-2 rounded-md border border-green-200 bg-green-50 p-2 text-green-800"
            >
                <LockKeyhole class="h-5 w-5" />
                <h1>Durasi baca instruksi adalah 3 menit</h1>
            </div>
        </div>
    </Form>
</template>
