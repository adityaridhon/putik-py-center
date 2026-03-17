<script setup lang="ts">
import NavbarTes from '@/components/NavbarTes.vue';
import NavigasiKategori from '@/components/NavigasiKategori.vue';
import TabelIsian from '@/components/TabelIsian.vue';
import TabelRangking from '@/components/TabelRangking.vue';
import { router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const kategoriList = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];

const kategoriAktif = ref('A');

// tipe kategori
const tipeKategori: any = {
    A: 'ranking',
    B: 'ranking',
    C: 'ranking',
    D: 'ranking',
    E: 'ranking',
    F: 'ranking',
    G: 'ranking',
    H: 'ranking',
    I: 'isian',
};

// contoh data pekerjaan
const dataTes: any = {
    A: [
        'Polisi Lalu Lintas',
        'Insinyur Sipil',
        'Akuntan',
        'Ilmuwati',
        'Penjual Hasil Mode',
        'Seniman',
        'Wartawan',
        'Pianis Konser',
        'Guru Sekolah Dasar',
        'Sekretaris',
        'Penata Busana',
        'Dokter',
    ],

    B: [
        'Petugas Komnas HAM',
        'Pegawai Tata Usaha',
        'Koki/Chef',
        'Dokter Anak',
        'Atlit',
        'Kontraktor',
        'Petugas Pajak',
        'Laboran',
        'Manager Promosi',
        'Perancang Motif Tekstil',
        'Penyair',
        'Komposer',
    ],
};

// jawaban user
const jawabanRanking: any = ref({});
const jawabanIsian: any = ref({});

const rankingAktif = computed({
    get: () => jawabanRanking.value[kategoriAktif.value] ?? [],
    set: (value: number[]) => {
        jawabanRanking.value[kategoriAktif.value] = value;
    },
});

const isianAktif = computed({
    get: () => jawabanIsian.value[kategoriAktif.value] ?? [],
    set: (value: string[]) => {
        jawabanIsian.value[kategoriAktif.value] = value;
    },
});

// kategori sekarang
const tipeAktif = computed(() => {
    return tipeKategori[kategoriAktif.value];
});

const nextKategori = () => {
    const index = kategoriList.indexOf(kategoriAktif.value);

    if (index < kategoriList.length - 1) {
        kategoriAktif.value = kategoriList[index + 1];
    }
};

const prevKategori = () => {
    const index = kategoriList.indexOf(kategoriAktif.value);

    if (index > 0) {
        kategoriAktif.value = kategoriList[index - 1];
    }
};

const selesaiTes = () => {
    router.visit('/tes-online/minat-bakat/selesai');
};
</script>

<template>
    <NavbarTes judul="TES MINAT BAKAT" />
    <div class="mx-auto mt-10 max-w-5xl">
        <h2 class="mb-4 text-center text-lg font-semibold">
            Kategori {{ kategoriAktif }}
        </h2>

        <p v-if="tipeAktif === 'ranking'" class="mb-6 text-center text-sm">
            Beri Peringkat Pekerjaan Berikut ini dari 1 (paling disukai) sampai
            12 (paling tidak disukai)
        </p>

        <p v-if="tipeAktif === 'isian'" class="mb-6 text-center text-sm">
            Tuliskan 3 pekerjaan yang paling ingin anda lakukan
        </p>

        <!-- ranking -->

        <TabelRangking
            v-if="tipeAktif === 'ranking'"
            :pekerjaan="dataTes[kategoriAktif]"
            v-model="rankingAktif"
        />

        <!-- isian -->

        <TabelIsian v-if="tipeAktif === 'isian'" v-model="isianAktif" />

        <NavigasiKategori
            :kategoriAktif="kategoriAktif"
            @ubahKategori="kategoriAktif = $event"
            @selanjutnya="nextKategori"
            @sebelumnya="prevKategori"
            @selesai="selesaiTes"
        />
    </div>
</template>
