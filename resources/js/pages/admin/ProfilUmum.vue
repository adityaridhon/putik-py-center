<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { dashboard } from '@/routes';
import { watch } from 'vue';

// Props dari Controller - SEMUA OPTIONAL
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
    { title: 'Dashboard', href: dashboard().url },
    { title: 'Profil Umum', href: '#' },
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

// Watch props dan update form ketika props berubah
watch(() => props.profile, (newProfile) => {
    if (newProfile) {
        form.company_name = newProfile.company_name ?? '';
        form.headline = newProfile.headline ?? '';
        form.about = newProfile.about ?? '';
        form.phone = newProfile.phone ?? '';
        form.email = newProfile.email ?? '';
        form.instagram = newProfile.instagram ?? '';
        form.address = newProfile.address ?? '';
    }
}, { deep: true });

// Preview gambar
const getLogoPreview = () => {
    if (form.logo) return URL.createObjectURL(form.logo);
    return props.profile?.logo_url ? `/storage/${props.profile.logo_url}` : null;
};

const getLandingPreview = () => {
    if (form.landing_image) return URL.createObjectURL(form.landing_image);
    return props.profile?.landing_image_url ? `/storage/${props.profile.landing_image_url}` : null;
};

// Submit
const submit = () => {
    form.post('/profil-umum', {
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
    <Head title="Profil Umum" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6">
            <Card>
                <CardHeader>
                    <CardTitle class="text-2xl font-bold">Profil Perusahaan</CardTitle>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Grid 2 Kolom -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Kolom Kiri -->
                            <div class="space-y-4">
                                <!-- Nama Perusahaan -->
                                <div>
                                    <Label>Nama Perusahaan</Label>
                                    <Input v-model="form.company_name" placeholder="Putik Psychology Center" />
                                    <span v-if="form.errors.company_name" class="text-red-500 text-sm">{{ form.errors.company_name }}</span>
                                </div>

                                <!-- Headline -->
                                <div>
                                    <Label>Headline</Label>
                                    <textarea v-model="form.headline" rows="3" placeholder="Mitra terpercaya..." class="flex min-h-[60px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50" />
                                    <span v-if="form.errors.headline" class="text-red-500 text-sm">{{ form.errors.headline }}</span>
                                </div>

                                <!-- Tentang -->
                                <div>
                                    <Label>Tentang Putik</Label>
                                    <textarea v-model="form.about" rows="5" class="flex min-h-[60px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50" />
                                    <span v-if="form.errors.about" class="text-red-500 text-sm">{{ form.errors.about }}</span>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="space-y-4">
                                <!-- Kontak -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <Label>Telepon</Label>
                                        <Input v-model="form.phone" />
                                    </div>
                                    <div>
                                        <Label>Email</Label>
                                        <Input v-model="form.email" type="email" />
                                    </div>
                                </div>

                                <div>
                                    <Label>Instagram</Label>
                                    <Input v-model="form.instagram" placeholder="@putikpsycenter" />
                                </div>

                                <div>
                                    <Label>Alamat</Label>
                                    <textarea v-model="form.address" rows="2" class="flex min-h-[60px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50" />
                                </div>

                                <!-- Upload Logo -->
                                <div class="border rounded-lg p-4 bg-gray-50">
                                    <Label class="mb-2">Logo Perusahaan</Label>
                                    <div v-if="getLogoPreview()" class="mb-3">
                                        <img :src="getLogoPreview() ?? undefined" alt="Logo" class="h-20 w-auto object-contain border rounded" />
                                    </div>
                                    <Input 
                                        type="file" 
                                        accept="image/*"
                                        @change="form.logo = ($event.target as HTMLInputElement).files?.[0] || null"
                                    />
                                    <span v-if="form.errors.logo" class="text-red-500 text-sm">{{ form.errors.logo }}</span>
                                </div>

                                <!-- Upload Landing Image -->
                                <div class="border rounded-lg p-4 bg-gray-50">
                                    <Label class="mb-2">Gambar Landing Page</Label>
                                    <div v-if="getLandingPreview()" class="mb-3">
                                        <img :src="getLandingPreview() ?? undefined" alt="Landing" class="h-32 w-auto object-cover border rounded" />
                                    </div>
                                    <Input 
                                        type="file" 
                                        accept="image/*"
                                        @change="form.landing_image = ($event.target as HTMLInputElement).files?.[0] || null"
                                    />
                                    <span v-if="form.errors.landing_image" class="text-red-500 text-sm">{{ form.errors.landing_image }}</span>
                                </div>
                            </div>

                        </div>

                        <!-- Tombol Submit -->
                        <div class="flex justify-end pt-4">
                            <Button type="submit" :disabled="form.processing">
                                {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
