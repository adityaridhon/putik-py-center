<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

interface Pernyataan {
    id: number;
    teks: string;
    jawaban: number | null;
}

const daftarPernyataan = ref<Pernyataan[]>([
    { id: 1, teks: 'Saya mudah memahami materi baru.', jawaban: null },
    { id: 2, teks: 'Saya suka belajar dengan membaca.', jawaban: null },
    { id: 3, teks: 'Saya lebih suka belajar dengan praktik.', jawaban: null },
    { id: 4, teks: 'Saya cepat mengingat informasi.', jawaban: null },
]);

const isAllAnswered = computed(() =>
    daftarPernyataan.value.every((item) => item.jawaban !== null),
);

const handleSelesai = () => {
    if (!isAllAnswered.value) {
        return;
    }

    router.visit('/tes-online/gaya-belajar/selesai');
};
</script>

<template>
    <div
        class="mx-auto mt-4 mb-6 w-full max-w-6xl px-3 sm:mt-6 sm:px-5 md:mt-8 md:px-6"
    >
        <div
            class="mb-5 rounded-2xl border border-slate-200 bg-white p-4 text-center shadow-sm sm:mb-6 sm:p-5"
        >
            <p
                class="text-sm font-semibold text-gray-700 sm:text-base md:text-lg"
            >
                Dari 30 pernyataan ini, pilih jawaban yang paling sesuai dengan
                diri Anda.
            </p>
        </div>

        <div class="space-y-3 md:hidden">
            <article
                v-for="(item, index) in daftarPernyataan"
                :key="item.id"
                class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm"
            >
                <p class="text-xs font-semibold text-slate-500">
                    No. {{ index + 1 }}
                </p>
                <p
                    class="mt-1 text-sm leading-relaxed font-medium text-slate-800"
                >
                    {{ item.teks }}
                </p>

                <div class="mt-3 grid grid-cols-3 gap-2">
                    <label
                        class="flex cursor-pointer flex-col items-center justify-center rounded-lg border px-2 py-2 text-center text-xs font-semibold"
                        :class="
                            item.jawaban === 1
                                ? 'border-primary bg-primary text-white'
                                : 'border-slate-200 bg-slate-50 text-slate-700'
                        "
                    >
                        <input
                            type="radio"
                            class="sr-only"
                            :name="'pertanyaan-mobile-' + item.id"
                            :value="1"
                            v-model="item.jawaban"
                        />
                        <span>1</span>
                        <span class="mt-0.5">Tidak Sesuai</span>
                    </label>

                    <label
                        class="flex cursor-pointer flex-col items-center justify-center rounded-lg border px-2 py-2 text-center text-xs font-semibold"
                        :class="
                            item.jawaban === 2
                                ? 'border-primary bg-primary text-white'
                                : 'border-slate-200 bg-slate-50 text-slate-700'
                        "
                    >
                        <input
                            type="radio"
                            class="sr-only"
                            :name="'pertanyaan-mobile-' + item.id"
                            :value="2"
                            v-model="item.jawaban"
                        />
                        <span>2</span>
                        <span class="mt-0.5">Cukup Sesuai</span>
                    </label>

                    <label
                        class="flex cursor-pointer flex-col items-center justify-center rounded-lg border px-2 py-2 text-center text-xs font-semibold"
                        :class="
                            item.jawaban === 3
                                ? 'border-primary bg-primary text-white'
                                : 'border-slate-200 bg-slate-50 text-slate-700'
                        "
                    >
                        <input
                            type="radio"
                            class="sr-only"
                            :name="'pertanyaan-mobile-' + item.id"
                            :value="3"
                            v-model="item.jawaban"
                        />
                        <span>3</span>
                        <span class="mt-0.5">Sangat Sesuai</span>
                    </label>
                </div>
            </article>
        </div>

        <div
            class="hidden overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm md:block"
        >
            <table class="w-full border-collapse text-sm">
                <thead class="bg-gray-100">
                    <tr class="text-center">
                        <th class="w-12 border border-slate-200 p-2">No</th>
                        <th class="border border-slate-200 p-2 text-left">
                            Pernyataan
                        </th>
                        <th class="w-28 border border-slate-200 p-2">
                            Tidak Sesuai
                        </th>
                        <th class="w-28 border border-slate-200 p-2">
                            Cukup Sesuai
                        </th>
                        <th class="w-28 border border-slate-200 p-2">
                            Sangat Sesuai
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="(item, index) in daftarPernyataan"
                        :key="item.id"
                        class="text-center"
                    >
                        <td class="border border-slate-200 p-3">
                            {{ index + 1 }}
                        </td>
                        <td class="border border-slate-200 p-3 text-left">
                            {{ item.teks }}
                        </td>

                        <td class="border border-slate-200 p-3">
                            <label
                                class="flex cursor-pointer items-center justify-center rounded-md px-3 py-2 text-xs font-semibold lg:text-sm"
                                :class="
                                    item.jawaban === 1
                                        ? 'bg-primary text-white'
                                        : 'bg-gray-200 text-slate-700'
                                "
                            >
                                <input
                                    type="radio"
                                    class="sr-only"
                                    :name="'pertanyaan-tablet-' + item.id"
                                    :value="1"
                                    v-model="item.jawaban"
                                />
                                1
                            </label>
                        </td>

                        <td class="border border-slate-200 p-3">
                            <label
                                class="flex cursor-pointer items-center justify-center rounded-md px-3 py-2 text-xs font-semibold lg:text-sm"
                                :class="
                                    item.jawaban === 2
                                        ? 'bg-primary text-white'
                                        : 'bg-gray-200 text-slate-700'
                                "
                            >
                                <input
                                    type="radio"
                                    class="sr-only"
                                    :name="'pertanyaan-tablet-' + item.id"
                                    :value="2"
                                    v-model="item.jawaban"
                                />
                                2
                            </label>
                        </td>

                        <td class="border border-slate-200 p-3">
                            <label
                                class="flex cursor-pointer items-center justify-center rounded-md px-3 py-2 text-xs font-semibold lg:text-sm"
                                :class="
                                    item.jawaban === 3
                                        ? 'bg-primary text-white'
                                        : 'bg-gray-200 text-slate-700'
                                "
                            >
                                <input
                                    type="radio"
                                    class="sr-only"
                                    :name="'pertanyaan-tablet-' + item.id"
                                    :value="3"
                                    v-model="item.jawaban"
                                />
                                3
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
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
