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
    <div class="mx-auto mt-12 max-w-6xl px-8">
        <!-- Judul -->
        <div class="mb-6 text-center">
            <p class="text-lg font-semibold text-gray-700">
                Dari 30 pernyataan ini, pilih jawaban yang paling sesuai dengan
                diri Anda.
            </p>
        </div>

        <!-- Tabel -->
        <div class="overflow-hidden rounded-lg border">
            <table class="w-full border-collapse">
                <!-- Header -->
                <thead class="bg-gray-100">
                    <tr class="text-center text-sm">
                        <th class="w-12 border p-2">No</th>
                        <th class="border p-2 text-left">Pernyataan</th>
                        <th class="w-20 border p-2">Tidak Sesuai</th>
                        <th class="w-20 border p-2">Cukup Sesuai</th>
                        <th class="w-20 border p-2">Sangat Sesuai</th>
                    </tr>
                </thead>

                <!-- Isi -->
                <tbody>
                    <tr
                        v-for="(item, index) in daftarPernyataan"
                        :key="item.id"
                        class="text-center"
                    >
                        <td class="border p-3">{{ index + 1 }}</td>

                        <td class="border p-3 text-left">
                            {{ item.teks }}
                        </td>

                        <!-- 1 -->
                        <td class="border p-3">
                            <label
                                class="flex cursor-pointer items-center justify-center rounded-md px-3 py-1"
                                :class="
                                    item.jawaban === 1
                                        ? 'bg-primary text-white'
                                        : 'bg-gray-200'
                                "
                            >
                                <input
                                    type="radio"
                                    class="hidden"
                                    :name="'pertanyaan' + item.id"
                                    :value="1"
                                    v-model="item.jawaban"
                                />
                                1
                            </label>
                        </td>

                        <!-- 2 -->
                        <td class="border p-3">
                            <label
                                class="flex cursor-pointer items-center justify-center rounded-md px-3 py-1"
                                :class="
                                    item.jawaban === 2
                                        ? 'bg-primary text-white'
                                        : 'bg-gray-200'
                                "
                            >
                                <input
                                    type="radio"
                                    class="hidden"
                                    :name="'pertanyaan' + item.id"
                                    :value="2"
                                    v-model="item.jawaban"
                                />
                                2
                            </label>
                        </td>

                        <!-- 3 -->
                        <td class="border p-3">
                            <label
                                class="flex cursor-pointer items-center justify-center rounded-md px-3 py-1"
                                :class="
                                    item.jawaban === 3
                                        ? 'bg-primary text-white'
                                        : 'bg-gray-200'
                                "
                            >
                                <input
                                    type="radio"
                                    class="hidden"
                                    :name="'pertanyaan' + item.id"
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

        <!-- Tombol -->
        <div class="mt-6 flex justify-end">
            <button
                type="button"
                :disabled="!isAllAnswered"
                @click="handleSelesai"
                :class="[
                    'flex items-center gap-2 rounded-lg px-6 py-2 text-white transition',
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
