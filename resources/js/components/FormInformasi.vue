<script setup lang="ts">
import { watch } from 'vue';

interface FormData {
    nama: string;
    hp: string;
    email: string;
    topik: string;
}

const model = defineModel<FormData>({
    default: {
        nama: '',
        hp: '',
        email: '',
        topik: '',
    },
});

// Fungsi untuk memvalidasi input nama (hanya huruf dan spasi)
const validateNama = (value: string) => {
    return value.replace(/[^a-zA-Z\s]/g, '');
};

// Fungsi untuk memvalidasi input HP (hanya angka)
const validateHp = (value: string) => {
    return value.replace(/[^0-9]/g, '');
};
</script>

<template>
    <h2 class="text-center text-xl font-semibold text-primary sm:text-2xl">
        DAFTAR LAYANAN
    </h2>

    <div
        class="space-y-6 rounded-xl border bg-white p-5 shadow-sm sm:p-6 md:p-8"
    >
        <h2 class="text-lg font-semibold text-primary">Informasi Pribadi</h2>

        <div class="space-y-2">
            <label class="text-sm font-medium">
                Nama Lengkap <span class="text-red-500">*</span>
            </label>
            <input
                v-model.lazy="model.nama"
                @blur="model.nama = validateNama(model.nama)"
                type="text"
                placeholder="Masukkan nama lengkap Anda"
                class="w-full rounded-lg border bg-slate-100 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
            />
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium">
                Nomor HP <span class="text-red-500">*</span>
            </label>
            <input
                v-model.lazy="model.hp"
                @blur="model.hp = validateHp(model.hp)"
                type="tel"
                placeholder="08xxxxxxxxxx"
                inputmode="numeric"
                class="w-full rounded-lg border bg-slate-100 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
            />
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium">
                Email <span class="text-red-500">*</span>
            </label>
            <input
                v-model="model.email"
                type="email"
                placeholder="contoh@gmail.com"
                pattern="^[a-zA-Z0-9._%+-]+@gmail\.com$"
                title="Gunakan email Gmail (contoh@gmail.com)"
                class="w-full rounded-lg border bg-slate-100 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
            />
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium">
                Topik Permasalahan <span class="text-red-500">*</span>
            </label>
            <textarea
                v-model="model.topik"
                rows="4"
                placeholder="Jelaskan secara singkat permasalahan atau tujuan konsultasi Anda"
                class="w-full rounded-lg border bg-slate-100 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
            ></textarea>
        </div>
    </div>
</template>
