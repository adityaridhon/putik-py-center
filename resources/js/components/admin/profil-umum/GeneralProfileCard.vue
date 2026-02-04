<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';
import Button from '@/components/ui/button/Button.vue';
import {
    Card,
    CardAction,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { router } from '@inertiajs/vue3';
import { Instagram, Mail, Pencil, Phone } from 'lucide-vue-next';

// Props dengan default value
const props = defineProps<{
    profile?: {
        company_name?: string;
        headline?: string;
        about?: string;
        phone?: string;
        email?: string;
        instagram?: string;
        logo_url?: string;
        landing_image_url?: string;
    };
}>();

// Computed untuk kontak (agar aman dari null)
const kontak = [
    {
        icon: Phone,
        value: props.profile?.phone ?? '-',
    },
    {
        icon: Mail,
        value: props.profile?.email ?? '-',
    },
    {
        icon: Instagram,
        value: props.profile?.instagram ?? '-',
    },
];

const editProfile = () => {
    router.visit('/admin/konten/edit');
};
</script>

<template>
    <Card class="@container/card">
        <CardHeader>
            <div
                class="flex flex-row items-start gap-6 @lg/card:flex-row @lg/card:items-center"
            >
                <div class="max-w-xs">
                    <CardTitle class="font-semibold">
                        Gambar Landing Page
                    </CardTitle>
                    <img
                        :src="
                            profile?.landing_image_url
                                ? `/storage/${profile.landing_image_url}`
                                : '/images/logo_putik.webp'
                        "
                        alt="Landing Image"
                        class="mt-2 h-52 rounded border"
                    />
                </div>
                <div class="flex max-w-2xl flex-col gap-3">
                    <div class="space-y-2">
                        <CardTitle class="font-semibold"
                            >Nama Perusahaan</CardTitle
                        >
                        <CardDescription>{{
                            profile?.company_name ?? 'Belum ada nama perusahaan'
                        }}</CardDescription>
                    </div>
                    <div class="space-y-2">
                        <CardTitle class="font-semibold">Headline</CardTitle>
                        <CardDescription>{{
                            profile?.headline ?? 'Belum ada headline'
                        }}</CardDescription>
                    </div>
                    <div class="space-y-2">
                        <CardTitle class="font-semibold">
                            Tentang {{ profile?.company_name ?? 'Putik' }}
                        </CardTitle>
                        <CardDescription>{{
                            profile?.about ?? 'Belum ada deskripsi'
                        }}</CardDescription>
                    </div>
                    <div class="space-y-2">
                        <CardTitle class="font-semibold">
                            Kontak {{ profile?.company_name ?? 'Putik' }}
                        </CardTitle>
                        <CardDescription class="flex flex-wrap gap-2">
                            <Badge
                                v-for="(item, index) in kontak"
                                :key="index"
                                class="bg-blue-500 text-white"
                            >
                                <component
                                    :is="item.icon"
                                    class="mr-2 h-4 w-4"
                                />
                                {{ item.value }}
                            </Badge>
                        </CardDescription>
                    </div>
                </div>
            </div>
        </CardHeader>
        <CardAction class="mx-auto w-full px-10">
            <Button @click="editProfile" class="w-full">
                <Pencil class="mr-2 h-4 w-4" /> Edit
            </Button>
        </CardAction>
    </Card>
</template>
