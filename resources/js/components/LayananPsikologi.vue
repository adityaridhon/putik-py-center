<script setup lang="ts">
import { watch } from 'vue';

const layanan = defineModel<string>('layanan');
const opsi = defineModel<string>('opsi');
const perusahaan = defineModel<string>('perusahaan');
const jumlahPeserta = defineModel<number>('jumlahPeserta');

const daftarLayanan = [
    'Tes Kepribadian',
    'Tes Kematangan Kesiapan Masuk SD',
    'Tes Penjurusan Bimbingan Karir',
    'Tes Perusahaan',
    'Tes Talent Mapping',
    'Tes Inteligensi',
    'Tes Gaya Belajar',
    'Tes Minat Bakat',
];

function btn(active: boolean) {
    return `px-4 py-2 rounded-full border transition ${
        active
            ? 'bg-primary text-white border-primary'
            : 'bg-white text-primary border-gray-300 hover:border-primary'
    }`;
}

// Reset opsi & form tambahan saat ganti layanan
watch(layanan, () => {
    opsi.value = '';
    perusahaan.value = '';
    jumlahPeserta.value = undefined;
});
</script>

<template>
    <div class="space-y-6 rounded border p-6">
        <div>
            <p class="font-semibold text-primary">Layanan yang Dibutuhkan</p>

            <div class="mt-3 space-y-2">
                <div
                    v-for="item in daftarLayanan"
                    :key="item"
                    @click="layanan = item"
                    class="flex cursor-pointer items-center gap-3"
                >
                    <div
                        class="h-4 w-4 rounded-full border"
                        :class="
                            layanan === item
                                ? 'border-primary bg-primary'
                                : 'border-gray-300 bg-gray-200'
                        "
                    ></div>

                    <span
                        :class="
                            layanan === item ? 'font-semibold text-primary' : ''
                        "
                    >
                        {{ item }}
                    </span>
                </div>
            </div>
        </div>

        <div v-if="layanan">
            <p class="font-semibold text-primary">Pilih Opsi</p>

            <div class="mt-3 flex gap-4">
                <button
                    @click="opsi = 'Personal'"
                    :class="btn(opsi === 'Personal')"
                >
                    Personal
                </button>

                <button
                    @click="opsi = 'Klasikal'"
                    :class="btn(opsi === 'Klasikal')"
                >
                    Klasikal
                </button>
            </div>
        </div>

        <div v-if="opsi === 'Klasikal'" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-primary">
                    Perusahaan/Instansi
                </label>
                <input
                    v-model="perusahaan"
                    type="text"
                    placeholder="Contoh: PT Maju Jaya"
                    class="mt-1 w-full rounded-lg border px-3 py-2 focus:border-primary focus:outline-none"
                />
            </div>

            <div>
                <label class="block text-sm font-medium text-primary">
                    Jumlah Peserta
                </label>
                <input
                    v-model="jumlahPeserta"
                    type="number"
                    min="1"
                    placeholder="Masukkan jumlah peserta"
                    class="mt-1 w-full rounded-lg border px-3 py-2 focus:border-primary focus:outline-none"
                />
            </div>
        </div>
    </div>
</template>
