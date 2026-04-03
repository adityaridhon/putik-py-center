<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Link } from '@inertiajs/vue3';
import { ArrowLeft } from 'lucide-vue-next';

interface Props {
    title: string;
    backUrl: string | number;
    backText?: string;
}

withDefaults(defineProps<Props>(), {
    backText: 'Kembali',
});

const goBack = (backUrl: number) => {
    window.history.go(backUrl);
};
</script>

<template>
    <div
        class="flex w-full items-center justify-between bg-white px-6 py-4 dark:bg-gray-950"
    >
        <Link v-if="typeof backUrl === 'string'" :href="backUrl">
            <Button variant="outline" size="sm">
                <ArrowLeft class="mr-2 h-4 w-4" />
                {{ backText }}
            </Button>
        </Link>
        <Button v-else variant="outline" size="sm" @click="goBack(backUrl)">
            <ArrowLeft class="mr-2 h-4 w-4" />
            {{ backText }}
        </Button>
        <h1 class="text-xl font-bold text-black dark:text-white">
            {{ title }}
        </h1>
    </div>
    <div class="mx-auto w-[87%] border-b border-gray-200"></div>
</template>
