<script setup lang="ts"></script>

<template>
    <div
        class="wrapper mx-auto flex max-w-3xl flex-col gap-8 px-6 py-6 pt-10 md:max-w-4xl lg:max-w-5xl lg:flex-row lg:items-start"
    >
        <div class="image">
            <img src="/images/Direktur.png" alt="hero" class="overflow-hidden rounded-3xl shadow-lg w-100 md:w-100" />
        </div>

        <div
            class="caption flex max-w-lg flex-col items-center gap-4 text-center lg:items-start lg:text-left"
        >
            <h1 class="font-title mb-4 text-4xl font-bold md:text-4xl">
                TIM KAMI
            </h1>

            <p class="text-base text-primary">
                Putik Psychology Center memiliki Sumber Daya Manusia dengan
                latar belakang pendidikan psikologi dan memiliki kompetensi
                serta pengalaman yang beragam, sesuai dengan berbagai jenis jasa
                dan pelayanan yang akan diberikan kepada masyarakat.
            </p>
            <div
                class="w-full rounded-2xl bg-gradient-to-r from-primary/80 to-emerald-600/70 px-6 py-4 text-center text-sm font-semibold text-white shadow-lg"
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

    <!-- PARAGRAF TAMBAHAN -->
    <div class="mx-auto max-w-5xl px-6">
        <p class="text-base leading-relaxed text-primary">
            Selain memiliki tenaga tetap, Putik juga merekrut tenaga lepasan
            (Associates) yang telah dilatih dan memiliki pengalaman dalam
            memberikan pelayanan psikologi yang dibutuhkan dibawah koordinasi
            dan tanggung jawab psikolog yang telah memiliki pengalaman dan izin
            praktek SIPP (Surat Izin Praktek Psikologi) yang terdaftar di HIMPSI
            (Himpunan Psikologi Indonesia).
        </p>
    </div>

    <!-- FOTO TIM -->
    <div
        class="pb-10 mx-auto mt-8 grid max-w-5xl grid-cols-1 gap-8 px-6 md:grid-cols-2"
    >
        <div class="overflow-hidden rounded-3xl shadow-lg">
            <img
                src="/images/Tim_Putik.png"
                alt="Tim Putik"
                class="h-80 w-full object-cover"
            />
        </div>

        <div class="overflow-hidden rounded-3xl shadow-lg">
            <img
                src="/images/Tim_Putik2.png"
                alt="Tim Putik"
                class="h-80 w-full object-cover"
            />
        </div>
    </div>
</template>
