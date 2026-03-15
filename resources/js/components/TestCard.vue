<script setup lang="ts">
defineProps<{
    title: string;
    description: string;
    icon: any;
}>();

defineEmits<{
    (event: 'click'): void;
}>();
</script>

<template>
    <button
        type="button"
        class="group flex w-full items-center justify-between rounded-2xl border border-gray-200 bg-white p-6 text-left shadow-sm transition hover:border-green-600 hover:shadow-md focus-visible:ring-2 focus-visible:ring-green-600 focus-visible:ring-offset-2 focus-visible:outline-none"
        @click="$emit('click')"
    >
        <div class="flex items-start gap-4">
            <div
                class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary text-white"
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
    </button>
</template>
