<script setup lang="ts">
import { Baby, ClipboardList, Heart } from 'lucide-vue-next';

const kategori = defineModel<string>();

const kategoriPilihan = [
    {
        id: 'children_center',
        title: 'Children Center',
        description:
            'Layanan psikologi khusus untuk anak-anak dan remaja, termasuk asesmen perkembangan dan terapi bermain.',
        icon: Baby,
    },
    {
        id: 'konseling_terapi',
        title: 'Konseling dan Terapi',
        description:
            'Sesi konseling individual atau keluarga dengan psikolog berpengalaman untuk berbagai permasalahan psikologis.',
        icon: Heart,
    },
    {
        id: 'pemeriksaan_psikologi',
        title: 'Pemeriksaan Psikologi',
        description:
            'Tes dan asesmen psikologi komprehensif untuk keperluan klinis, pendidikan, atau pekerjaan.',
        icon: ClipboardList,
    },
];
</script>

<template>
    <div class="space-y-6 rounded-xl border bg-white p-6 shadow-sm">
        <!-- Header -->
        <div>
            <h2 class="text-xl font-semibold text-primary">
                Pilih Kategori Layanan
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Pilih salah satu layanan yang sesuai dengan kebutuhan Anda
            </p>
        </div>

        <!-- List -->
        <div class="space-y-4">
            <button
                v-for="option in kategoriPilihan"
                :key="option.id"
                type="button"
                @click="kategori = option.id"
                :class="[
                    'flex w-full items-start gap-4 rounded-xl border p-5 text-left transition',
                    kategori === option.id
                        ? 'border-primary bg-green-50'
                        : 'border-gray-200 hover:border-primary',
                ]"
            >
                <!-- Icon -->
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-100"
                >
                    <component
                        :is="option.icon"
                        class="h-6 w-6 text-primary"
                    />
                </div>

                <!-- Text -->
                <div>
                    <p class="text-base font-semibold text-gray-900">
                        {{ option.title }}
                    </p>
                    <p class="mt-1 text-sm leading-relaxed text-gray-600">
                        {{ option.description }}
                    </p>
                </div>
            </button>
        </div>
    </div>
</template>
