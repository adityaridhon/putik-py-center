<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import Navbar from '@/components/Navbar.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { home } from '@/routes';
import { useForm } from '@inertiajs/vue3';
import { ArrowLeft } from 'lucide-vue-next';

defineProps<{
    user: any;
}>();

const form = useForm({
    name: '',
    email: '',
    phone_number: '',
});

const submit = () => {
    form.put('/user/profile', {
        onSuccess: () => {
            form.reset();
        },
    });
};

const deleteProfile = () => {
    if (confirm('Apakah Anda yakin ingin menghapus profil? Tindakan ini tidak dapat dibatalkan.')) {
        form.delete('/user/profile');
    }
};
</script>

<template>
    <Navbar />

    <section class="px-6 py-20">
        <div class="mb-6 flex items-center gap-3">
            <a href="/user/dashboard" class="rounded-lg p-2 hover:bg-gray-100">
                <ArrowLeft class="size-5" />
            </a>
            <h1 class="text-2xl font-bold">Edit Profil</h1>
        </div>

        <div class="mx-auto max-w-md rounded-2xl border border-gray-100 bg-white p-6 shadow-md">
            <form @submit.prevent="submit" class="flex flex-col gap-4">
                <div class="grid gap-2">
                    <Label for="name">Nama Lengkap</Label>
                    <Input
                        id="name"
                        v-model="form.name"
                        type="text"
                        required
                        :placeholder="user.name"
                    />
                    <span v-if="form.errors.name" class="text-sm text-red-600">
                        {{ form.errors.name }}
                    </span>
                </div>

                <div class="grid gap-2">
                    <Label for="email">Email</Label>
                    <Input
                        id="email"
                        v-model="form.email"
                        type="email"
                        required
                        :placeholder="user.email"
                    />
                    <span v-if="form.errors.email" class="text-sm text-red-600">
                        {{ form.errors.email }}
                    </span>
                </div>

                <div class="grid gap-2">
                    <Label for="phone_number">No. Telepon</Label>
                    <Input
                        id="phone_number"
                        v-model="form.phone_number"
                        type="text"
                        :placeholder="user.phone_number || '+62...'"
                    />
                    <span v-if="form.errors.phone_number" class="text-sm text-red-600">
                        {{ form.errors.phone_number }}
                    </span>
                </div>

                <div class="flex gap-2 pt-4">
                    <Button
                        type="submit"
                        class="flex-1"
                        :disabled="form.processing"
                    >
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                    </Button>
                    <Button
                        type="button"
                        variant="destructive"
                        @click="deleteProfile"
                        :disabled="form.processing"
                    >
                        Hapus Profil
                    </Button>
                </div>
            </form>
        </div>
    </section>

    <Footer />
</template>
