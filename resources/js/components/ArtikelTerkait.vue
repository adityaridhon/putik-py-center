<script setup lang="ts">
import Artikel from './Artikel.vue';
</script>

<template>
<div class="mt-16">

<h3 class="mb-6 text-2xl font-semibold text-emerald-900">
Artikel Terkait
</h3>

<div class="grid gap-6 md:grid-cols-3">

<Artikel/>
<Artikel />
<Artikel />

</div>

<div class="mt-6 text-center">
<a class="text-emerald-700 hover:underline">
← Kembali ke Artikel
</a>
</div>

</div>
</template>