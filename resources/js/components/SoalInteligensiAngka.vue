<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref, watch } from 'vue';

interface SoalItem {
    pertanyaan: string;
    gambarSoal?: string | null;
}

interface Props {
    soal: SoalItem[];
    kategori: string;
    waktu: number;
    modelValue: string[];
}

const props = withDefaults(defineProps<Props>(), {
    soal: () => [],
    kategori: '',
    waktu: 0,
    modelValue: () => [],
});

const emit = defineEmits(['update:modelValue', 'timeout']);

// Jawaban is an array of strings. For 'angka' questions, each index is a string of numbers like "42"
const jawaban = ref<string[]>([...props.modelValue]);
const currentQuestion = ref(0);
const timer = ref(props.waktu);
const sudahTimeout = ref(false);
const totalSoal = computed(() => props.soal.length);
const soalAktif = computed(() => props.soal[currentQuestion.value]);
const showTimer = computed(() => timer.value <= 10);
const formattedTime = computed(() => {
    const menit = Math.floor(timer.value / 60);
    const detik = timer.value % 60;
    return `${String(menit).padStart(2, '0')}:${String(detik).padStart(2, '0')}`;
});

let interval: ReturnType<typeof setInterval> | null = null;

onMounted(() => {
    interval = setInterval(() => {
        if (timer.value > 0) {
            timer.value--;
            return;
        }
        if (!sudahTimeout.value) {
            sudahTimeout.value = true;
            emit('timeout');
        }
    }, 1000);
});

onUnmounted(() => {
    if (interval) clearInterval(interval);
});

watch(
    () => props.modelValue,
    (value) => {
        jawaban.value = [...value];
    },
    { deep: true },
);

// Derived from active question's selected numbers
const selectedNumbersCache = computed<number[]>(() => {
    const str = jawaban.value[currentQuestion.value] || '';
    return str.split('').map(c => parseInt(c)).filter(n => !isNaN(n));
});

const isNumberSelected = (num: number) => {
    return selectedNumbersCache.value.includes(num);
};

const toggleNumber = (num: number) => {
    let arr = [...selectedNumbersCache.value];
    const index = arr.indexOf(num);
    if (index > -1) {
        arr.splice(index, 1);
    } else {
        arr.push(num);
    }
    jawaban.value[currentQuestion.value] = arr.join('');
    emit('update:modelValue', jawaban.value);
};

const goToSoal = (index: number) => {
    if (index >= 0 && index < totalSoal.value) {
        currentQuestion.value = index;
    }
};

const hapusJawaban = () => {
    jawaban.value[currentQuestion.value] = '';
    emit('update:modelValue', jawaban.value);
};
</script>

<template>
    <section class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-4 pb-8 shadow-sm sm:p-6 sm:pb-10 md:p-8 md:pb-12">
        <div class="pointer-events-none absolute -top-16 -right-16 h-40 w-40 rounded-full bg-primary/10 blur-2xl"></div>

        <div class="relative mb-6 flex items-center justify-between gap-3">
            <div class="inline-flex items-center gap-1 rounded-full border border-primary/20 bg-primary/10 px-2.5 py-1 text-xs font-medium whitespace-nowrap text-primary">
                Kategori Soal: {{ kategori }}
            </div>
            <div
                v-if="showTimer"
                class="inline-flex items-center gap-1 rounded-full border border-primary/20 bg-primary/10 px-2.5 py-1 text-xs font-medium whitespace-nowrap text-primary"
                :class="timer <= 10 ? 'border-red-300 bg-red-50 text-red-700' : ''"
            >
                <span>Waktu</span>
                <span>{{ formattedTime }}</span>
            </div>
        </div>

        <div class="space-y-5" v-if="soalAktif">
            <article class="col-span-12 rounded-xl border border-slate-200 bg-slate-50 p-4 sm:p-5">
                <p class="mb-4 text-sm leading-relaxed font-semibold text-slate-800 sm:text-base">
                    {{ currentQuestion + 1 }} / {{ totalSoal }}.
                    {{ soalAktif.pertanyaan }}
                </p>

                <img
                    v-if="soalAktif.gambarSoal"
                    :src="soalAktif.gambarSoal"
                    alt="Gambar soal"
                    class="mb-4 max-h-64 rounded-lg border border-slate-200 bg-white object-contain"
                />

                <div class="mt-8 space-y-4 rounded-xl border border-slate-200 bg-white p-4 sm:p-5 md:p-6">
                    <p class="text-sm font-semibold text-slate-700">Pilih Angka Jawaban (1-10)</p>
                    <p class="text-sm text-slate-600 mb-4">Klik angka yang merupakan jawaban yang benar:</p>

                    <div class="flex flex-wrap justify-center gap-2 mb-6">
                        <button
                            v-for="number in [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]"
                            :key="number"
                            @click="toggleNumber(number)"
                            :class="[
                                'h-12 w-12 rounded-lg border-2 font-semibold text-lg transition-all focus:outline-none focus:ring-2 focus:ring-primary/50',
                                isNumberSelected(number)
                                    ? 'border-primary bg-primary text-white shadow-md'
                                    : 'border-slate-300 bg-white text-slate-700 hover:border-primary/50 hover:bg-primary/5'
                            ]"
                            :style="isNumberSelected(number) ? 'color: #fff; background-color: #16a34a; border-color: #15803d;' : ''"
                            type="button"
                        >
                            {{ number }}
                        </button>
                    </div>

                    <div class="flex items-center justify-between gap-2 rounded-lg p-3 ring-1 ring-inset ring-green-100 bg-green-50 mb-2">
                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            <p class="font-medium text-green-800">
                                Jawaban: <span class="text-green-600 ml-1 font-bold">{{ jawaban[currentQuestion] || 'Belum diisi' }}</span>
                            </p>
                        </div>
                        <button
                            v-if="jawaban[currentQuestion]"
                            @click="hapusJawaban"
                            class="text-xs text-red-600 hover:text-red-700 font-medium px-2 py-1 rounded bg-red-50 hover:bg-red-100 transition-colors"
                            type="button"
                        >
                            Kosongkan
                        </button>
                    </div>
                </div>
            </article>
        </div>

        <nav aria-label="Navigasi soal" class="mt-8 flex flex-wrap gap-2">
            <button
                v-for="(_, index) in soal"
                :key="index"
                @click="goToSoal(index)"
                :aria-current="currentQuestion === index ? 'page' : undefined"
                class="flex h-10 w-10 items-center justify-center rounded-lg border text-sm font-medium transition-colors sm:h-12 sm:w-12 sm:text-base cursor-pointer"
                :class="
                    currentQuestion === index
                        ? 'border-primary bg-primary text-white ring-2 ring-primary/20 ring-offset-2'
                        : jawaban[index]
                          ? 'border-transparent bg-primary/10 text-primary hover:bg-primary/20'
                          : 'border-slate-200 bg-white text-slate-600 hover:border-slate-300 hover:bg-slate-50'
                "
            >
                {{ index + 1 }}
            </button>
        </nav>
    </section>
</template>
