<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import {
    FileDown,
    Mail,
    Pencil,
    Phone,
    Trash,
    User,
    UserRound,
} from 'lucide-vue-next';
import { useForm } from '@inertiajs/vue3';

defineProps<{
    user: any;
    riwayat: any[];
}>();

const form = useForm({});

const deleteProfile = () => {
    if (confirm('Apakah Anda yakin ingin menghapus profil? Tindakan ini tidak dapat dibatalkan.')) {
        form.delete('/user/profile');
    }
};
</script>

<template>
    <section
        class="mx-2 mt-10 grid grid-cols-1 gap-5 md:mx-10 md:grid-cols-3 md:gap-0"
    >
        <!-- User profile -->
        <section
            class="mx-auto w-full max-w-3xl rounded-2xl border border-gray-100 bg-white p-6 shadow-md md:col-span-1 md:p-8"
        >
            <div class="flex flex-col items-center">
                <h1 class="text-center text-2xl font-bold text-gray-900">
                    Profil Pengguna
                </h1>
                <div
                    class="mt-4 flex h-20 w-20 items-center justify-center rounded-full bg-primary/10 text-primary"
                >
                    <User class="size-10" />
                </div>

                <div
                    class="mt-8 w-full max-w-2xl divide-y divide-gray-100 rounded-xl border border-gray-100 bg-gray-50/40"
                >
                    <!-- Nama -->
                    <div
                        class="grid grid-cols-[56px_1fr] items-center gap-4 p-4 md:p-5"
                    >
                        <div
                            class="flex h-14 w-14 items-center justify-center rounded-full bg-primary/10"
                        >
                            <UserRound class="size-7 text-primary" />
                        </div>
                        <div>
                            <h2 class="text-sm font-medium text-gray-500">
                                Nama Lengkap
                            </h2>
                            <p
                                class="mt-1 text-base font-semibold text-gray-900"
                            >
                                {{ user.name || 'Pengguna' }}
                            </p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div
                        class="grid grid-cols-[56px_1fr] items-center gap-4 p-4 md:p-5"
                    >
                        <div
                            class="flex h-14 w-14 items-center justify-center rounded-full bg-primary/10"
                        >
                            <Mail class="size-7 text-primary" />
                        </div>
                        <div>
                            <h2 class="text-sm font-medium text-gray-500">
                                Alamat Email
                            </h2>
                            <p
                                class="mt-1 text-base font-semibold text-gray-900"
                            >
                                {{ user.email }}
                            </p>
                        </div>
                    </div>

                    <!-- Tlp -->
                    <div
                        class="grid grid-cols-[56px_1fr] items-center gap-4 p-4 md:p-5"
                    >
                        <div
                            class="flex h-14 w-14 items-center justify-center rounded-full bg-primary/10"
                        >
                            <Phone class="size-7 text-primary" />
                        </div>
                        <div>
                            <h2 class="text-sm font-medium text-gray-500">
                                No. Telepon
                            </h2>
                            <p
                                class="mt-1 text-base font-semibold text-gray-900"
                            >
                                {{ user.phone_number || '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex gap-2">
                    <a href="/user/profile/edit">
                        <Button>
                            <Pencil />
                            Edit Profil
                        </Button>
                    </a>
                    <Button 
                        variant="destructive"
                        @click="deleteProfile"
                        :disabled="form.processing"
                    >
                        <Trash />
                        Hapus Profil
                    </Button>
                </div>
            </div>
        </section>

        <!-- User History -->
        <section
            class="mx-auto mb-10 w-full max-w-3xl rounded-2xl border border-gray-100 bg-white p-6 shadow-md md:col-span-2 md:p-8"
        >
            <h1 class="mb-6 text-center text-2xl font-bold text-gray-900">
                Riwayat &amp; Laporan Tes
            </h1>

            <div class="flex flex-col divide-y divide-gray-100">
                <div v-if="!riwayat || riwayat.length === 0" class="py-10 text-center text-gray-500">
                    Belum ada riwayat tes.
                </div>

                <div v-for="item in riwayat" :key="item.id" class="flex items-center justify-between gap-4 py-4">      
                    <div class="min-w-0">
                        <p
                            class="truncate text-base font-semibold text-gray-900"
                        >
                            {{ item.test_type }}
                        </p>
                        <p class="mt-0.5 text-sm text-gray-400">
                            {{ item.date }}
                        </p>
                    </div>
                    <div class="flex shrink-0 flex-col items-end gap-2">        
                        <span
                            :class="[
                                'rounded-full px-3 py-0.5 text-xs font-semibold',
                                item.raw_status === 'completed' || item.raw_status === 'reported' 
                                    ? 'bg-green-100 text-green-700' 
                                    : 'bg-yellow-100 text-yellow-700'
                            ]"
                        >{{ item.status }}</span>
                        <!-- Kalau report sudah ada, mungkin download link bisa diaktifkan -->
                        <a v-if="item.has_pdf" :href="`/user/laporan-psikologi/${item.id}/download`" target="_blank" class="contents">
                            <Button size="sm" class="gap-1.5 text-xs bg-primary hover:bg-green-900 border-none">
                                <FileDown class="size-4" />
                                Unduh Hasil (PDF)
                            </Button>
                        </a>
                        <Button v-else-if="item.raw_status !== 'completed' && item.raw_status !== 'reported'" size="sm" variant="outline" class="text-xs" disabled>    
                            Proses
                        </Button>
                    </div>
                </div>
            </div>
        </section>
    </section>
</template>
