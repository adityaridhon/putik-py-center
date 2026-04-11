<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { type BreadcrumbItem } from '@/types';

const props = defineProps<{
    notifications?: Array<{
        id: string;
        type: string;
        data: {
            booking_id?: number;
            target_url?: string;
            customer_name: string;
            booking_date: string;
            booking_time: string;
        };
        read_at?: string | null;
        created_at: string;
    }>;
}>();

const markAsRead = async (id: string) => {
    try {
        await axios.post(`/admin/notifications/${id}/read`);
        window.location.reload();
    } catch (error) {
        console.error('Gagal menandai notifikasi sebagai dibaca:', error);
    }
};

const openNotification = async (notification: any) => {
    try {
        await axios.post(`/admin/notifications/${notification.id}/read`);
    } catch (error) {
        console.error('Gagal menandai notifikasi sebagai dibaca:', error);
    }

    if (notification.data.target_url) {
        window.location.href = notification.data.target_url;
    } else {
        window.location.reload();
    }
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Notifikasi',
        href: '/admin/notifications',
    },
];
</script>

<template>
    <Head title="Notifikasi" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold">Notifikasi Admin</h1>
                    <p class="text-sm text-slate-600">Semua notifikasi booking dan status terbaru.</p>
                </div>
                <Link
                    href="/admin/dashboard"
                    class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-800 shadow-sm hover:bg-slate-50"
                >
                    Kembali ke Dashboard
                </Link>
            </div>

            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Pesan</th>
                            <th class="px-4 py-3">Waktu</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        <tr v-for="notification in props.notifications" :key="notification.id">
                            <td class="px-4 py-3">
                                <div class="font-medium text-slate-900">
                                    Booking dari {{ notification.data.customer_name }} pada {{ notification.data.booking_date }} jam {{ notification.data.booking_time }}
                                </div>
                                <div class="text-xs text-slate-500">
                                    {{ notification.type }}
                                </div>
                            </td>
                            <td class="px-4 py-3 text-slate-700">
                                {{ notification.created_at }}
                            </td>
                            <td class="px-4 py-3">
                                <span
                                    :class="notification.read_at ? 'bg-slate-100 text-slate-700' : 'bg-emerald-100 text-emerald-700'"
                                    class="inline-flex rounded-full px-2 py-1 text-xs font-semibold"
                                >
                                    {{ notification.read_at ? 'Dibaca' : 'Belum dibaca' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-2">
                                    <button
                                        type="button"
                                        @click="openNotification(notification)"
                                        class="rounded-full bg-slate-900 px-3 py-1 text-xs font-semibold text-white hover:bg-slate-700"
                                    >
                                        Buka
                                    </button>
                                    <button
                                        type="button"
                                        @click="markAsRead(notification.id)"
                                        class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 hover:bg-emerald-200"
                                    >
                                        Tandai dibaca
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="!props.notifications || props.notifications.length === 0">
                            <td colspan="4" class="px-4 py-8 text-center text-sm text-slate-500">
                                Belum ada notifikasi.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
