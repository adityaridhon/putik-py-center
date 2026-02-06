<script setup lang="ts">
import { Textarea } from '@/components/ui/textarea';
</script>

<template>
    <h1 class="text-2xl font-bold">Instruksi Tes</h1>
    <p class="text-sm text-gray-600">
        Masukkan instruksi tes sesuai dengan kebutuhan tes minat dan bakat
    </p>
    <Textarea
        class="h-25 resize-none"
        placeholder="Masukkan instruksi tes di sini..."
    />
</template>
