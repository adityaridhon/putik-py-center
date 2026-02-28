<script setup lang="ts">
import { computed, ref } from 'vue';

import FormInformasi from '@/components/FormInformasi.vue';
import Jadwal from '@/components/Jadwal.vue';
import LayananPsikologi from '@/components/LayananPsikologi.vue';
import PilihKategori from '@/components/PilihKategori.vue';
import RingkasanBooking from '@/components/RingkasanBooking.vue';

const dataForm = ref({
    nama: '',
    hp: '',
    email: '',
    topik: '',
});

const kategori = ref('');
const layanan = ref('');
const opsi = ref('');
const perusahaan = ref('');
const tanggal = ref('');
const jam = ref('');
const konfirmasi = ref(false);

const isPsikologi = computed(() => kategori.value === 'pemeriksaan_psikologi');
</script>

<template>
    <section class="mx-auto max-w-5xl space-y-8 p-8">
        <FormInformasi v-model="dataForm" />

        <PilihKategori v-model="kategori" />

        <LayananPsikologi
            v-if="isPsikologi"
            v-model:layanan="layanan"
            v-model:opsi="opsi"
            v-model:perusahaan="perusahaan"
        />

        <Jadwal v-if="kategori" v-model:tanggal="tanggal" v-model:jam="jam" />

        <button
            v-if="kategori && tanggal && jam"
            @click="konfirmasi = true"
            class="rounded bg-green-700 px-6 py-3 text-white"
        >
            Konfirmasi
        </button>

        <RingkasanBooking
            v-if="konfirmasi"
            :form="dataForm"
            :kategori="kategori"
            :layanan="layanan"
            :opsi="opsi"
            :perusahaan="perusahaan"
            :tanggal="tanggal"
            :jam="jam"
        />
    </section>
</template>
