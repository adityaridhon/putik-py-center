<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import FormInformasi from '@/components/FormInformasi.vue';
import Jadwal from '@/components/Jadwal.vue';
import LayananPsikologi from '@/components/LayananPsikologi.vue';
import Navbar from '@/components/Navbar.vue';
import PilihKategori from '@/components/PilihKategori.vue';
import RingkasanBooking from '@/components/RingkasanBooking.vue';
import { Check } from 'lucide-vue-next';
import ScrollProgressBar from '@/components/ScrollProgressBar.vue';

import { computed, ref, watch } from 'vue';

const props = defineProps<{
    bookedSlots?: Array<{
        booking_date: string;
        booking_time: string;
        status: string;
    }>;
    flash?: {
        success?: string;
        error?: string;
    };
}>();

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
const jumlahPeserta = ref<number | undefined>(undefined);
const tanggal = ref('');
const jam = ref('');
const konfirmasi = ref(false);

const isPsikologi = computed(() => kategori.value === 'pemeriksaan_psikologi');

const isFormFilled = computed(() => {
    const { nama, hp, email, topik } = dataForm.value;
    return Boolean(nama.trim() && hp.trim() && email.trim() && topik.trim());
});

const canConfirm = computed(() => {
    return Boolean(
        kategori.value && tanggal.value && jam.value && isFormFilled.value,
    );
});

const confirmButtonLabel = computed(() => {
    return konfirmasi.value
        ? 'Pendaftaran Terkonfirmasi'
        : 'Konfirmasi Pendaftaran';
});

const handleConfirm = () => {
    if (!canConfirm.value || konfirmasi.value) {
        return;
    }

    konfirmasi.value = true;
};

// Auto-scroll ke bagian jadwal ketika kategori dipilih
watch(kategori, (newKategori) => {
    if (!newKategori) {
        return;
    }

    if (newKategori === 'pemeriksaan_psikologi') {
        return;
    }

    // Delay sedikit untuk memastikan komponen ter-render
    setTimeout(() => {
        const jadwalElement = document.querySelector('[data-jadwal-section]');
        if (jadwalElement) {
            jadwalElement.scrollIntoView({
                behavior: 'smooth',
                block: 'start',
            });
        }
    }, 100);
});

// Auto-scroll ke bagian jadwal ketika pilihan layanan psikologi dipilih
watch(layanan, (newLayanan) => {
    if (kategori.value !== 'pemeriksaan_psikologi' || !newLayanan) {
        return;
    }

    setTimeout(() => {
        const jadwalElement = document.querySelector('[data-jadwal-section]');
        if (jadwalElement) {
            jadwalElement.scrollIntoView({
                behavior: 'smooth',
                block: 'start',
            });
        }
    }, 100);
});

// Auto-scroll ke bagian jam ketika tanggal dipilih
watch(tanggal, (newTanggal) => {
    if (newTanggal) {
        // Delay sedikit untuk memastikan komponen ter-render
        setTimeout(() => {
            const jamElement = document.querySelector('[data-jam-section]');
            if (jamElement) {
                jamElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start',
                });
            }
        }, 100);
    }
});

// Auto-scroll ke bagian konfirmasi ketika tombol konfirmasi diklik
watch(konfirmasi, (newKonfirmasi) => {
    if (newKonfirmasi) {
        // Delay sedikit untuk memastikan komponen ter-render
        setTimeout(() => {
            const konfirmasiElement = document.querySelector(
                '[data-konfirmasi-section]',
            );
            if (konfirmasiElement) {
                konfirmasiElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start',
                });
            }
        }, 100);
    }
});

// Reset form setelah booking berhasil
const resetForm = () => {
    dataForm.value = {
        nama: '',
        hp: '',
        email: '',
        topik: '',
    };
    kategori.value = '';
    layanan.value = '';
    opsi.value = '';
    perusahaan.value = '';
    jumlahPeserta.value = undefined;
    tanggal.value = '';
    jam.value = '';
    konfirmasi.value = false;
};

// Watch untuk flash message success
watch(
    () => props.flash?.success,
    (newSuccess) => {
        if (newSuccess) {
            resetForm();
        }
    },
    { immediate: true },
);
</script>

<template>
    <div class="overflow-x-hidden">
        <Navbar />
        <ScrollProgressBar />   
        <section
            class="mx-auto max-w-5xl space-y-6 px-4 pt-24 pb-10 sm:space-y-8 sm:px-6 md:px-8 lg:px-10"
        >
            <FormInformasi v-model="dataForm" />

            <PilihKategori v-model="kategori" />

            <LayananPsikologi
                v-if="isPsikologi"
                v-model:layanan="layanan"
                v-model:opsi="opsi"
                v-model:perusahaan="perusahaan"
                v-model:jumlahPeserta="jumlahPeserta"
            />

            <Jadwal
                v-if="kategori"
                v-model:tanggal="tanggal"
                v-model:jam="jam"
                :is-confirmed="konfirmasi"
                :booked-slots="props.bookedSlots || []"
                data-jadwal-section
            />

            <button
                v-if="kategori"
                type="button"
                :disabled="!canConfirm || konfirmasi"
                @click="handleConfirm"
                class="flex w-full items-center justify-center gap-2 rounded-xl px-5 py-3 text-sm font-medium transition sm:px-6 sm:text-base"
                :class="
                    konfirmasi
                        ? 'cursor-not-allowed bg-gray-300 text-gray-600'
                        : canConfirm
                          ? 'bg-primary text-white hover:bg-green-900'
                          : 'cursor-not-allowed bg-gray-300 text-gray-600'
                "
            >
                <Check class="h-5 w-5" />
                {{ confirmButtonLabel }}
            </button>

            <RingkasanBooking
                v-if="konfirmasi"
                :form="dataForm"
                :kategori="kategori"
                :layanan="layanan"
                :opsi="opsi"
                :perusahaan="perusahaan"
                :jumlah-orang="jumlahPeserta"
                :tanggal="tanggal"
                :jam="jam"
                @booked="resetForm"
            />
        </section>
        <Footer />
    </div>
</template>
