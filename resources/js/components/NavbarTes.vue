<script setup lang="ts">
defineProps<{
    judul: string;
}>();
</script>

<template>
    <nav class="w-full bg-primary px-3 py-3 sm:px-6">
        <div class="mx-auto flex w-full max-w-5xl items-center gap-2 sm:gap-3">
            <img
                src="/images/logo_putik.webp"
                alt="Putik Psychology Center"
                class="h-7 w-auto shrink-0 sm:h-8"
            />

            <h1
                class="flex-1 pr-7 text-center text-sm font-bold tracking-wide text-white sm:pr-8 sm:text-xl md:text-2xl"
            >
                {{ judul }}
            </h1>
        </div>
    </nav>
</template>
