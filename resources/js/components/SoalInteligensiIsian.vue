<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref } from 'vue';

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

const update = (index: number, value: string) => {
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
                v-for="(_, i) in soal"
                :key="i"
                class="rounded-xl border border-slate-200 bg-slate-50 p-4 sm:p-5"
            >
                <p
                    class="mb-3 text-sm leading-relaxed font-semibold text-slate-800 sm:text-base"
                >
                    {{ i + 1 }}.
                </p>

                <input
                    type="text"
                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm transition placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/30 focus:outline-none sm:px-4 sm:py-3"
                    :placeholder="'Ketik jawaban untuk nomor ' + (i + 1)"
                    :value="jawaban[i]"
                    @input="
                        update(i, ($event.target as HTMLInputElement).value)
                    "
                />
            </article>
        </div>
    </section>
</template>
