<script setup lang="ts">
import TestCard from '@/components/TestCard.vue';
import { router } from '@inertiajs/vue3';
import { Brain, GraduationCap, Lightbulb } from 'lucide-vue-next';

const tests = [
    {
        title: 'Tes Minat Bakat',
        description:
            'Identifikasi kekuatan, minat, dan potensi diri Anda untuk pengembangan karir dan pendidikan yang optimal.',
        icon: Lightbulb,
        url: '/tes-online/minat-bakat',
    },
    {
        title: 'Tes Inteligensi',
        description:
            'Mengukur kemampuan kognitif, daya nalar, dan kecerdasan intelektual secara komprehensif dan terstandar.',
        icon: Brain,
        url: '/tes-online/inteligensi',
    },
    {
        title: 'Tes Gaya Belajar',
        description:
            'Temukan metode belajar yang paling efektif sesuai dengan karakteristik dan preferensi belajar Anda.',
        icon: GraduationCap,
        url: '/tes-online/gaya-belajar',
    },
];

const goToTest = (url: string) => {
    router.visit(url);
};
</script>

<template>
    <div class="space-y-6">
        <TestCard
            v-for="(test, index) in tests"
            :key="index"
            :title="test.title"
            :description="test.description"
            :icon="test.icon"
            @click="goToTest(test.url)"
        />
    </div>
</template>
