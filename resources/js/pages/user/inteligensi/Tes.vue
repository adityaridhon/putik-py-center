<script setup lang="ts">
import { computed, ref } from 'vue';
import Navbar from '@/components/Navbar.vue';
import HalamanInstruksi from '@/components/HalamanInstruksi.vue';
import SoalIsian from '@/components/SoalInteligensiIsian.vue';
import SoalPilihan from '@/components/SoalInteligensiPilihan.vue';
import { router } from '@inertiajs/vue3';

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
const labelKategoriAktif = computed(() => kodeKategoriAktif.value);
const isLastKategori = computed(
    () => kategoriIndex.value === kategoriTes.length - 1,
);
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

    if (!isLastKategori.value) {
        kategoriIndex.value++;
        mode.value = 'instruksi';
        return;
    }

    selesaiTes();
};

const selesaiTes = () => {
    if (!bisaLanjut.value) {
        return;
    }

    router.post('/tes-online/inteligensi/submit', {
        answers: jawaban.value
    }, {
        preserveScroll: true,
        onError: (errors) => {
            console.error('Submission error:', errors);
            if (errors.token) {
                alert(errors.token);
                router.visit('/tes-online/inteligensi');
            }
        }
    });
};
</script>

<template>
    <div class="min-h-screen bg-slate-50">
        <Navbar title="TES INTELIGENSI" />

        <main
            class="mx-auto mt-4 mb-6 w-full max-w-5xl px-3 sm:mt-6 sm:px-5 md:mt-8 md:px-6"
        >
            <!-- INSTRUKSI -->
            <HalamanInstruksi
                v-if="mode === 'instruksi'"
                :kategori="labelKategoriAktif"
                :instruksi="kategoriAktif.instruksi"
                :waktu="kategoriAktif.waktuInstruksi"
                @mulai="mulaiTes"
            />

            <!-- SOAL PILIHAN -->
            <SoalPilihan
                v-if="mode === 'soal' && kategoriAktif.tipe === 'pilihan'"
                :soal="
                    kategoriAktif.soal as {
                        pertanyaan: string;
                        opsi: string[];
                    }[]
                "
                :kategori="labelKategoriAktif"
                :waktu="kategoriAktif.waktuSoal"
                v-model="jawaban[kategoriAktif.kode]"
            />

            <!-- SOAL ISIAN -->
            <SoalIsian
                v-if="mode === 'soal' && kategoriAktif.tipe === 'isian'"
                :soal="kategoriAktif.soal as string[]"
                :kategori="labelKategoriAktif"
                :waktu="kategoriAktif.waktuSoal"
                v-model="jawaban[kategoriAktif.kode]"
            />

            <div v-if="mode === 'soal'" class="mt-6 flex justify-end">
                <button
                    type="button"
                    class="rounded-lg px-5 py-2.5 text-sm font-medium text-white"
                    :class="
                        !bisaLanjut
                            ? 'cursor-not-allowed bg-gray-400'
                            : 'bg-primary hover:bg-green-900'
                    "
                    :disabled="!bisaLanjut"
                    @click="nextKategori"
                >
                    {{ isLastKategori ? 'Selesai' : 'Selanjutnya' }}
                </button>
            </div>
        </main>
    </div>
</template>
