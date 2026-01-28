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
    <div class="h-screen bg-primary">
        <div
            class="wrapper mx-auto flex max-w-3xl flex-col items-center justify-between px-8 pt-32 md:max-w-4xl md:gap-10 lg:max-w-5xl lg:flex-row-reverse lg:items-center"
        >
            <div class="image flex items-center">
                <img
                    :src="
                        profile?.landing_image_url
                            ? `/storage/${profile.landing_image_url}`
                            : '/images/Hero_1.png'
                    "
                    alt="hero"
                    class="mb-5 w-50 md:mb-0 md:w-90"
                />
            </div>
            <div
                class="caption flex max-w-lg flex-col gap-2 text-center lg:text-left"
            >
                <h1
                    class="font-title text-4xl font-bold text-white md:text-5xl"
                >
                    {{ profile?.company_name || 'PUTIK PSYCHOLOGY CENTER' }} :
                    <span class="text-white"
                        >Solusi Psikologi Terpadu & Terpercaya</span
                    >
                </h1>
                <p class="mb-20 text-base text-white">
                    {{
                        profile?.headline ||
                        'Mitra terpercaya dalam pemecahan masalah psikologis untuk individu, pendidikan, dan perusahaan di Balikpapan sejak 2006'
                    }}
                </p>
            </div>
        </div>
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 1440 320"
            class="absolute -bottom-15"
        >
            <path
                fill="#ffffff"
                fill-opacity="1"
                d="M0,192L80,165.3C160,139,320,85,480,96C640,107,800,181,960,192C1120,203,1280,149,1360,122.7L1440,96L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"
            ></path>
        </svg>
    </div>
</template>
