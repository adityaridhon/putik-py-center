<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import FormInformasi from '@/components/FormInformasi.vue';
import Jadwal from '@/components/Jadwal.vue';
import LayananPsikologi from '@/components/LayananPsikologi.vue';
import Navbar from '@/components/Navbar.vue';
import PilihKategori from '@/components/PilihKategori.vue';
import RingkasanBooking from '@/components/RingkasanBooking.vue';
import { Check } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const props = defineProps<{
    bookedSlots?: Array<{
        booking_date: string;
        booking_time: string;
        status: string;
    }>;
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

const handleConfirm = () => {
    if (!canConfirm.value) {
        return;
    }

    konfirmasi.value = true;
};
</script>

<template>
    <section class="mx-auto max-w-5xl space-y-8 p-8">
        <Navbar />

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
        />

        <button
            v-if="kategori"
            type="button"
            :disabled="!canConfirm"
            @click="handleConfirm"
            class="flex w-full items-center justify-center gap-2 rounded-xl px-6 py-3 font-medium transition"
            :class="
                canConfirm
                    ? 'bg-primary text-white'
                    : 'cursor-not-allowed bg-gray-300 text-gray-600'
            "
        >
            <Check class="h-5 w-5" />
            Konfirmasi Pendaftaran
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
        />
    </section>
    <Footer />
</template>
