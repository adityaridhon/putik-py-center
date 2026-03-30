<script setup lang="ts">
defineProps<{
    profile?: {
        company_name?: string;
        headline?: string;
        landing_image_url?: string;
    };
}>();
</script>

<template>
    <section class="relative isolate overflow-hidden bg-primary">
        <div
            class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.24),transparent_54%)]"
        ></div>
        <div
            class="absolute -top-24 -left-20 h-72 w-72 rounded-full bg-white/10 blur-3xl"
        ></div>
        <div
            class="absolute -right-24 bottom-10 h-64 w-64 rounded-full bg-emerald-200/20 blur-3xl"
        ></div>
        <div
            class="absolute inset-x-0 top-0 h-28 bg-gradient-to-b from-black/10 to-transparent"
        ></div>

        <div
            class="wrapper relative mx-auto flex min-h-[500px] max-w-7xl items-center justify-center px-4 pt-20 pb-12 sm:px-6 sm:pt-24 sm:pb-14 md:min-h-[560px] md:px-8 md:pt-24 md:pb-16 lg:min-h-[600px] lg:px-10"
        >
            <div
                class="caption flex w-full max-w-4xl flex-col items-center gap-5 rounded-3xl border border-white/20 bg-white/[0.07] px-5 py-8 text-center shadow-[0_22px_70px_rgba(0,0,0,0.2)] backdrop-blur-[3px] sm:px-8 sm:py-10 md:gap-6 md:px-10"
            >
                <span
                    class="inline-flex items-center rounded-full border border-white/35 bg-white/15 px-4 py-1 text-xs font-semibold tracking-[0.18em] text-white/95"
                >
                    PUTIK PSYCHOLOGY CENTER
                </span>

                <p
                    class="text-xs font-medium tracking-[0.2em] text-emerald-100/90 uppercase"
                >
                    Layanan Psikologi Terintegrasi
                </p>

                <h1
                    class="font-title text-[30px] leading-tight font-bold text-balance text-white sm:text-4xl md:text-5xl lg:text-[56px]"
                >
                    <span class="block text-emerald-100">
                        Solusi Psikologi Terpadu &amp; Terpercaya
                    </span>
                </h1>

                <div
                    class="h-px w-28 bg-gradient-to-r from-transparent via-emerald-100/80 to-transparent"
                ></div>

                <p
                    class="max-w-2xl text-sm leading-relaxed text-white/90 sm:text-base md:text-lg"
                >
                    {{
                        profile?.headline ||
                        'Mitra terpercaya dalam pemecahan masalah psikologis untuk individu, pendidikan, dan perusahaan di Balikpapan sejak 2006'
                    }}
                </p>

                <div
                    class="mt-1 flex flex-wrap items-center justify-center gap-2"
                >
                    <span
                        class="rounded-full border border-white/25 bg-white/10 px-3 py-1 text-xs font-medium text-white"
                    >
                        Sejak 2006
                    </span>
                    <span
                        class="rounded-full border border-white/25 bg-white/10 px-3 py-1 text-xs font-medium text-white"
                    >
                        Humanis &amp; Profesional
                    </span>
                    <span
                        class="rounded-full border border-white/25 bg-white/10 px-3 py-1 text-xs font-medium text-white"
                    >
                        Individu, Sekolah, Perusahaan
                    </span>
                </div>
            </div>
        </div>
    </section>
</template>
