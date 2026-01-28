<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { konten } from '@/routes';
import { update } from '@/routes/konten';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

// Props dari Controller
const props = defineProps<{
    profile?: {
        id?: number;
        company_name?: string;
        headline?: string;
        about?: string;
        phone?: string;
        email?: string;
        instagram?: string;
        address?: string;
        logo?: string;
        landing_image?: string;
        logo_url?: string;
        landing_image_url?: string;
    };
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Manajemen Konten', href: konten().url },
    { title: 'Edit Konten', href: '#' },
];

// Setup Form
const form = useForm({
    company_name: props.profile?.company_name ?? '',
    headline: props.profile?.headline ?? '',
    about: props.profile?.about ?? '',
    phone: props.profile?.phone ?? '',
    email: props.profile?.email ?? '',
    instagram: props.profile?.instagram ?? '',
    address: props.profile?.address ?? '',
    logo: null as File | null,
    landing_image: null as File | null,
});

watch(
    () => props.profile,
    (newProfile) => {
        if (newProfile) {
            form.company_name = newProfile.company_name ?? '';
            form.headline = newProfile.headline ?? '';
            form.about = newProfile.about ?? '';
            form.phone = newProfile.phone ?? '';
            form.email = newProfile.email ?? '';
            form.instagram = newProfile.instagram ?? '';
            form.address = newProfile.address ?? '';
        }
    },
    { deep: true },
);

// Preview gambar
const getLogoPreview = () => {
    if (form.logo) return URL.createObjectURL(form.logo);
    return props.profile?.logo_url
        ? `/storage/${props.profile.logo_url}`
        : null;
};

const getLandingPreview = () => {
    if (form.landing_image) return URL.createObjectURL(form.landing_image);
    return props.profile?.landing_image_url
        ? `/storage/${props.profile.landing_image_url}`
        : null;
};

// Submit
const submit = () => {
    form.post(update.url(), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            form.logo = null;
            form.landing_image = null;
        },
    });
};
</script>

<template>
    <Head title="Edit Konten" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6">
            <h1 class="text-2xl font-bold">Profil Perusahaan</h1>
            <div>
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Grid 2 Kolom -->

                    <div class="flex w-full flex-col justify-center">
                        <!-- Logo Preview & Upload -->
                        <div class="mt-4 max-w-xs">
                            <h1 class="mb-2 font-semibold">Logo Perusahaan</h1>
                            <div
                                v-if="getLogoPreview()"
                                class="mb-3 rounded border bg-gray-50 p-3"
                            >
                                <img
                                    :src="getLogoPreview() ?? undefined"
                                    alt="Logo Preview"
                                    class="h-24 w-auto rounded object-contain"
                                />
                            </div>
                            <Input
                                type="file"
                                accept="image/*"
                                @change="
                                    form.logo =
                                        ($event.target as HTMLInputElement)
                                            .files?.[0] || null
                                "
                            />
                            <span
                                v-if="form.errors.logo"
                                class="text-sm text-red-500"
                                >{{ form.errors.logo }}</span
                            >
                        </div>

                        <!-- Landing Image Preview & Upload -->
                        <div class="mt-6 max-w-md">
                            <h1 class="mb-2 font-semibold">
                                Gambar Landing Page
                            </h1>
                            <div
                                v-if="getLandingPreview()"
                                class="mb-3 rounded border bg-gray-50 p-3"
                            >
                                <img
                                    :src="getLandingPreview() ?? undefined"
                                    alt="Landing Image Preview"
                                    class="h-48 w-full rounded object-cover"
                                />
                            </div>
                            <Input
                                type="file"
                                accept="image/*"
                                @change="
                                    form.landing_image =
                                        ($event.target as HTMLInputElement)
                                            .files?.[0] || null
                                "
                            />
                            <span
                                v-if="form.errors.landing_image"
                                class="text-sm text-red-500"
                                >{{ form.errors.landing_image }}</span
                            >
                        </div>

                        <div class="grid w-full grid-cols-2 gap-8 pt-6">
                            <!-- kiri -->
                            <div class="kiri space-y-3">
                                <div class="space-y-1.5">
                                    <Label>Nama Perusahaan</Label>
                                    <Input
                                        v-model="form.company_name"
                                        placeholder="Putik Psychology Center"
                                    />
                                    <span
                                        v-if="form.errors.company_name"
                                        class="text-sm text-red-500"
                                        >{{ form.errors.company_name }}</span
                                    >
                                </div>
                                <div class="space-y-1.5">
                                    <Label>Headline</Label>
                                    <Textarea
                                        v-model="form.headline"
                                        class="resize-none"
                                    />
                                    <span
                                        v-if="form.errors.headline"
                                        class="text-sm text-red-500"
                                        >{{ form.errors.headline }}</span
                                    >
                                </div>
                                <div class="space-y-1.5">
                                    <Label>Tentang Putik</Label>
                                    <Textarea
                                        v-model="form.about"
                                        class="resize-none"
                                    />
                                    <span
                                        v-if="form.errors.about"
                                        class="text-sm text-red-500"
                                        >{{ form.errors.about }}</span
                                    >
                                </div>
                            </div>

                            <!-- kanan -->
                            <div class="kanan space-y-3">
                                <div class="space-y-1.5">
                                    <Label>Telepon</Label>
                                    <Input v-model="form.phone" />
                                </div>
                                <div class="space-y-1.5">
                                    <Label>Email</Label>
                                    <Input v-model="form.email" type="email" />
                                </div>

                                <div class="space-y-1.5">
                                    <Label>Instagram</Label>
                                    <Input
                                        v-model="form.instagram"
                                        placeholder="@putikpsycenter"
                                    />
                                </div>

                                <div class="space-y-1.5">
                                    <Label>Alamat</Label>
                                    <Textarea
                                        v-model="form.address"
                                        class="resize-none"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="flex justify-end pt-4">
                        <Button type="submit" :disabled="form.processing">
                            {{
                                form.processing
                                    ? 'Menyimpan...'
                                    : 'Simpan Perubahan'
                            }}
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
