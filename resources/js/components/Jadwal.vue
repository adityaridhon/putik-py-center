<script setup lang="ts">
import Kalender from './Kalender.vue';
import PilihJam from './PilihJam.vue';

const props = defineProps<{
    isConfirmed?: boolean;
    bookedSlots?: Array<{
        booking_date: string;
        booking_time: string;
        status: string;
    }>;
}>();
const tanggal = defineModel<string>('tanggal');
const jam = defineModel<string>('jam');
</script>

<template>
    <div class="space-y-6 rounded border p-6">
        <Kalender
            v-model="tanggal"
            :is-confirmed="props.isConfirmed"
            :booked-slots="props.bookedSlots || []"
        />
        <PilihJam
            v-model="jam"
            :is-confirmed="props.isConfirmed"
            :selected-date="tanggal"
            :booked-slots="props.bookedSlots || []"
        />
    </div>
</template>
