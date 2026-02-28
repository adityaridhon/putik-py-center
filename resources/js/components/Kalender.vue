<script setup lang="ts">
import { ref } from 'vue';
const emit = defineEmits<{
    (event: 'update:modelValue', value: string): void;
}>();
const selected = ref('');

const hariIni = new Date();

const daftarTanggal = Array.from({ length: 14 }, (_, i) => {
    const d = new Date();
    d.setDate(hariIni.getDate() + i);
    return {
        value: d.toISOString().split('T')[0],
        tersedia: Math.random() > 0.3,
    };
});

function pilih(item: any) {
    if (!item.tersedia) return;
    selected.value = item.value;
    emit('update:modelValue', item.value);
}
</script>

<template>
    <div>
        <div class="grid grid-cols-7 gap-2">
            <div
                v-for="item in daftarTanggal"
                :key="item.value"
                @click="pilih(item)"
                :class="[
                    'rounded p-2 text-center',
                    item.tersedia
                        ? 'bg-green-600 text-white cursor-pointer'
                        : 'bg-gray-300 text-gray-500 cursor-not-allowed',
                    selected === item.value ? 'ring-2 ring-black' : '',
                ]"
            >
                {{ new Date(item.value).getDate() }}
            </div>
        </div>

        <div class="mt-4 flex gap-4 text-sm">
            <span class="flex items-center gap-2">
                <div class="h-3 w-3 rounded-full bg-green-600"></div>
                Tersedia
            </span>
            <span class="flex items-center gap-2">
                <div class="h-3 w-3 rounded-full bg-gray-300"></div>
                Penuh
            </span>
        </div>
    </div>
</template>
