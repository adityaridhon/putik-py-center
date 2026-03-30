<script setup lang="ts">
import { computed, ref } from 'vue';
import NavbarTes from '@/components/NavbarTes.vue';
import HalamanInstruksi from '@/components/HalamanInstruksi.vue';
import NavigasiInteligensi from '@/components/NavigasiInteligensi.vue';
import SoalIsian from '@/components/SoalInteligensiIsian.vue';
import SoalPilihan from '@/components/SoalInteligensiPilihan.vue';
import { router } from '@inertiajs/vue3';

const kategoriList = ['SE', 'WA', 'AN', 'GE', 'RA', 'ZR', 'FA', 'WU', 'ME'];

// DATA TES
const kategoriTes = [
    {
        kode: 'SE',
        tipe: 'pilihan',
        waktuInstruksi: 180,
        waktuSoal: 180,
        instruksi:
            'Pilih kata yang paling tepat untuk melengkapi kalimat berikut. Setiap soal terdiri dari satu kalimat yang belum lengkap dan beberapa pilihan jawaban. Tugas Anda adalah menentukan satu kata yang paling sesuai untuk melengkapi kalimat tersebut sehingga menjadi kalimat yang logis, jelas, dan bermakna. Bacalah setiap kalimat dengan teliti sebelum memilih jawaban. Perhatikan konteks, hubungan antar kata, serta makna keseluruhan kalimat. Pilihlah jawaban yang menurut Anda paling benar.',
        soal: [
            {
                pertanyaan: 'Ibu sedang .... makanan',
                opsi: ['memasak', 'menata', 'merias', 'mengolah', 'merata'],
            },
            {
                pertanyaan: 'Awan .... besok pagi',
                opsi: ['akan berjalan', 'akan berangkat', 'akan melompat'],
            },
        ],
    },
    {
        kode: 'WA',
        tipe: 'pilihan',
        waktuInstruksi: 180,
        waktuSoal: 180,
        instruksi:
            'Pilih kata yang paling tepat untuk melengkapi kalimat berikut. Bacalah konteks kalimat dengan teliti dan pilih jawaban yang paling logis.',
        soal: [
            {
                pertanyaan: 'Kita harus .... aturan agar hidup tertib',
                opsi: ['menaati', 'menghindari', 'menghapus', 'menunda'],
            },
            {
                pertanyaan: 'Adik sangat .... saat menerima hadiah',
                opsi: ['gembira', 'gelap', 'kering', 'pendek'],
            },
        ],
    },
    {
        kode: 'AN',
        tipe: 'pilihan',
        waktuInstruksi: 180,
        waktuSoal: 180,
        instruksi:
            'Temukan hubungan kata yang paling tepat pada setiap soal, lalu pilih opsi jawaban yang paling sesuai.',
        soal: [
            {
                pertanyaan: 'Panas : Api = Dingin : ....',
                opsi: ['Es', 'Asap', 'Air', 'Uap'],
            },
            {
                pertanyaan: 'Dokter : Rumah Sakit = Guru : ....',
                opsi: ['Sekolah', 'Perpustakaan', 'Pasar', 'Kantor'],
            },
        ],
    },
    {
        kode: 'GE',
        tipe: 'pilihan',
        waktuInstruksi: 180,
        waktuSoal: 180,
        instruksi:
            'Pilih jawaban yang paling tepat berdasarkan pemahaman umum dan konsep sederhana geometri atau bentuk.',
        soal: [
            {
                pertanyaan: 'Bangun datar dengan 3 sisi disebut ....',
                opsi: ['Segitiga', 'Persegi', 'Lingkaran', 'Trapesium'],
            },
            {
                pertanyaan: 'Benda berbentuk bola memiliki permukaan ....',
                opsi: ['Lengkung', 'Datar', 'Bersudut', 'Bertingkat'],
            },
        ],
    },
    {
        kode: 'RA',
        tipe: 'pilihan',
        waktuInstruksi: 180,
        waktuSoal: 180,
        instruksi:
            'Selesaikan soal hitungan sederhana dengan memilih hasil yang paling benar.',
        soal: [
            {
                pertanyaan: '25 + 17 = ....',
                opsi: ['42', '41', '43', '40'],
            },
            {
                pertanyaan: '9 x 6 = ....',
                opsi: ['54', '56', '46', '64'],
            },
        ],
    },
    {
        kode: 'ZR',
        tipe: 'pilihan',
        waktuInstruksi: 180,
        waktuSoal: 180,
        instruksi:
            'Perhatikan pola atau urutan sederhana, lalu pilih jawaban yang paling tepat.',
        soal: [
            {
                pertanyaan: '2, 4, 6, 8, ....',
                opsi: ['10', '11', '12', '9'],
            },
            {
                pertanyaan: 'A, C, E, G, ....',
                opsi: ['I', 'H', 'J', 'K'],
            },
        ],
    },
    {
        kode: 'FA',
        tipe: 'pilihan',
        waktuInstruksi: 180,
        waktuSoal: 180,
        instruksi:
            'Pilih kata atau pernyataan yang paling tepat sesuai konteks soal yang diberikan.',
        soal: [
            {
                pertanyaan: 'Sinonim kata "cepat" adalah ....',
                opsi: ['Lekas', 'Lambat', 'Sering', 'Panjang'],
            },
            {
                pertanyaan: 'Lawan kata "besar" adalah ....',
                opsi: ['Kecil', 'Tinggi', 'Luas', 'Jauh'],
            },
        ],
    },
    {
        kode: 'WU',
        tipe: 'pilihan',
        waktuInstruksi: 180,
        waktuSoal: 180,
        instruksi:
            'Baca pertanyaan dengan cermat, lalu pilih jawaban yang paling tepat.',
        soal: [
            {
                pertanyaan: 'Hari setelah Senin adalah ....',
                opsi: ['Selasa', 'Rabu', 'Minggu', 'Jumat'],
            },
            {
                pertanyaan: 'Ibukota Indonesia adalah ....',
                opsi: ['Jakarta', 'Bandung', 'Surabaya', 'Medan'],
            },
        ],
    },
    {
        kode: 'ME',
        tipe: 'isian',
        waktuInstruksi: 180,
        waktuSoal: 180,
        instruksi: 'Hafalkan kata berikut dan tuliskan kembali.',
        soal: ['BUNGA', 'PERKAKAS', 'BURUNG'],
    },
];

// STATE
const kategoriIndex = ref(0);
const mode = ref<'instruksi' | 'soal'>('instruksi');

const jawaban: any = ref({});

// kategori aktif
const kategoriAktif = computed(() => kategoriTes[kategoriIndex.value]);
const kodeKategoriAktif = computed(() => kategoriAktif.value.kode);
const jawabanKategoriAktif = computed<string[]>(() => {
    return jawaban.value[kodeKategoriAktif.value] ?? [];
});

const bisaLanjut = computed(() => {
    if (kategoriAktif.value.tipe === 'pilihan') {
        const daftarSoal = kategoriAktif.value.soal as {
            pertanyaan: string;
            opsi: string[];
        }[];

        return daftarSoal.every(
            (_, index) =>
                typeof jawabanKategoriAktif.value[index] === 'string' &&
                jawabanKategoriAktif.value[index].trim() !== '',
        );
    }

    const daftarSoal = kategoriAktif.value.soal as string[];

    return daftarSoal.every(
        (_, index) =>
            typeof jawabanKategoriAktif.value[index] === 'string' &&
            jawabanKategoriAktif.value[index].trim() !== '',
    );
});

// pindah mode
const mulaiTes = () => {
    mode.value = 'soal';
};

// next kategori
const nextKategori = () => {
    if (!bisaLanjut.value) {
        return;
    }

    if (kategoriIndex.value < kategoriTes.length - 1) {
        kategoriIndex.value++;
        mode.value = 'instruksi';
    }
};

// prev kategori
const prevKategori = () => {
    if (kategoriIndex.value > 0) {
        kategoriIndex.value--;
        mode.value = 'instruksi';
    }
};

const ubahKategori = (kode: string) => {
    const indexTujuan = kategoriTes.findIndex((item) => item.kode === kode);

    if (indexTujuan !== -1) {
        if (indexTujuan > kategoriIndex.value && !bisaLanjut.value) {
            return;
        }

        kategoriIndex.value = indexTujuan;
        mode.value = 'instruksi';
    }
};

const selesaiTes = () => {
    if (!bisaLanjut.value) {
        return;
    }

    router.visit('/tes-online/inteligensi/selesai');
};
</script>

<template>
    <div class="min-h-screen bg-slate-50">
        <NavbarTes judul="TES INTELIGENSI" />

        <main
            class="mx-auto mt-4 mb-6 w-full max-w-5xl px-3 sm:mt-6 sm:px-5 md:mt-8 md:px-6"
        >
            <!-- INSTRUKSI -->
            <HalamanInstruksi
                v-if="mode === 'instruksi'"
                :kategori="kodeKategoriAktif"
                :instruksi="kategoriAktif.instruksi"
                :waktu="kategoriAktif.waktuInstruksi"
                @mulai="mulaiTes"
            />

            <div
                v-if="mode === 'soal'"
                class="mb-4 inline-flex items-center rounded-full border border-primary/20 bg-primary/10 px-3 py-1.5 text-xs font-semibold text-primary sm:px-4 sm:py-2 sm:text-sm"
            >
                Kategori Soal: {{ kodeKategoriAktif }}
            </div>

            <!-- SOAL PILIHAN -->
            <SoalPilihan
                v-if="mode === 'soal' && kategoriAktif.tipe === 'pilihan'"
                :soal="
                    kategoriAktif.soal as {
                        pertanyaan: string;
                        opsi: string[];
                    }[]
                "
                :waktu="kategoriAktif.waktuSoal"
                v-model="jawaban[kategoriAktif.kode]"
            />

            <!-- SOAL ISIAN -->
            <SoalIsian
                v-if="mode === 'soal' && kategoriAktif.tipe === 'isian'"
                :soal="kategoriAktif.soal as string[]"
                :waktu="kategoriAktif.waktuSoal"
                v-model="jawaban[kategoriAktif.kode]"
            />

            <!-- NAVIGASI -->
            <NavigasiInteligensi
                v-if="mode === 'soal'"
                :kategori-aktif="kodeKategoriAktif"
                :kategori="kategoriList"
                :disable-next="!bisaLanjut"
                @ubah-kategori="ubahKategori"
                @selanjutnya="nextKategori"
                @sebelumnya="prevKategori"
                @selesai="selesaiTes"
            />
        </main>
    </div>
</template>
