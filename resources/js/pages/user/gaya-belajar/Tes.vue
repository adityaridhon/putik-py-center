<script setup lang="ts">
import Navbar from '@/components/Navbar.vue';
import TesGayaBelajar from '@/components/TesGayaBelajar.vue';

interface LearningStatement {
    id: number;
    teks: string;
}

defineProps<{
    statements?: LearningStatement[];
}>();
</script>

<template>
    <div class="min-h-screen bg-slate-50">
        <Navbar title="TES GAYA BELAJAR" />
        <TesGayaBelajar :statements="statements || []" />
    </div>
</template>
