<script setup lang="ts">
import TestCard from '@/components/TestCard.vue';
import { Brain, GraduationCap, Lightbulb } from 'lucide-vue-next';

const tests = [
    {
        title: 'Tes Minat Bakat',
        description:
            'Identifikasi kekuatan, minat, dan potensi diri Anda untuk pengembangan karir dan pendidikan yang optimal.',
        icon: Lightbulb,
    },
    {
        title: 'Tes Inteligensi',
        description:
            'Mengukur kemampuan kognitif, daya nalar, dan kecerdasan intelektual secara komprehensif dan terstandar.',
        icon: Brain,
    },
    {
        title: 'Tes Gaya Belajar',
        description:
            'Temukan metode belajar yang paling efektif sesuai dengan karakteristik dan preferensi belajar Anda.',
        icon: GraduationCap,
    },
];
</script>

<template>
    <div class="space-y-6">
        <TestCard
            v-for="(test, index) in tests"
            :key="index"
            :title="test.title"
            :description="test.description"
            :icon="test.icon"
        />
    </div>
</template>
