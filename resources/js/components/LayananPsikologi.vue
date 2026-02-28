<script setup lang="ts">
const layanan = defineModel<string>('layanan');
const opsi = defineModel<string>('opsi');
const perusahaan = defineModel<string>('perusahaan');

const daftarLayanan = [
    'Tes Kepribadian',
    'Tes Inteligensi',
    'Tes Minat Bakat',
    'Tes Gaya Belajar',
];

function btn(active: boolean) {
    return `px-4 py-2 rounded border ${
        active ? 'bg-green-700 text-white' : ''
    }`;
}
</script>

<template>
    <div class="space-y-4 rounded border p-6">
        <div>
            <p class="font-semibold">Layanan Dibutuhkan</p>
            <div class="mt-2 space-y-2">
                <div
                    v-for="item in daftarLayanan"
                    :key="item"
                    @click="layanan = item"
                    :class="[
                        'cursor-pointer',
                        layanan === item && 'font-semibold text-green-700',
                    ]"
                >
                    {{ item }}
                </div>
            </div>
        </div>

        <div>
            <p class="font-semibold">Pilih Opsi</p>
            <div class="mt-2 flex gap-4">
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

        <input
            v-if="opsi === 'Klasikal'"
            v-model="perusahaan"
            placeholder="Nama Perusahaan/Instansi"
            class="w-full rounded border p-2"
        />
    </div>
</template>
