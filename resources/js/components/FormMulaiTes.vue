<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { computed } from 'vue';

interface FormData {
    nama: string;
    tanggalLahir: string;
    tanggalTes: string;
    jenisKelamin: string;
    token: string;
}

const props = withDefaults(
    defineProps<{
        redirectTo?: string;
    }>(),
    {
        redirectTo: '',
    },
);

const model = defineModel<FormData>({
    default: {
        nama: '',
        tanggalLahir: '',
        tanggalTes: '',
        jenisKelamin: '',
        token: '',
    },
});

const updateField = <K extends keyof FormData>(key: K, value: FormData[K]) => {
    model.value = {
        ...model.value,
        [key]: value,
    };
};

const handleNama = (event: Event) => {
    const target = event.target as HTMLInputElement;
    target.value = target.value.replace(/[^a-zA-Z\s]/g, '');
    updateField('nama', target.value);
};

const handleTanggalLahir = (event: Event) => {
    const target = event.target as HTMLInputElement;
    updateField('tanggalLahir', target.value);
};

const handleTanggalTes = (event: Event) => {
    const target = event.target as HTMLInputElement;
    updateField('tanggalTes', target.value);
};

const handleJenisKelamin = (value: string) => {
    updateField('jenisKelamin', value);
};

const handleToken = (event: Event) => {
    const target = event.target as HTMLInputElement;
    updateField('token', target.value);
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
        model.value.nama.trim() !== '' &&
        model.value.tanggalLahir !== '' &&
        model.value.tanggalTes !== '' &&
        model.value.jenisKelamin !== '' &&
        model.value.token.trim() !== ''
    );
});

const handleMulaiTes = () => {
    if (!isFormComplete.value || !props.redirectTo.trim()) {
        return;
    }

    router.visit(props.redirectTo);
};
</script>

<template>
    <div
        class="mx-auto mt-20 mb-20 max-w-3xl space-y-6 rounded-xl border bg-white p-8 shadow-sm"
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
                :value="model.tanggalLahir"
                type="date"
                :max="today"
                @input="handleTanggalLahir"
                @click="openDatePicker"
                @keydown="blockManualDateInput"
                @paste.prevent
                class="w-full cursor-pointer rounded-lg border bg-slate-100 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
            />
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium"> Tanggal Tes </label>
            <input
                :value="model.tanggalTes"
                type="date"
                :min="today"
                @input="handleTanggalTes"
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
                        :checked="model.jenisKelamin === 'Pria'"
                        @change="handleJenisKelamin('Pria')"
                        class="accent-primary"
                    />
                    Pria
                </label>

                <label class="flex cursor-pointer items-center gap-2">
                    <input
                        type="radio"
                        name="jenisKelamin"
                        value="Wanita"
                        :checked="model.jenisKelamin === 'Wanita'"
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
                :value="model.token"
                type="text"
                @input="handleToken"
                placeholder="Masukkan token tes"
                class="w-full rounded-lg border bg-slate-100 px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none"
            />
        </div>

        <button
            type="button"
            :disabled="!isFormComplete"
            @click="handleMulaiTes"
            :class="[
                'mt-4 w-full rounded-lg py-2 text-white transition',
                isFormComplete
                    ? 'cursor-pointer bg-primary hover:bg-green-900'
                    : 'cursor-not-allowed bg-gray-400',
            ]"
        >
            Mulai Tes
        </button>
    </div>
</template>
