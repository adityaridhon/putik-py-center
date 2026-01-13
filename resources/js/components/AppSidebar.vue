<script setup lang="ts">
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard, konten } from '@/routes';
import { Link } from '@inertiajs/vue3';
import {
    Brain,
    Building2,
    Flame,
    GraduationCap,
    HandCoins,
    Handshake,
    LayoutGrid,
    Newspaper,
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
        title: 'Layanan',
        href: konten(),
        icon: Stethoscope,
    },
    {
        title: 'Mitra',
        href: konten(),
        icon: Handshake,
    },
    {
        title: 'Artikel',
        href: konten(),
        icon: Newspaper,
    },
];

const servicesNavItems = [
    {
        title: 'Pemesanan',
        href: konten(),
        icon: HandCoins,
    },
    {
        title: 'Minat Bakat',
        href: konten(),
        icon: Flame,
    },
    {
        title: 'Gaya Belajar',
        href: konten(),
        icon: GraduationCap,
    },
    {
        title: 'Intelegensi',
        href: konten(),
        icon: Brain,
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
        </SidebarContent>

        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
