<script setup lang="ts">
import Navbar from '@/components/Navbar.vue';
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

const pekerjaanAktif = computed<string[]>(() => {
    return dataTes[kategoriAktif.value] ?? [];
});

const isRankingLengkap = computed(() => {
    const pekerjaan = pekerjaanAktif.value;
    const jawaban = jawabanRanking.value[kategoriAktif.value] ?? [];

    return (
        pekerjaan.length > 0 &&
        pekerjaan.every(
            (_, index) =>
                typeof jawaban[index] === 'number' &&
                jawaban[index] >= 1 &&
                jawaban[index] <= 12,
        )
    );
});

const isIsianLengkap = computed(() => {
    const jawaban = jawabanIsian.value[kategoriAktif.value] ?? [];

    return [0, 1, 2].every(
        (index) =>
            typeof jawaban[index] === 'string' && jawaban[index].trim() !== '',
    );
});

const bisaLanjut = computed(() => {
    return tipeAktif.value === 'ranking'
        ? isRankingLengkap.value
        : isIsianLengkap.value;
});

const nextKategori = () => {
    if (!bisaLanjut.value) {
        return;
    }

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

const ubahKategori = (kategoriTujuan: string) => {
    const indexSaatIni = kategoriList.indexOf(kategoriAktif.value);
    const indexTujuan = kategoriList.indexOf(kategoriTujuan);

    if (indexTujuan === -1) {
        return;
    }

    // Selalu boleh kembali ke kategori sebelumnya; maju hanya jika kategori aktif sudah lengkap.
    if (indexTujuan <= indexSaatIni || bisaLanjut.value) {
        kategoriAktif.value = kategoriTujuan;
    }
};

const selesaiTes = () => {
    if (!bisaLanjut.value) {
        return;
    }

    router.visit('/tes-online/minat-bakat/selesai');
};
</script>

<template>
    <Navbar title="TES MINAT BAKAT" />
    <div
        class="mx-auto mt-6 max-w-5xl px-4 sm:mt-8 sm:px-6 md:mt-10 md:px-8 lg:px-10"
    >
        <h2 class="mb-4 text-center text-base font-semibold sm:text-lg">
            Kategori {{ kategoriAktif }}
        </h2>

        <p
            v-if="tipeAktif === 'ranking'"
            class="mb-6 text-center text-xs sm:text-sm"
        >
            Beri Peringkat Pekerjaan Berikut ini dari 1 (paling disukai) sampai
            12 (paling tidak disukai)
        </p>

        <p
            v-if="tipeAktif === 'isian'"
            class="mb-6 text-center text-xs sm:text-sm"
        >
            Tuliskan 3 pekerjaan yang paling ingin anda lakukan
        </p>

        <!-- ranking -->

        <TabelRangking
            v-if="tipeAktif === 'ranking'"
            :pekerjaan="pekerjaanAktif"
            v-model="rankingAktif"
        />

        <!-- isian -->

        <TabelIsian v-if="tipeAktif === 'isian'" v-model="isianAktif" />

        <NavigasiKategori
            :kategoriAktif="kategoriAktif"
            :disable-next="!bisaLanjut"
            @ubahKategori="ubahKategori"
            @selanjutnya="nextKategori"
            @sebelumnya="prevKategori"
            @selesai="selesaiTes"
        />
    </div>
</template>
