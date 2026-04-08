<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import Navbar from '@/components/Navbar.vue';
import PageHeader from '@/components/PageHeader.vue';
import UserDashboard from '@/components/UserDashboard.vue';
import { home } from '@/routes';

defineProps<{
    user: any;
    riwayat: any[];
}>();
</script>

<template>
    <Navbar />
    <section class="px-6 py-18">
        <PageHeader title="Dashboard User" :back-url="home().url" />
        <UserDashboard :user="user" :riwayat="riwayat" />
    </section>
    <Footer />
</template>
