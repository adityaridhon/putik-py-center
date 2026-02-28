<script setup lang="ts">
const emit = defineEmits(['update:modelValue']);

interface JamItem {
    waktu: string;
    tersedia: boolean;
}

const jamList: JamItem[] = [
    { waktu: '09:30', tersedia: true },
    { waktu: '13:00', tersedia: true },
    { waktu: '15:00', tersedia: false },
    { waktu: '16:30', tersedia: true },
];

function pilih(j: JamItem) {
    if (!j.tersedia) return;
    emit('update:modelValue', j.waktu);
}
</script>

<template>
    <div class="flex gap-4">
        <button
            v-for="j in jamList"
            :key="j.waktu"
            @click="pilih(j)"
            :class="
                j.tersedia
                    ? 'bg-green-700 text-white'
                    : 'cursor-not-allowed bg-gray-300 text-gray-500'
            "
            class="rounded px-4 py-2"
        >
            {{ j.tersedia ? j.waktu : 'FULL' }}
        </button>
    </div>
</template>
