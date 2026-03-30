<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref } from 'vue';

const props = defineProps({
    kategori: String,
    instruksi: String,
    waktu: Number,
});

const emit = defineEmits(['mulai']);

const timer = ref(props.waktu || 0);
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
</script>

<template>
    <section
        class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6 md:p-8"
    >
        <div
            class="pointer-events-none absolute -top-16 -right-16 h-40 w-40 rounded-full bg-primary/10 blur-2xl"
        ></div>

        <div class="relative flex min-h-80 flex-col">
            <div
                class="mb-4 inline-flex w-fit items-center gap-2 self-start rounded-full border border-primary/20 bg-primary/10 px-3 py-1.5 text-xs font-semibold text-primary sm:mb-5 sm:self-end sm:px-4 sm:py-2 sm:text-sm"
            >
                <span>Waktu</span>
                <span>{{ formattedTime }}</span>
            </div>

            <h2
                class="text-xl font-bold tracking-tight text-slate-900 sm:text-2xl"
            >
                Instruksi Kategori {{ kategori || '-' }}
            </h2>

            <p class="mt-2 text-sm text-slate-500">
                Baca dengan teliti sebelum memulai sesi soal.
            </p>

            <div
                class="mt-4 flex-1 rounded-xl border border-slate-200 bg-slate-50 p-4 text-left text-sm leading-relaxed text-slate-700 sm:mt-6 sm:p-5 sm:text-base"
            >
                {{ instruksi || '-' }}
            </div>

            <button
                class="mt-6 inline-flex w-full items-center justify-center rounded-xl bg-primary px-6 py-3 font-semibold text-white shadow-sm transition hover:bg-green-900 focus:ring-2 focus:ring-primary/40 focus:outline-none sm:mt-8 sm:w-auto sm:self-end"
                @click="emit('mulai')"
            >
                Mulai Tes
            </button>
        </div>
    </section>
</template>
