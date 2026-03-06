<script setup lang="ts">
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

const handleNama = (event: Event) => {
    const target = event.target as HTMLInputElement;
    target.value = target.value.replace(/[^a-zA-Z\s]/g, '');
    model.value.nama = target.value;
};

const handleHp = (event: Event) => {
    const target = event.target as HTMLInputElement;
    target.value = target.value.replace(/[^0-9]/g, '');
    model.value.hp = target.value;
};
</script>

<template>
    <h2 class="mt-24 text-center text-2xl font-semibold text-primary">
        DAFTAR LAYANAN
    </h2>

    <div class="space-y-6 rounded-xl border bg-white p-8 shadow-sm">
        <h2 class="text-lg font-semibold text-primary">Informasi Pribadi</h2>

        <div class="space-y-2">
            <label class="text-sm font-medium">
                Nama Lengkap <span class="text-red-500">*</span>
            </label>
            <input
                :value="model.nama"
                @input="handleNama"
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
                :value="model.hp"
                @input="handleHp"
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
