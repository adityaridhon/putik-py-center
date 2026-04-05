<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { store } from '@/routes/login';
import { request } from '@/routes/password';
import { useForm } from '@inertiajs/vue3';

defineProps<{
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(store.url(), {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>

<template>
    <form @submit.prevent="submit" class="flex flex-col">
        <div class="grid gap-2">
            <Label for="admin-email">Email admin</Label>
            <Input
                id="admin-email"
                v-model="form.email"
                type="email"
                name="email"
                required
                :tabindex="11"
                autocomplete="email"
                placeholder="admin@example.com"
            />
            <InputError :message="form.errors.email" />
        </div>

        <div class="mt-4 grid gap-2">
            <div class="flex items-center justify-between">
                <Label for="admin-password">Password</Label>
                <TextLink
                    v-if="canResetPassword"
                    :href="request()"
                    class="text-sm"
                    :tabindex="15"
                >
                    Forgot password?
                </TextLink>
            </div>
            <Input
                id="admin-password"
                v-model="form.password"
                type="password"
                name="password"
                required
                :tabindex="12"
                autocomplete="current-password"
                placeholder="Password admin"
            />
            <InputError :message="form.errors.password" />
        </div>

        <div class="mt-2 flex items-center justify-between">
            <Label for="admin-remember" class="flex items-center">
                <Checkbox
                    id="admin-remember"
                    v-model:checked="form.remember"
                    name="remember"
                    :tabindex="13"
                />
                <span>Remember me</span>
            </Label>
        </div>

        <Button
            type="submit"
            class="mt-6"
            :tabindex="14"
            :disabled="form.processing"
            data-test="login-admin-button"
        >
            <Spinner v-if="form.processing" />
            Masuk sebagai Admin
        </Button>
    </form>
</template>
