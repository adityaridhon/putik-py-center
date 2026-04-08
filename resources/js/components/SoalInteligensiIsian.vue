<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref, watch } from 'vue';

interface Props {
    soal: string[];
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

const emit = defineEmits(['update:modelValue']);

const jawaban = ref<string[]>([...props.modelValue]);
const currentQuestion = ref(0);
const timer = ref(props.waktu);
const totalSoal = computed(() => props.soal.length);
const soalAktif = computed(() => props.soal[currentQuestion.value] ?? '');
const isFirstSoal = computed(() => currentQuestion.value === 0);
const isLastSoal = computed(
    () => currentQuestion.value === totalSoal.value - 1,
);
const formattedTime = computed(() => {
    const menit = Math.floor(timer.value / 60);
    const detik = timer.value % 60;

    return `${String(menit).padStart(2, '0')}:${String(detik).padStart(2, '0')}`;
});

let interval: ReturnType<typeof setInterval> | null = null;

onMounted(() => {
    interval = setInterval(() => {
        if (timer.value > 0) timer.value--;
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

watch(
    () => props.soal,
    () => {
        currentQuestion.value = 0;
    },
);

const update = (index: number, value: string) => {
    jawaban.value[index] = value;
    emit('update:modelValue', jawaban.value);
};

const nextSoal = () => {
    if (!isLastSoal.value) {
        currentQuestion.value++;
    }
};

const prevSoal = () => {
    if (!isFirstSoal.value) {
        currentQuestion.value--;
    }
};

const goToSoal = (index: number) => {
    if (index >= 0 && index < totalSoal.value) {
        currentQuestion.value = index;
    }
};
</script>

<template>
    <section
        class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-4 pb-8 shadow-sm sm:p-6 sm:pb-10 md:p-8 md:pb-12"
    >
        <div
            class="pointer-events-none absolute -top-16 -right-16 h-40 w-40 rounded-full bg-primary/10 blur-2xl"
        ></div>

        <div class="relative mb-6 flex items-center justify-between gap-3">
            <div
                class="inline-flex items-center gap-1 rounded-full border border-primary/20 bg-primary/10 px-2.5 py-1 text-xs font-medium whitespace-nowrap text-primary"
            >
                Kategori Soal: {{ kategori }}
            </div>
            <div
                class="inline-flex items-center gap-1 rounded-full border border-primary/20 bg-primary/10 px-2.5 py-1 text-xs font-medium whitespace-nowrap text-primary"
            >
                <span>Waktu</span>
                <span>{{ formattedTime }}</span>
            </div>
        </div>

        <div class="space-y-5">
            <article
                class="rounded-xl border border-slate-200 bg-slate-50 p-4 sm:p-5"
            >
                <p
                    class="mb-3 text-sm leading-relaxed font-semibold text-slate-800 sm:text-base"
                >
                    {{ currentQuestion + 1 }} / {{ totalSoal }}.
                </p>

                <p
                    class="mb-3 text-xs leading-relaxed text-slate-600 sm:text-sm"
                >
                    {{ soalAktif }}
                </p>

                <input
                    type="text"
                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm transition placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/30 focus:outline-none sm:px-4 sm:py-3"
                    :placeholder="
                        'Ketik jawaban untuk nomor ' + (currentQuestion + 1)
                    "
                    :value="jawaban[currentQuestion]"
                    @input="
                        update(
                            currentQuestion,
                            ($event.target as HTMLInputElement).value,
                        )
                    "
                />
            </article>

            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-50"
                        :disabled="isFirstSoal"
                        @click="prevSoal"
                    >
                        Sebelumnya
                    </button>
                    <button
                        type="button"
                        class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-50"
                        :disabled="isLastSoal"
                        @click="nextSoal"
                    >
                        Berikutnya
                    </button>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <button
                        v-for="(_, index) in soal"
                        :key="index"
                        type="button"
                        class="h-8 min-w-8 rounded-md border text-xs font-semibold"
                        :class="
                            index === currentQuestion
                                ? 'border-primary bg-primary text-white'
                                : jawaban[index]
                                  ? 'border-green-600 bg-green-50 text-green-700'
                                  : 'border-slate-300 bg-white text-slate-700'
                        "
                        @click="goToSoal(index)"
                    >
                        {{ index + 1 }}
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>
