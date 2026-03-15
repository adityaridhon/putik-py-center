<script setup lang="ts">
interface FormData {
    nama: string;
    tanggalLahir: string;
    tanggalTes: string;
    jenisKelamin: string;
    token: string;
}

const model = defineModel<FormData>({
    default: {
        nama: '',
        tanggalLahir: '',
        tanggalTes: '',
        jenisKelamin: '',
        token: '',
    },
});

const handleNama = (event: Event) => {
    const target = event.target as HTMLInputElement;
    target.value = target.value.replace(/[^a-zA-Z\s]/g, '');
    model.value.nama = target.value;
};

const today = new Date().toISOString().split('T')[0];

const openDatePicker = (event: Event) => {
    const input = event.target as HTMLInputElement & {
        showPicker?: () => void;
    };

    input.showPicker?.();
};

const blockManualDateInput = (event: KeyboardEvent) => {
    const allowedKeys = ['Tab', 'Shift', 'Escape'];

    if (allowedKeys.includes(event.key)) {
        return;
    }

    event.preventDefault();
};
</script>

<template>
    <div
        class="mx-auto mt-8 mb-20 max-w-3xl space-y-6 rounded-xl border bg-white p-8 shadow-sm"
    >
        <h2 class="text-lg font-semibold text-primary">Informasi Peserta</h2>

        <div class="space-y-2">
            <label class="text-sm font-medium"> Nama Lengkap </label>
            <input
                :value="model.nama"
                @input="handleNama"
                type="text"
                placeholder="Masukkan nama lengkap Anda"
                class="w-full rounded-lg border bg-slate-100 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
            />
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium"> Tanggal Lahir </label>
            <input
                v-model="model.tanggalLahir"
                type="date"
                :max="today"
                @click="openDatePicker"
                @keydown="blockManualDateInput"
                @paste.prevent
                class="w-full cursor-pointer rounded-lg border bg-slate-100 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
            />
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium"> Tanggal Tes </label>
            <input
                v-model="model.tanggalTes"
                type="date"
                :min="today"
                @click="openDatePicker"
                @keydown="blockManualDateInput"
                @paste.prevent
                class="w-full cursor-pointer rounded-lg border bg-slate-100 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
            />
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium">Jenis Kelamin</label>

            <div class="flex items-center gap-6">
                <label class="flex cursor-pointer items-center gap-2">
                    <input
                        type="radio"
                        name="jenisKelamin"
                        value="Pria"
                        v-model="model.jenisKelamin"
                        class="accent-primary"
                    />
                    Pria
                </label>

                <label class="flex cursor-pointer items-center gap-2">
                    <input
                        type="radio"
                        name="jenisKelamin"
                        value="Wanita"
                        v-model="model.jenisKelamin"
                        class="accent-primary"
                    />
                    Wanita
                </label>
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium"> Token </label>
            <input
                v-model="model.token"
                type="text"
                placeholder="Masukkan token tes"
                class="w-full rounded-lg border bg-slate-100 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
            />
        </div>

        <button
            class="mt-4 w-full rounded-lg bg-primary py-2 text-white transition hover:opacity-90"
        >
            Mulai Tes
        </button>
    </div>
</template>
