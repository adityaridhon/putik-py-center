<script setup lang="ts">
defineProps<{
    psychologists?: Array<{
        id: number;
        name: string;
        specialization?: string | null;
        photo_url?: string | null;
    }>;
}>();
</script>

<template>
    <div
        class="wrapper mx-auto flex max-w-7xl flex-col gap-8 px-4 py-8 sm:px-6 md:gap-10 md:px-8 lg:flex-row lg:items-start lg:px-10"
    >
        <div class="image flex justify-center lg:justify-start">
            <img
                src="/images/Direktur.png"
                alt="hero"
                class="w-full max-w-xs overflow-hidden rounded-3xl shadow-lg sm:max-w-sm"
            />
        </div>

        <div
            class="caption flex max-w-2xl flex-col items-center gap-4 text-center lg:items-start lg:text-left"
        >
            <h1 class="font-title mb-4 text-3xl font-bold sm:text-4xl">
                TIM KAMI
            </h1>

            <p
                class="mx-auto max-w-prose text-justify text-base leading-relaxed text-primary lg:mx-0"
            >
                Putik Psychology Center memiliki Sumber Daya Manusia dengan
                latar belakang pendidikan psikologi dan memiliki kompetensi
                serta pengalaman yang beragam, sesuai dengan berbagai jenis jasa
                dan pelayanan yang akan diberikan kepada masyarakat.
            </p>
            <p>
                Selain memiliki tenaga tetap, Putik juga merekrut tenaga lepasan
                (Associates) yang telah dilatih dan memiliki pengalaman dalam
                memberikan pelayanan psikologi yang dibutuhkan dibawah
                koordinasi dan tanggung jawab psikolog yang telah memiliki
                pengalaman dan izin praktek SIPP (Surat Izin Praktek Psikologi)
                yang terdaftar di HIMPSI (Himpunan Psikologi Indonesia).
            </p>
            <div
                class="w-full rounded-2xl bg-linear-to-r from-primary/80 to-emerald-600/70 px-6 py-4 text-center text-sm font-semibold text-white shadow-lg"
            >
                <p class="leading-tight">
                    Rr. Herjati Shofiastoeti, S.Psi., Psikolog
                </p>
                <p class="text-xs tracking-[0.2em] text-emerald-100 uppercase">
                    Direktur
                </p>
            </div>
        </div>
    </div>

    <!-- KARTU TIM PSIKOLOG -->
    <div
        class="mx-auto mt-8 grid max-w-7xl grid-cols-1 gap-6 px-4 pb-10 sm:grid-cols-2 sm:px-6 md:grid-cols-3 md:px-8 lg:grid-cols-4 lg:px-10"
    >
        <div
            v-for="psychologist in psychologists"
            :key="psychologist.id"
            class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-lg transition-all hover:-translate-y-1 hover:shadow-xl"
        >
            <img
                :src="psychologist.photo_url || '/images/logo_putik.webp'"
                :alt="psychologist.name"
                class="h-64 w-full object-cover"
            />
            <div class="space-y-1 p-4">
                <p class="line-clamp-2 text-base font-semibold text-gray-900">
                    {{ psychologist.name }}
                </p>
                <p class="line-clamp-2 text-sm text-gray-600">
                    {{ psychologist.specialization || 'Psikolog' }}
                </p>
            </div>
        </div>

        <div
            v-if="!psychologists || psychologists.length === 0"
            class="col-span-full rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-6 text-center text-gray-500"
        >
            Data psikolog belum tersedia.
        </div>
    </div>
</template>
