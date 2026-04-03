<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref } from 'vue';

interface SoalItem {
    pertanyaan: string;
    opsi: string[];
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

const emit = defineEmits(['update:modelValue']);

const jawaban = ref<string[]>([...props.modelValue]);
const timer = ref(props.waktu);
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

const pilih = (index: number, value: string) => {
    jawaban.value[index] = value;
    emit('update:modelValue', jawaban.value);
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
                v-for="(s, i) in soal"
                :key="i"
                class="rounded-xl border border-slate-200 bg-slate-50 p-4 sm:p-5"
            >
                <p
                    class="mb-4 text-sm leading-relaxed font-semibold text-slate-800 sm:text-base"
                >
                    {{ i + 1 }}. {{ s.pertanyaan }}
                </p>

                <div class="grid gap-2 md:grid-cols-2">
                    <label
                        v-for="(opsi, j) in s.opsi"
                        :key="j"
                        class="group relative cursor-pointer rounded-lg border p-2.5 transition sm:p-3"
                        :class="
                            jawaban[i] === opsi
                                ? 'border-primary bg-primary/10 ring-1 ring-primary/30'
                                : 'border-slate-300 bg-white hover:border-primary/60 hover:bg-primary/5'
                        "
                    >
                        <input
                            type="radio"
                            class="sr-only"
                            :name="'soal' + i"
                            :value="opsi"
                            :checked="jawaban[i] === opsi"
                            @change="pilih(i, opsi)"
                        />

                        <div class="flex items-start gap-3">
                            <span
                                class="inline-flex h-6 w-6 items-center justify-center rounded-full text-xs font-bold"
                                :class="
                                    jawaban[i] === opsi
                                        ? 'bg-primary text-white'
                                        : 'bg-slate-200 text-slate-700'
                                "
                            >
                                {{ String.fromCharCode(65 + j) }}
                            </span>

                            <span
                                class="text-xs leading-relaxed text-slate-700 sm:text-sm"
                            >
                                {{ opsi }}
                            </span>
                        </div>
                    </label>
                </div>
            </article>
        </div>
    </section>
</template>
