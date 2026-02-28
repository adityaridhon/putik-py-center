<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { FileUp } from 'lucide-vue-next';
</script>

<template>
    <div class="rounded-xl border-2 border-dashed">
        <div
            class="flex h-full w-full items-center justify-center py-8 text-sm text-muted-foreground"
        >
            <div
                class="flex max-w-md flex-col items-center justify-center gap-2 text-center"
            >
                <FileUp class="mx-auto h-15 w-15 text-primary" />
                <Button size="sm" class="mb-2">Unggah Laporan</Button>
                <p class="text-xs">
                    <span class="text-red-500">*</span>
                    Unggah laporan psikologi berdasarkan hasil tes peserta
                    diatas dengan format file PDF. Pastikan file yang diunggah
                    sesuai dengan hasil tes yang ditampilkan.
                </p>
            </div>
        </div>
    </div>
</template>
