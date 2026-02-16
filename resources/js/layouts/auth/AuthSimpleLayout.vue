<script setup lang="ts">
import AppLogo from '@/components/AppLogo.vue';
import { home } from '@/routes';
import { Link } from '@inertiajs/vue3';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div
        class="flex min-h-svh flex-col items-center justify-center gap-6 bg-gray-50"
    >
        <div class="w-full max-w-xl">
            <Link
                :href="home()"
                class="flex flex-col items-center gap-2 font-medium"
            >
                <div
                    class="mb-1 flex h-30 w-30 items-center justify-center rounded-md"
                >
                    <AppLogo />
                </div>
                <span class="sr-only">{{ title }}</span>
            </Link>
            <div
                class="flex flex-col gap-8 rounded-xl bg-white px-8 py-6 shadow-md"
            >
                <div class="flex flex-col items-center gap-4">
                    <div class="space-y-2 text-center">
                        <h1 class="text-xl font-medium">{{ title }}</h1>
                        <p class="text-center text-sm text-muted-foreground">
                            {{ description }}
                        </p>
                    </div>
                </div>
                <slot />
            </div>
        </div>
    </div>
</template>
