<script setup lang="ts">
const kategori = defineModel<string>();

const kategoriPilihan = [
    {
        id: 'children_center',
        title: 'Children Center',
        description:
            'Program khusus anak-anak dan remaja dengan pendekatan bermain dan edukatif untuk mendukung perkembangan yang sehat.',
    },
    {
        id: 'konseling_terapi',
        title: 'Konseling & Terapi',
        description:
            'Pendampingan konseling perorangan atau keluarga untuk mengatasi stres, kecemasan, atau tantangan hubungan.',
    },
    {
        id: 'pemeriksaan_psikologi',
        title: 'Pemeriksaan Psikologi',
        description:
            'Assessment psikologis lengkap (intelegensi, kepribadian, minat-bakat) dengan laporan resmi dari tim profesional.',
    },
];
</script>

<template>
    <div class="space-y-4 rounded border p-6">
        <div>
            <p class="text-xs tracking-[0.4em] text-gray-500 uppercase">
                Kategori Layanan
            </p>
            <h2 class="text-xl font-semibold text-gray-900">
                Pilih layanan yang Anda butuhkan
            </h2>
        </div>

        <div class="grid gap-3 md:grid-cols-3">
            <button
                v-for="option in kategoriPilihan"
                :key="option.id"
                type="button"
                @click="kategori = option.id"
                :class="[
                    'rounded-lg border p-4 text-left transition focus-visible:ring-2 focus-visible:ring-green-600 focus-visible:outline-none',
                    kategori === option.id
                        ? 'border-green-600 bg-green-50 shadow-[0_10px_25px_rgba(16,185,129,0.25)]'
                        : 'border-gray-200 hover:border-green-600',
                ]"
            >
                <p class="text-base font-semibold text-gray-900">
                    {{ option.title }}
                </p>
                <p class="mt-2 text-sm leading-relaxed text-gray-600">
                    {{ option.description }}
                </p>
            </button>
        </div>

        <p class="text-sm text-gray-600">
            Pilih satu kategori agar detail layanan lain seperti jadwal dan opsi
            dapat ditampilkan.
        </p>
    </div>
</template>
