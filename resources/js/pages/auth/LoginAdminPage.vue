<script setup lang="ts">
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head } from '@inertiajs/vue3';
import LoginAdmin from './LoginAdmin.vue';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();
</script>

<template>
    <AuthBase
        title="Login Admin"
        description="Masuk ke panel admin menggunakan email dan password."
    >
        <Head title="Login Admin" />

        <div
            v-if="status"
            class="mb-4 rounded-md border border-green-200 bg-green-50 px-3 py-2 text-sm font-medium text-green-700"
        >
            {{ status }}
        </div>

        <section class="space-y-4">
            <LoginAdmin :can-reset-password="canResetPassword" />
        </section>
    </AuthBase>
</template>
