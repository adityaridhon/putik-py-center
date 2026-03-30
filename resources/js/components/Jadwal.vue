<script setup lang="ts">
import Kalender from './Kalender.vue';
import PilihJam from './PilihJam.vue';

const props = defineProps<{ isConfirmed?: boolean }>();
const tanggal = defineModel<string>('tanggal');
const jam = defineModel<string>('jam');
</script>

<template>
    <div class="space-y-6 rounded-xl border bg-white p-5 shadow-sm sm:p-6">
        <Kalender v-model="tanggal" :is-confirmed="props.isConfirmed" />
        <PilihJam v-model="jam" :is-confirmed="props.isConfirmed" />
    </div>
</template>
