<script setup lang="ts">
import { router } from '@inertiajs/vue3';

defineProps<{
    judulTes: string;
}>();

const whatsappNumber = '628125581350';

const handleKembaliKeBeranda = () => {
    router.visit('/');
};

const handleHubungiPsikolog = () => {
    const url = `https://wa.me/${whatsappNumber}`;
    window.open(url, '_blank');
};
</script>

<template>
    <div class="flex min-h-screen items-center justify-center bg-slate-100 p-6">
        <div
            class="w-full max-w-md rounded-2xl bg-white p-8 text-center shadow-lg"
        >
            <!-- Icon -->
            <div
                class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-primary text-3xl text-white"
            >
                ✓
            </div>

            <!-- Judul -->
            <h2 class="text-xl font-semibold text-gray-800">
                Tes {{ judulTes }} Selesai
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Terima kasih telah menyelesaikan tes
            </p>

            <!-- Deskripsi -->
            <p class="mt-4 text-sm text-gray-600">
                Jawaban Anda telah berhasil terkirim dan akan dianalisis oleh
                tim psikolog profesional dari
                <span class="font-medium text-primary">
                    Putik Psychology Center.
                </span>
            </p>

            <!-- Informasi -->
            <div
                class="mt-6 rounded-xl bg-slate-100 p-4 text-left text-sm text-gray-600"
            >
                <p class="mb-1 font-semibold text-gray-700">
                    Penting untuk Diketahui
                </p>
                <p>
                    Hasil tes tidak akan ditampilkan secara langsung di
                    aplikasi. Hasil akan disampaikan melalui laporan tertulis
                    atau sesi konsultasi dengan psikolog kami.
                </p>
            </div>

            <!-- Tombol -->
            <div class="mt-6 space-y-3">
                <button
                    type="button"
                    @click="handleKembaliKeBeranda"
                    class="w-full rounded-lg bg-primary py-2 font-medium text-white transition hover:bg-emerald-900"
                >
                    Kembali ke Beranda
                </button>

                <button
                    type="button"
                    @click="handleHubungiPsikolog"
                    class="w-full rounded-lg border border-primary py-2 font-medium text-emerald-950 transition hover:bg-emerald-50"
                >
                    Hubungi Psikolog
                </button>
            </div>
        </div>
    </div>
</template>
