<script setup lang="ts">
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head } from '@inertiajs/vue3';
import LoginUser from './LoginUser.vue';

defineProps<{
    status?: string;
    canRegister: boolean;
}>();
</script>

<template>
    <AuthBase title="Login" description="Masuk menggunakan akun Google.">
        <Head title="Masuk" />

        <div
            v-if="status"
            class="mb-4 rounded-md border border-green-200 bg-green-50 px-3 py-2 text-sm font-medium text-green-700"
        >
            {{ status }}
        </div>

        <section>
            <LoginUser :can-register="canRegister" />

            <div
                class="hidden rounded-md border border-gray-200 bg-white px-4 py-3 text-xs text-gray-600 md:block"
            >
                Admin? Login melalui:
                <a
                    href="/admin/login"
                    class="ml-1 font-semibold text-sky-800 underline underline-offset-2"
                >
                    Login Admin
                </a>
            </div>
        </section>
    </AuthBase>
</template>
