<script setup lang="ts">
const model = defineModel<any>()
</script>

<template>
  <div class="border p-6 rounded space-y-4">
    <input
      v-model="model.nama"
      placeholder="Nama Lengkap"
      class="w-full border rounded p-2"
    />

    <input
      v-model="model.hp"
      placeholder="Nomor HP"
      class="w-full border rounded p-2"
    />

    <input
      v-model="model.email"
      placeholder="Email"
      class="w-full border rounded p-2"
    />

    <textarea
      v-model="model.topik"
      placeholder="Topik Permasalahan"
      class="w-full border rounded p-2"
    ></textarea>
  </div>
</template>