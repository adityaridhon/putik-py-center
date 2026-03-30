<script setup lang="ts">
import { computed } from 'vue';

interface Props {
    kategoriAktif: string;
    kategori: string[];
    disableNext?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    kategori: () => ['SE', 'WA', 'AN', 'GE', 'RA', 'ZR', 'FA', 'WU', 'ME'],
    disableNext: false,
});

const emit = defineEmits([
    'ubahKategori',
    'selanjutnya',
    'sebelumnya',
    'selesai',
]);

const currentIndex = computed(() =>
    props.kategori.indexOf(props.kategoriAktif),
);

const isFirstKategori = computed(() => currentIndex.value === 0);

const isLastKategori = computed(
    () => currentIndex.value === props.kategori.length - 1,
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
        class="mt-5 mb-8 space-y-4 rounded-2xl border border-slate-200 bg-white p-3 shadow-sm sm:mt-6 sm:mb-10 sm:p-4"
    >
        <div
            class="grid grid-cols-3 gap-2 md:flex md:flex-wrap md:justify-center"
        >
            <button
                v-for="k in kategori"
                :key="k"
                @click="emit('ubahKategori', k)"
                class="rounded-lg px-2 py-2 text-xs font-semibold sm:px-3 sm:text-sm"
                :class="
                    k === kategoriAktif
                        ? 'bg-primary text-white'
                        : 'bg-gray-100 text-slate-700 hover:bg-gray-200'
                "
            >
                {{ k }}
            </button>
        </div>

        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
            <button
                v-if="!isFirstKategori"
                class="order-2 rounded-lg bg-gray-200 px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-gray-300 sm:order-1"
                @click="emit('sebelumnya')"
            >
                Sebelumnya
            </button>

            <div v-else class="hidden sm:block"></div>

            <button
                class="order-1 rounded-lg px-4 py-2.5 text-sm font-medium text-white sm:order-2"
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
    </div>
</template>
