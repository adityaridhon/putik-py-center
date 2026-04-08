<script setup lang="ts">
import { computed } from 'vue';

interface Props {
    kategoriAktif: string;
    categories?: string[];
    disableNext?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    categories: () => ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'],
    disableNext: false,
});

const emit = defineEmits([
    'ubahKategori',
    'selanjutnya',
    'sebelumnya',
    'selesai',
]);

const currentIndex = computed(() =>
    props.categories.indexOf(props.kategoriAktif),
);

const isFirstKategori = computed(() => currentIndex.value === 0);

const isLastKategori = computed(
    () => currentIndex.value === props.categories.length - 1,
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
                v-for="k in props.categories"
                :key="k"
                @click="emit('ubahKategori', k)"
                class="rounded px-3 py-1 text-sm"
                :class="
                    k === props.kategoriAktif
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
                props.disableNext
                    ? 'cursor-not-allowed bg-gray-400'
                    : 'bg-primary hover:bg-green-900'
            "
            @click="handleNextClick"
            :disabled="props.disableNext"
        >
            {{ isLastKategori ? 'Selesai' : 'Selanjutnya' }}
        </button>
    </div>
</template>
