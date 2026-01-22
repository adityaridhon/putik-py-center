<script setup lang="ts">
import Button from './ui/button/Button.vue';
</script>

<template>
    <div
        class="wrapper mx-auto flex max-w-3xl flex-col gap-8 px-8 pt-8 md:max-w-4xl lg:max-w-5xl lg:flex-row lg:items-start"
    >
        <div class="image">
            <img
                src="/images/Tim_Putik.png"
                alt="hero"
                class="w-200 md:w-200"
            />
        </div>

        <div class="caption max-w-lg text-center lg:text-left">
            <h1 class="font-title mb-4 text-4xl font-bold md:text-6xl">
                TIM KAMI
            </h1>

            <p class="text-base text-primary">
                Layanan psikologi terpadu di bawah pengawasan Psikolog Senior
                bersertifikasi SIPP & HIMPSI
            </p>
        </div>
    </div>
    <div class="flex justify-center mt-10">
        <Button class=""> Lihat Profil Tim </Button>
    </div>
</template>
