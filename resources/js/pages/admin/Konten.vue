<script setup lang="ts">
import ClientLists from '@/components/admin/profil-umum/ClientLists.vue';
import GeneralProfileCard from '@/components/admin/profil-umum/GeneralProfileCard.vue';
import ProfileCard from '@/components/admin/profil-umum/ProfileCardHeader.vue';
import ServiceLists from '@/components/admin/profil-umum/ServiceLists.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { konten } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Manajemen Konten',
        href: konten().url,
    },
];
</script>

<template>
    <Head title="Konten" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                <ProfileCard />
            </div>
            <div>
                <h1 class="my-4 text-2xl font-bold">Profil umum</h1>
                <GeneralProfileCard />
                <ServiceLists class="my-10" />
                <ClientLists class="my-10" />
            </div>
        </div>
    </AppLayout>
</template>
