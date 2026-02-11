<script setup lang="ts">
import NavMain from '@/components/NavMain.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import {
    article,
    bankSoal,
    dashboard,
    gayaBelajar,
    intelegensi,
    konten,
    minatBakat,
    service,
} from '@/routes';
import { Link } from '@inertiajs/vue3';
import {
    Archive,
    BookOpenCheck,
    Brain,
    Building2,
    Flame,
    GraduationCap,
    LayoutGrid,
    Stethoscope,
} from 'lucide-vue-next';

import AppLogo from './AppLogo.vue';

const mainNavItems = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
];

const contentNavItems = [
    {
        title: 'Profil umum',
        href: konten(),
        icon: Building2,
    },
    {
        title: 'Artikel',
        href: article(),
        icon: BookOpenCheck,
    },
];

const servicesNavItems = [
    {
        title: 'Data Layanan',
        href: service(),
        icon: Stethoscope,
    },
];

const testNavItems = [
    {
        title: 'Minat Bakat',
        href: minatBakat(),
        icon: Flame,
    },
    {
        title: 'Intelegensi',
        href: intelegensi(),
        icon: Brain,
    },
    {
        title: 'Gaya Belajar',
        href: gayaBelajar(),
        icon: GraduationCap,
    },
    {
        title: 'Bank Soal',
        href: bankSoal(),
        icon: Archive,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton
                        size="lg"
                        as-child
                        class="justify-center hover:bg-transparent! hover:text-inherit!"
                    >
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain label="Menu Utama" :items="mainNavItems" />
            <NavMain label="Manajemen Konten" :items="contentNavItems" />
            <NavMain label="Manajemen Layanan" :items="servicesNavItems" />
            <NavMain label="Manajemen Tes" :items="testNavItems" />
        </SidebarContent>
    </Sidebar>
    <slot />
</template>
