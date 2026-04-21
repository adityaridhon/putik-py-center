<script setup lang="ts">
import { computed } from 'vue';
import { Vue3Marquee } from 'vue3-marquee';

const props = defineProps<{
    partnerLogos?: string[];
}>();

const hasLogos = computed(() => (props.partnerLogos?.length ?? 0) > 0);

const firstRowLogos = computed(() =>
    (props.partnerLogos ?? []).filter((_, index) => index % 2 === 0),
);

const secondRowLogos = computed(() =>
    (props.partnerLogos ?? []).filter((_, index) => index % 2 === 1),
);
</script>
<template>
    <div class="mt-10 pb-10 text-center">
        <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 md:px-8 lg:px-10">
            <h1 class="font-title text-3xl font-bold sm:text-4xl">
                Klien Kami
            </h1>
            <p
                class="mx-auto max-w-3xl px-4 py-6 text-center text-sm text-primary sm:text-base"
            >
                Klien kami mencakup perusahaan, organisasi, dan pendidikan.
            </p>
        </div>
        <div v-if="hasLogos" class="space-y-4">
            <Vue3Marquee :duration="50" :pause-on-hover="true">
                <div
                    class="card"
                    v-for="companyClient in firstRowLogos"
                    :key="`row-1-${companyClient}`"
                >
                    <img
                        :src="companyClient"
                        width="120"
                        class="mx-6 w-20 sm:mx-8 sm:w-24 md:mx-10 md:w-[120px]"
                        alt="Mitra Logo"
                    />
                </div>
            </Vue3Marquee>

            <Vue3Marquee
                v-if="secondRowLogos.length"
                :duration="55"
                :pause-on-hover="true"
                :direction="'reverse'"
            >
                <div
                    class="card"
                    v-for="companyClient in secondRowLogos"
                    :key="`row-2-${companyClient}`"
                >
                    <img
                        :src="companyClient"
                        width="120"
                        class="mx-6 w-20 sm:mx-8 sm:w-24 md:mx-10 md:w-[120px]"
                        alt="Mitra Logo"
                    />
                </div>
            </Vue3Marquee>
        </div>
        <p v-else class="text-sm text-gray-500">Belum ada logo partner.</p>
    </div>
</template>
