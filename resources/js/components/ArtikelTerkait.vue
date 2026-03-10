<script setup lang="ts">
import { artikel } from '@/routes';
import { Link } from '@inertiajs/vue3';
import Artikel from './Artikel.vue';
</script>

<template>
    <div class="mt-16">
        <h3 class="text-2xl font-semibold text-primary">Artikel Terkait</h3>

        <Artikel :limit="3" :hide-header="true" />

        <div class="text-center">
            <Link
                :href="artikel().url"
                class="rounded-full bg-primary px-6 py-3 text-sm font-semibold text-white transition hover:bg-green-900"
            >
                Kembali ke Halaman Artikel
            </Link>
        </div>
    </div>
</template>
