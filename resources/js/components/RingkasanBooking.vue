<script setup lang="ts">
import { computed } from 'vue';

interface FormData {
    nama: string;
    hp: string;
    email: string;
    topik?: string;
}

const props = defineProps<{
    form: FormData;
    kategori?: string;
    layanan?: string;
    opsi?: string;
    perusahaan?: string;
    jumlahOrang?: number;
    tanggal: string;
    jam: string;
}>();

const tanggalLengkap = computed(() => {
    if (!props.tanggal) return '';

    const date = new Date(props.tanggal);

    return date.toLocaleDateString('id-ID', {
        weekday: 'long',
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    });
});

const isKlasikal = computed(() => props.opsi?.toLowerCase() === 'klasikal');

const kategoriLabels: Record<string, string> = {
    children_center: 'Children Center',
    konseling_terapi: 'Konseling dan Terapi',
    pemeriksaan_psikologi: 'Pemeriksaan Psikologi',
};

const namaLayanan = computed(() => {
    if (props.layanan) {
        const layanan = props.layanan.toLowerCase();

        if (layanan.includes('psikologi')) {
            return 'Pemeriksaan Psikologi';
        }

        if (layanan.includes('children')) {
            return 'Children Center';
        }

        if (layanan.includes('konseling') || layanan.includes('terapi')) {
            return 'Konseling / Terapi';
        }

        return props.layanan;
    }

    if (props.kategori) {
        return kategoriLabels[props.kategori] ?? 'Layanan pilihan Anda';
    }

    return '';
});

const whatsappNumber = '628125581350';

const whatsappMessageUrl = computed(() => {
    const lines: string[] = [
        'Halo Putik Psychological Center, saya ingin konfirmasi layanan.',
        `Nama: ${props.form.nama}`,
        `Nomor HP: ${props.form.hp}`,
        `Email: ${props.form.email}`,
        props.form.topik ? `Topik: ${props.form.topik}` : '',
        namaLayanan.value ? `Layanan: ${namaLayanan.value}` : '',
        props.opsi ? `Opsi: ${props.opsi}` : '',
        props.perusahaan ? `Perusahaan/Instansi: ${props.perusahaan}` : '',
        props.jumlahOrang ? `Jumlah Peserta: ${props.jumlahOrang}` : '',
        `Tanggal: ${tanggalLengkap.value}`,
        `Jam: ${props.jam} WITA`,
    ];

    const text = lines.filter(Boolean).join('\n');

    return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(text)}`;
});
</script>

<template>
    <div class="w-full rounded-xl border bg-white p-8 shadow-md">
        <h2 class="mb-6 text-center text-2xl font-bold text-primary">
            KONFIRMASI
        </h2>

        <!-- ringkasan booking -->
        <div
            class="divide-y divide-gray-400 overflow-hidden rounded-lg border border-gray-400 text-sm"
        >
            <div class="grid grid-cols-[200px_20px_1fr] p-2">
                <span class="font-semibold">Nama Lengkap</span>
                <span>:</span>
                <span>{{ props.form.nama }}</span>
            </div>

            <div class="grid grid-cols-[200px_20px_1fr] p-2">
                <span class="font-semibold">No. HP</span>
                <span>:</span>
                <span>{{ props.form.hp }}</span>
            </div>

            <div class="grid grid-cols-[200px_20px_1fr] p-2">
                <span class="font-semibold">Email</span>
                <span>:</span>
                <span>{{ props.form.email }}</span>
            </div>

            <div
                v-if="props.form.topik"
                class="grid grid-cols-[200px_20px_1fr] p-2"
            >
                <span class="font-semibold">Topik Permasalahan</span>
                <span>:</span>
                <span
                    class="block min-w-0 leading-relaxed wrap-break-word whitespace-normal"
                >
                    {{ props.form.topik }}
                </span>
            </div>

            <div v-if="namaLayanan" class="grid grid-cols-[200px_20px_1fr] p-2">
                <span class="font-semibold">Layanan</span>
                <span>:</span>
                <span>{{ namaLayanan }}</span>
            </div>

            <div v-if="props.opsi" class="grid grid-cols-[200px_20px_1fr] p-2">
                <span class="font-semibold">Opsi</span>
                <span>:</span>
                <span>{{ props.opsi }}</span>
            </div>

            <div
                v-if="isKlasikal && props.jumlahOrang"
                class="grid grid-cols-[200px_20px_1fr] p-2"
            >
                <span class="font-semibold">Jumlah Orang</span>
                <span>:</span>
                <span>{{ props.jumlahOrang }}</span>
            </div>

            <div
                v-if="isKlasikal && props.perusahaan"
                class="grid grid-cols-[200px_20px_1fr] p-2"
            >
                <span class="font-semibold">Perusahaan/Instansi</span>
                <span>:</span>
                <span>{{ props.perusahaan }}</span>
            </div>

            <div class="grid grid-cols-[200px_20px_1fr] p-2">
                <span class="font-semibold">Tanggal & Waktu</span>
                <span>:</span>
                <span>
                    <div>{{ tanggalLengkap }}</div>
                    <div>Pukul {{ props.jam }} WITA</div>
                </span>
            </div>

            <div class="grid grid-cols-[200px_20px_1fr] p-2">
                <span class="font-semibold">Total Estimasi</span>
                <span>:</span>
                <span>Konfirmasi via WhatsApp</span>
            </div>
        </div>

        <div class="mt-8 flex justify-center">
            <a
                :href="whatsappMessageUrl"
                target="_blank"
                rel="noopener noreferrer"
                class="flex items-center gap-2 rounded-lg bg-primary px-6 py-3 text-white shadow transition hover:bg-green-900"
            >
                WhatsApp
            </a>
        </div>
    </div>
</template>
