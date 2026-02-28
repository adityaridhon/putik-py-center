<script setup lang="ts">
import Kalender from './Kalender.vue'
import PilihJam from './PilihJam.vue'

const tanggal = defineModel<string>('tanggal')
const jam = defineModel<string>('jam')
</script>

<template>
  <div class="border p-6 rounded space-y-6">
    <Kalender v-model="tanggal" />
    <PilihJam v-model="jam" />
  </div>
</template>