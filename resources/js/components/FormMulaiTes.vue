<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = withDefaults(
    defineProps<{
        submitUrl?: string; // Endpoint to validate and start the test
    }>(),
    {
        submitUrl: '',
    },
);

const form = useForm({
    nama: '',
    tanggalLahir: '',
    tanggalTes: '',
    jenisKelamin: '',
    token: '',
});

const handleNama = (event: Event) => {
    const target = event.target as HTMLInputElement;
    target.value = target.value.replace(/[^a-zA-Z\s]/g, '');
    form.nama = target.value;
};

const handleTanggalLahir = (event: Event) => {
    const target = event.target as HTMLInputElement;
    form.tanggalLahir = target.value;
};

const handleTanggalTes = (event: Event) => {
    const target = event.target as HTMLInputElement;
    form.tanggalTes = target.value;
};

const handleJenisKelamin = (value: string) => {
    form.jenisKelamin = value;
};

const handleToken = (event: Event) => {
    const target = event.target as HTMLInputElement;
    form.token = target.value.toUpperCase();
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

const isFormComplete = computed(() => {
    return (
        form.nama.trim() !== '' &&
        form.tanggalLahir !== '' &&
        form.tanggalTes !== '' &&
        form.jenisKelamin !== '' &&
        form.token.trim() !== ''
    );
});

const handleMulaiTes = () => {
    if (!isFormComplete.value || !props.submitUrl.trim()) {
        return;
    }

    form.post(props.submitUrl, {
        preserveScroll: true,
    });
};
</script>

<template>
    <div
        class="mx-4 mt-8 mb-10 w-auto max-w-3xl space-y-5 rounded-xl border bg-white p-4 shadow-sm sm:mx-6 sm:mt-12 sm:mb-14 sm:space-y-6 sm:p-6 md:mx-auto md:mt-14 md:mb-16 md:w-full md:p-8"
    >
        <h2 class="text-base font-semibold text-primary sm:text-lg">
            Informasi Peserta
        </h2>

        <!-- Tampilkan pesan error jika ada error validasi khusus -->
        <div v-if="form.errors.token || form.errors.tanggalTes || form.errors.nama || form.errors.tanggalLahir || form.errors.jenisKelamin" class="rounded-md bg-red-50 p-4">
            <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada input Anda:</h3>
            <ul class="mt-2 list-disc pl-5 text-sm text-red-700">
                <li v-for="(error, key) in form.errors" :key="key">{{ error }}</li>
            </ul>
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium"> Nama Lengkap </label>
            <input
                :value="form.nama"
                @input="handleNama"
                type="text"
                placeholder="Masukkan nama lengkap Anda"
                class="w-full rounded-lg border bg-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary focus:outline-none sm:py-3 sm:text-base"
                :class="{'border-red-500': form.errors.nama}"
            />
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium"> Tanggal Lahir </label>
            <input
                :value="form.tanggalLahir"
                type="date"
                :max="today"
                @input="handleTanggalLahir"
                @click="openDatePicker"
                @keydown="blockManualDateInput"
                @paste.prevent
                class="w-full cursor-pointer rounded-lg border bg-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary focus:outline-none sm:py-3 sm:text-base"
                :class="{'border-red-500': form.errors.tanggalLahir}"
            />
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium"> Tanggal Tes </label>
            <input
                :value="form.tanggalTes"
                type="date"
                :min="today"
                @input="handleTanggalTes"
                @click="openDatePicker"
                @keydown="blockManualDateInput"
                @paste.prevent
                class="w-full cursor-pointer rounded-lg border bg-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary focus:outline-none sm:py-3 sm:text-base"
                :class="{'border-red-500': form.errors.tanggalTes}"
            />
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium">Jenis Kelamin</label>

            <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 sm:gap-3">
                <label
                    class="flex cursor-pointer items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5"
                    :class="{'border-red-500': form.errors.jenisKelamin}"
                >
                    <input
                        type="radio"
                        name="jenisKelamin"
                        value="Pria"
                        :checked="form.jenisKelamin === 'Pria'"
                        @change="handleJenisKelamin('Pria')"
                        class="accent-primary"
                    />
                    Pria
                </label>

                <label
                    class="flex cursor-pointer items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5"
                    :class="{'border-red-500': form.errors.jenisKelamin}"
                >
                    <input
                        type="radio"
                        name="jenisKelamin"
                        value="Wanita"
                        :checked="form.jenisKelamin === 'Wanita'"
                        @change="handleJenisKelamin('Wanita')"
                        class="accent-primary"
                    />
                    Wanita
                </label>
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium"> Token </label>
            <input
                :value="form.token"
                type="text"
                @input="handleToken"
                placeholder="Masukkan token tes"
                class="w-full uppercase rounded-lg border bg-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary focus:outline-none sm:py-3 sm:text-base"
                :class="{'border-red-500': form.errors.token}"
            />
        </div>

        <button
            type="button"
            :disabled="!isFormComplete || form.processing"
            @click="handleMulaiTes"
            :class="[
                'mt-4 w-full rounded-lg px-4 py-2.5 text-sm text-white transition sm:text-base',
                (isFormComplete && !form.processing)
                    ? 'cursor-pointer bg-primary hover:bg-green-900'
                    : 'cursor-not-allowed bg-gray-400',
            ]"
        >
            {{ form.processing ? 'Memproses...' : 'Mulai Tes' }}
        </button>
    </div>
</template>
