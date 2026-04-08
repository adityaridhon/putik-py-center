<script setup lang="ts">
import Navbar from '@/components/Navbar.vue';
import NavigasiKategori from '@/components/NavigasiKategori.vue';
import TabelIsian from '@/components/TabelIsian.vue';
import TabelRangking from '@/components/TabelRangking.vue';
import { router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

interface MinatBakatCategory {
    code: string;
    name: string;
    instruction?: string | null;
    has_jobs: boolean;
    jobs: string[];
}

const props = defineProps<{
    categories?: MinatBakatCategory[];
}>();

const categories = computed<MinatBakatCategory[]>(() => {
    const fromBackend = (props.categories ?? []).filter(
        (category) => category?.code,
    );

    if (fromBackend.length > 0) {
        return fromBackend;
    }

    // Fallback ketika data backend belum tersedia.
    return [
        {
            code: 'A',
            name: 'Kategori A',
            instruction: 'Pilih pekerjaan yang paling Anda minati.',
            has_jobs: true,
            jobs: [
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
        },
        {
            code: 'B',
            name: 'Kategori B',
            instruction: 'Pilih pekerjaan yang paling Anda minati.',
            has_jobs: true,
            jobs: [
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
        },
        {
            code: 'I',
            name: 'Pekerjaan Favorit',
            instruction:
                'Tuliskan 3 pekerjaan yang paling ingin anda lakukan.',
            has_jobs: false,
            jobs: [],
        },
    ];
});

const kategoriList = computed(() => categories.value.map((item) => item.code));

const kategoriAktif = ref(kategoriList.value[0] ?? 'A');

// jawaban user
const jawabanRanking = ref<Record<string, number[]>>({});
const jawabanIsian = ref<Record<string, string[]>>({});

const kategoriAktifData = computed<MinatBakatCategory | undefined>(() =>
    categories.value.find((category) => category.code === kategoriAktif.value),
);

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
    return kategoriAktifData.value?.has_jobs ? 'ranking' : 'isian';
});

const pekerjaanAktif = computed<string[]>(() => {
    return kategoriAktifData.value?.jobs ?? [];
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
                jawaban[index] <= pekerjaan.length,
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

    const index = kategoriList.value.indexOf(kategoriAktif.value);

    if (index < kategoriList.value.length - 1) {
        kategoriAktif.value = kategoriList.value[index + 1];
    }
};

const prevKategori = () => {
    const index = kategoriList.value.indexOf(kategoriAktif.value);

    if (index > 0) {
        kategoriAktif.value = kategoriList.value[index - 1];
    }
};

const ubahKategori = (kategoriTujuan: string) => {
    const indexSaatIni = kategoriList.value.indexOf(kategoriAktif.value);
    const indexTujuan = kategoriList.value.indexOf(kategoriTujuan);

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

    router.post('/tes-online/minat-bakat/submit', {
        answers: {
            ranking: jawabanRanking.value,
            isian: jawabanIsian.value,
        },
    }, {
        preserveScroll: true,
        onError: (errors) => {
            console.error('Submission error:', errors);
            if (errors.token) {
                alert(errors.token);
                router.visit('/tes-online/minat-bakat');
            }
        },
    });
};
</script>

<template>
    <Navbar title="TES MINAT BAKAT" />
    <div
        class="mx-auto mt-6 max-w-5xl px-4 sm:mt-8 sm:px-6 md:mt-10 md:px-8 lg:px-10"
    >
        <h2 class="mb-4 text-center text-base font-semibold sm:text-lg">
            {{ kategoriAktifData?.name ?? `Kategori ${kategoriAktif}` }}
        </h2>

        <p
            v-if="tipeAktif === 'ranking'"
            class="mb-6 text-center text-xs sm:text-sm"
        >
            {{
                kategoriAktifData?.instruction ||
                `Beri peringkat pekerjaan berikut dari 1 (paling disukai) sampai ${pekerjaanAktif.length} (paling tidak disukai).`
            }}
        </p>

        <p
            v-if="tipeAktif === 'isian'"
            class="mb-6 text-center text-xs sm:text-sm"
        >
            {{
                kategoriAktifData?.instruction ||
                'Tuliskan 3 pekerjaan yang paling ingin anda lakukan'
            }}
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
            :categories="kategoriList"
            :disable-next="!bisaLanjut"
            @ubahKategori="ubahKategori"
            @selanjutnya="nextKategori"
            @sebelumnya="prevKategori"
            @selesai="selesaiTes"
        />
    </div>
</template>
