<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

interface Pernyataan {
    id: number;
    teks: string;
    jawaban: number | null;
}

const props = defineProps<{
    statements?: Array<{ id: number; teks: string }>;
}>();

const fallbackPernyataan: Pernyataan[] = [
    { id: 1, teks: 'Saya mudah memahami materi baru.', jawaban: null },
    { id: 2, teks: 'Saya suka belajar dengan membaca.', jawaban: null },
    {
        id: 3,
        teks: 'Saya lebih suka belajar dengan praktik langsung.',
        jawaban: null,
    },
    {
        id: 4,
        teks: 'Saya cepat mengingat informasi saat dijelaskan.',
        jawaban: null,
    },
];

const daftarPernyataan = ref<Pernyataan[]>(
    (props.statements ?? []).length > 0
        ? (props.statements ?? []).map((item) => ({
              id: item.id,
              teks: item.teks,
              jawaban: null,
          }))
        : fallbackPernyataan,
);

const indexAktif = ref(0);
const showIncompleteWarning = ref(false);

const totalPernyataan = computed(() => daftarPernyataan.value.length);
const pernyataanAktif = computed(
    () => daftarPernyataan.value[indexAktif.value] ?? daftarPernyataan.value[0],
);

const totalTerjawab = computed(
    () => daftarPernyataan.value.filter((item) => item.jawaban !== null).length,
);

const progressPersen = computed(() => {
    if (totalPernyataan.value === 0) {
        return 0;
    }

    return Math.round((totalTerjawab.value / totalPernyataan.value) * 100);
});

const isAllAnswered = computed(() =>
    daftarPernyataan.value.every((item) => item.jawaban !== null),
);

const isFirst = computed(() => indexAktif.value === 0);
const isLast = computed(() => indexAktif.value === totalPernyataan.value - 1);

const pilihJawaban = (nilai: number) => {
    if (!pernyataanAktif.value) {
        return;
    }

    pernyataanAktif.value.jawaban = nilai;
    showIncompleteWarning.value = false;
};

const nextPernyataan = () => {
    if (!isLast.value) {
        indexAktif.value++;
    }
};

const prevPernyataan = () => {
    if (!isFirst.value) {
        indexAktif.value--;
    }
};

const goToPernyataan = (index: number) => {
    if (index >= 0 && index < totalPernyataan.value) {
        indexAktif.value = index;
    }
};

const handleSelesai = () => {
    if (!isAllAnswered.value) {
        showIncompleteWarning.value = true;
        return;
    }

    router.post(
        '/tes-online/gaya-belajar/submit',
        {
            answers: daftarPernyataan.value,
        },
        {
            preserveScroll: true,
            onError: (errors) => {
                console.error('Submission error:', errors);
                if (errors.token) {
                    alert(errors.token);
                    router.visit('/tes-online/gaya-belajar');
                }
            },
        },
    );
};
</script>

<template>
    <div
        class="mx-auto mt-4 mb-6 w-full max-w-4xl px-3 sm:mt-6 sm:px-5 md:mt-8 md:px-6"
    >
        <div
            class="mb-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:mb-5 sm:p-5"
        >
            <div class="mb-3 flex items-center justify-between gap-3">
                <p class="text-sm font-semibold text-slate-700 sm:text-base">
                    Progress Pengisian
                </p>
                <p class="text-xs font-semibold text-slate-500 sm:text-sm">
                    {{ totalTerjawab }} / {{ totalPernyataan }} terjawab
                </p>
            </div>

            <div class="h-2 w-full overflow-hidden rounded-full bg-slate-200">
                <div
                    class="h-full rounded-full bg-primary transition-all duration-300"
                    :style="{ width: `${progressPersen}%` }"
                ></div>
            </div>

            <p class="mt-3 text-xs text-slate-500 sm:text-sm">
                Pilih jawaban yang paling menggambarkan diri Anda. Tidak ada
                jawaban benar atau salah.
            </p>
        </div>

        <div
            class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6"
        >
            <div class="mb-3 flex items-center justify-between gap-3">
                <p
                    class="text-xs font-semibold tracking-wide text-slate-500 uppercase"
                >
                    Pernyataan {{ indexAktif + 1 }} dari {{ totalPernyataan }}
                </p>
                <span
                    class="rounded-full px-2.5 py-1 text-xs font-semibold"
                    :class="
                        pernyataanAktif?.jawaban
                            ? 'bg-green-100 text-green-700'
                            : 'bg-amber-100 text-amber-700'
                    "
                >
                    {{
                        pernyataanAktif?.jawaban
                            ? 'Sudah dipilih'
                            : 'Belum dipilih'
                    }}
                </span>
            </div>

            <p
                class="mb-5 text-base leading-relaxed font-medium text-slate-800 sm:text-lg"
            >
                {{ pernyataanAktif?.teks }}
            </p>

            <div class="grid gap-2 sm:grid-cols-3">
                <button
                    type="button"
                    class="rounded-xl border px-3 py-3 text-left transition"
                    :class="
                        pernyataanAktif?.jawaban === 1
                            ? 'border-primary bg-primary text-white'
                            : 'border-slate-200 bg-slate-50 text-slate-700 hover:border-primary/40'
                    "
                    @click="pilihJawaban(1)"
                >
                    <p class="text-xs font-semibold">1</p>
                    <p class="mt-1 text-sm font-semibold">Tidak Sesuai</p>
                </button>

                <button
                    type="button"
                    class="rounded-xl border px-3 py-3 text-left transition"
                    :class="
                        pernyataanAktif?.jawaban === 2
                            ? 'border-primary bg-primary text-white'
                            : 'border-slate-200 bg-slate-50 text-slate-700 hover:border-primary/40'
                    "
                    @click="pilihJawaban(2)"
                >
                    <p class="text-xs font-semibold">2</p>
                    <p class="mt-1 text-sm font-semibold">Cukup Sesuai</p>
                </button>

                <button
                    type="button"
                    class="rounded-xl border px-3 py-3 text-left transition"
                    :class="
                        pernyataanAktif?.jawaban === 3
                            ? 'border-primary bg-primary text-white'
                            : 'border-slate-200 bg-slate-50 text-slate-700 hover:border-primary/40'
                    "
                    @click="pilihJawaban(3)"
                >
                    <p class="text-xs font-semibold">3</p>
                    <p class="mt-1 text-sm font-semibold">Sangat Sesuai</p>
                </button>
            </div>

            <p
                v-if="showIncompleteWarning"
                class="mt-4 rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-medium text-amber-700"
            >
                Masih ada pernyataan yang belum dijawab. Silakan lengkapi semua
                sebelum menekan tombol selesai.
            </p>

            <div class="mt-6 flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-50"
                        :disabled="isFirst"
                        @click="prevPernyataan"
                    >
                        Sebelumnya
                    </button>
                    <button
                        type="button"
                        class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-50"
                        :disabled="isLast"
                        @click="nextPernyataan"
                    >
                        Berikutnya
                    </button>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <button
                        v-for="(item, index) in daftarPernyataan"
                        :key="item.id"
                        type="button"
                        class="h-8 min-w-8 rounded-md border text-xs font-semibold"
                        :class="
                            index === indexAktif
                                ? 'border-primary bg-primary text-white'
                                : item.jawaban
                                  ? 'border-green-600 bg-green-50 text-green-700'
                                  : 'border-slate-300 bg-white text-slate-700'
                        "
                        @click="goToPernyataan(index)"
                    >
                        {{ index + 1 }}
                    </button>
                </div>
            </div>
        </div>

        <div class="mt-5 mb-8 flex justify-stretch sm:mt-6 sm:justify-end">
            <button
                type="button"
                :disabled="!isAllAnswered"
                @click="handleSelesai"
                :class="[
                    'flex w-full items-center justify-center gap-2 rounded-lg px-6 py-2.5 text-sm text-white transition sm:w-auto sm:text-base',
                    isAllAnswered
                        ? 'cursor-pointer bg-primary hover:bg-green-900'
                        : 'cursor-not-allowed bg-gray-400',
                ]"
            >
                Selesai
            </button>
        </div>
    </div>
</template>
