<script setup lang="ts">
defineProps<{
    title: string;
    description: string;
    icon: any;
}>();
</script>

<template>
    <div
        class="group flex items-center justify-between rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:border-green-600 hover:shadow-md"
    >
        <div class="flex items-start gap-4">
            <div
                class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#2D5F4F] text-white"
            >
                <component :is="icon" class="h-6 w-6" />
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-800">
                    {{ title }}
                </h3>

                <p class="mt-1 text-sm text-gray-600">
                    {{ description }}
                </p>
            </div>
        </div>
    </div>
</template>
