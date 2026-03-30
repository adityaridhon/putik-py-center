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
        class="group flex w-full items-start rounded-2xl border border-gray-200 bg-white p-4 text-left shadow-sm transition hover:border-green-600 hover:shadow-md focus-visible:ring-2 focus-visible:ring-green-600 focus-visible:ring-offset-2 focus-visible:outline-none sm:p-5 md:items-center md:p-6"
        @click="$emit('click')"
    >
        <div class="flex items-start gap-4">
            <div
                class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary text-white sm:h-11 sm:w-11 md:h-12 md:w-12"
            >
                <component
                    :is="icon"
                    class="h-5 w-5 sm:h-5 sm:w-5 md:h-6 md:w-6"
                />
            </div>

            <div>
                <h3 class="text-base font-semibold text-gray-800 sm:text-lg">
                    {{ title }}
                </h3>

                <p class="mt-1 text-sm leading-relaxed text-gray-600">
                    {{ description }}
                </p>
            </div>
        </div>
    </button>
</template>
