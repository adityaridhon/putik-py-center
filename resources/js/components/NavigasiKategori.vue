<script setup lang="ts">
import { computed } from 'vue';

interface Props {
    kategoriAktif: string;
}

const { kategoriAktif } = defineProps<Props>();

const emit = defineEmits([
    'ubahKategori',
    'selanjutnya',
    'sebelumnya',
    'selesai',
]);

const kategori = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];

const currentIndex = computed(() => kategori.indexOf(kategoriAktif));

const isFirstKategori = computed(() => currentIndex.value === 0);

const isLastKategori = computed(
    () => currentIndex.value === kategori.length - 1,
);

const handleNextClick = () => {
    if (isLastKategori.value) {
        emit('selesai');
        return;
    }

    emit('selanjutnya');
};
</script>

<template>
    <div class="mt-6 mb-10 flex items-center justify-between">
        <button
            v-if="!isFirstKategori"
            class="rounded bg-gray-200 px-4 py-2"
            @click="emit('sebelumnya')"
        >
            Sebelumnya
        </button>

        <div v-else class="w-24"></div>

        <div class="flex gap-2">
            <button
                v-for="k in kategori"
                :key="k"
                @click="emit('ubahKategori', k)"
                class="rounded px-3 py-1"
                :class="
                    k === kategoriAktif
                        ? 'bg-primary text-white'
                        : 'bg-gray-200'
                "
            >
                {{ k }}
            </button>
        </div>

        <button
            class="rounded bg-primary px-4 py-2 text-white"
            @click="handleNextClick"
        >
            {{ isLastKategori ? 'Selesai' : 'Selanjutnya' }}
        </button>
    </div>
</template>
