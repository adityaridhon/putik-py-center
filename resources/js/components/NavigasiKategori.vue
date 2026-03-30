<script setup lang="ts">
import { computed } from 'vue';

interface Props {
    kategoriAktif: string;
    disableNext?: boolean;
}

const { kategoriAktif, disableNext = false } = defineProps<Props>();

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
    <div
        class="mt-6 mb-10 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
    >
        <button
            v-if="!isFirstKategori"
            class="w-full rounded bg-gray-200 px-4 py-2 sm:w-auto"
            @click="emit('sebelumnya')"
        >
            Sebelumnya
        </button>

        <div v-else class="hidden w-24 sm:block"></div>

        <div class="flex flex-wrap justify-center gap-2">
            <button
                v-for="k in kategori"
                :key="k"
                @click="emit('ubahKategori', k)"
                class="rounded px-3 py-1 text-sm"
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
            class="w-full rounded px-4 py-2 text-white sm:w-auto"
            :class="
                disableNext
                    ? 'cursor-not-allowed bg-gray-400'
                    : 'bg-primary hover:bg-green-900'
            "
            @click="handleNextClick"
            :disabled="disableNext"
        >
            {{ isLastKategori ? 'Selesai' : 'Selanjutnya' }}
        </button>
    </div>
</template>
