<script setup lang="ts">
import { tentangKami } from '@/routes';
import { Link } from '@inertiajs/vue3';
import Button from './ui/button/Button.vue';
</script>

<template>
    <div
        class="wrapper mx-auto flex max-w-7xl flex-col gap-8 px-4 py-8 sm:px-6 md:px-8 lg:flex-row lg:items-start lg:px-10"
    >
        <div class="image overflow-hidden rounded-3xl shadow-lg">
            <img
                src="/images/Tim_Putik.png"
                alt="hero"
                class="w-full max-w-md lg:max-w-lg"
            />
        </div>

        <div
            class="caption flex max-w-lg flex-col items-center gap-4 text-center lg:items-start lg:text-left"
        >
            <h1 class="font-title mb-4 text-3xl font-bold sm:text-4xl">
                TIM KAMI
            </h1>

            <p class="max-w-prose text-base leading-relaxed text-primary">
                Layanan psikologi terpadu di bawah pengawasan Psikolog Senior
                bersertifikasi SIPP & HIMPSI
            </p>

            <Link :href="tentangKami().url" class="w-full">
                <Button
                    class="rounded border border-primary bg-transparent px-6 py-3 text-primary transition hover:bg-primary/10"
                >
                    Lihat Profil Tim
                </Button>
            </Link>
        </div>
    </div>
</template>
