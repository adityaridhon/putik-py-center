<script setup lang="ts">
import DashboardCard from '@/components/admin/dashboard/DashboardCard.vue';
import TableDashboard from '@/components/admin/dashboard/TableDashboard.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps<{
    dashboardStats?: {
        janjiMingguIni: number;
        laporanPsikologi: number;
        artikelTerbit: number;
    };
    dashboardTrends?: {
        janjiMingguIni: number;
        laporanPsikologi: number;
        artikelTerbit: number;
    };
    activities?: Array<{
        id: number | string;
        nama_pengguna: string;
        aktivitas: string;
        tanggal: string;
        status: string;
    }>;
    notifications?: Array<{
        id: string;
        data: {
            booking_id: number;
            customer_name: string;
            booking_date: string;
            booking_time: string;
        };
        created_at: string;
    }>;
}>();

const markAsRead = async (id: string) => {
    try {
        await axios.post(`/admin/notifications/${id}/read`);
        // Reload page or update props
        window.location.reload();
    } catch (error) {
        console.error('Error marking notification as read:', error);
    }
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold">Dashboard Admin</h1>
                    <p class="text-sm text-slate-600">Ringkasan notifikasi terbaru dan aktivitas sistem.</p>
                </div>
                <Link
                    href="/admin/notifications"
                    class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-800 shadow-sm transition hover:bg-slate-50"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 003 14h14a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                        <path d="M14.707 14.293a1 1 0 01-1.414 1.414A3 3 0 017.293 14.293a1 1 0 10-1.414 1.414A5 5 0 0010 18a5 5 0 005-5 1 1 0 00-.293-.707z" />
                    </svg>
                    Notifikasi
                    <span v-if="props.notifications && props.notifications.length" class="inline-flex h-6 min-w-[1.5rem] items-center justify-center rounded-full bg-rose-600 px-2 text-xs font-semibold text-white">
                        {{ props.notifications.length }}
                    </span>
                </Link>
            </div>

            <!-- Notifikasi -->
            <div v-if="props.notifications && props.notifications.length > 0" class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">
                            <strong>Notifikasi Booking Baru:</strong>
                        </p>
                        <ul class="mt-2 text-sm">
                            <li v-for="notification in props.notifications" :key="notification.id" class="flex justify-between items-center">
                                <span>Booking baru dari {{ notification.data.customer_name }} pada {{ notification.data.booking_date }} jam {{ notification.data.booking_time }}</span>
                                <button @click="markAsRead(notification.id)" class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs">
                                    Tandai Dibaca
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <DashboardCard
                    :stats="props.dashboardStats"
                    :trends="props.dashboardTrends"
                />
            </div>
            <div>
                <h1 class="my-4 text-2xl font-bold">Aktivitas terbaru</h1>
                <TableDashboard :activities="props.activities" />
            </div>
        </div>
    </AppLayout>
</template>
