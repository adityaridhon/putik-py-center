<script setup lang="ts">
import Button from './ui/button/Button.vue';
</script>

<template>
    <div
        class="wrapper mx-auto flex max-w-3xl flex-col gap-8 px-6 pt-10 py-6 md:max-w-4xl lg:max-w-5xl lg:flex-row lg:items-start"
    >
        <div class="image">
            <img
                src="/images/Tim_Putik.png"
                alt="hero"
                class="w-200 md:w-200"
            />
        </div>

        <div
            class="caption flex max-w-lg flex-col items-center gap-4 text-center lg:items-start lg:text-left"
        >
            <h1 class="font-title mb-4 text-4xl font-bold md:text-4xl">
                TIM KAMI
            </h1>

            <p class="text-base text-primary">
                Layanan psikologi terpadu di bawah pengawasan Psikolog Senior
                bersertifikasi SIPP & HIMPSI
            </p>

            <Button
                class="rounded border border-primary bg-transparent px-6 py-3 text-primary transition hover:bg-primary/10"
            >
                Lihat Profil Tim
            </Button>
        </div>
    </div>
</template>
