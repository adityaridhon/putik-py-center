<script setup lang="ts">
defineProps<{
  judul: string
}>()
</script>

<template>
  <nav class="w-full bg-primary px-6 py-3">
    <div class="relative flex items-center">

      <!-- Logo -->
      <img
        src="/images/logo_putik.webp"
        alt="Putik Psychology Center"
        class="h-8"
      />

      <!-- Judul -->
      <h1
        class="absolute left-1/2 -translate-x-1/2 text-2xl font-bold text-white tracking-wide"
      >
        {{ judul }}
      </h1>

    </div>
  </nav>
</template>