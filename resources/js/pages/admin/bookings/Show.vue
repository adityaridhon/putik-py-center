<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';

const props = defineProps<{
    booking: {
        id: number;
        customer_name: string;
        customer_phone: string;
        topic?: string | null;
        service_category?: string | null;
        option_type?: string | null;
        company_name?: string | null;
        booking_date: string;
        booking_time: string;
        status: string;
        created_at: string;
        updated_at: string;
        service?: {
            name?: string | null;
        };
        user?: {
            name?: string | null;
            email?: string | null;
        };
    };
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/admin/dashboard',
    },
    {
        title: 'Booking',
        href: '/admin/notifications',
    },
    {
        title: `Booking #${props.booking?.id}`,
        href: `/admin/bookings/${props.booking?.id}`,
    },
];
</script>

<template>
    <Head title="Detail Booking" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold">Detail Booking</h1>
                    <p class="text-sm text-slate-600">Lihat detail booking dan status pemesanan.</p>
                </div>
                <div class="flex gap-2">
                    <Link
                        href="/admin/notifications"
                        class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-800 shadow-sm hover:bg-slate-50"
                    >
                        Kembali ke Notifikasi
                    </Link>
                    <Link
                        href="/admin/dashboard"
                        class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-800 shadow-sm hover:bg-slate-50"
                    >
                        Dashboard
                    </Link>
                </div>
            </div>

            <div class="grid gap-4 lg:grid-cols-2">
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold">Informasi Pemesan</h2>
                    <dl class="mt-4 space-y-3 text-sm text-slate-700">
                        <div>
                            <dt class="font-medium">Nama Pelanggan</dt>
                            <dd>{{ props.booking.customer_name }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium">Nomor HP</dt>
                            <dd>{{ props.booking.customer_phone }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium">Email</dt>
                            <dd>{{ props.booking.user?.email ?? 'Tidak tersedia' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium">Perusahaan</dt>
                            <dd>{{ props.booking.company_name || 'Tidak ada' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium">Topik</dt>
                            <dd>{{ props.booking.topic || 'Tidak ada' }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold">Detail Booking</h2>
                    <dl class="mt-4 space-y-3 text-sm text-slate-700">
                        <div>
                            <dt class="font-medium">Layanan</dt>
                            <dd>{{ props.booking.service?.name ?? props.booking.service_category ?? 'Tidak tersedia' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium">Jenis</dt>
                            <dd>{{ props.booking.option_type || 'Tidak tersedia' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium">Tanggal</dt>
                            <dd>{{ props.booking.booking_date }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium">Jam</dt>
                            <dd>{{ props.booking.booking_time }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium">Status</dt>
                            <dd>{{ props.booking.status }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium">Dibuat pada</dt>
                            <dd>{{ props.booking.created_at }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium">Terakhir diperbarui</dt>
                            <dd>{{ props.booking.updated_at }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
