<script setup lang="ts">
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { getInitials } from '@/composables/useInitials';
import {
    daftarLayanan,
    dashboard,
    home,
    kontak,
    layananKami,
    logout,
    tentangKami,
} from '@/routes';
import type { Auth } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { ChevronDown } from 'lucide-vue-next';
import { computed } from 'vue';

defineProps<{
    profile?: {
        logo_url?: string;
    };
}>();

const page = usePage();
const auth = computed(() => page.props.auth as Auth);
</script>

<template>
    <nav
        class="border-default fixed start-0 top-0 z-20 w-full border-b bg-primary"
    >
        <div
            class="mx-auto flex max-w-7xl flex-wrap items-center justify-between p-4"
        >
            <div class="logo">
                <img
                    :src="
                        profile?.logo_url
                            ? `/storage/${profile.logo_url}`
                            : '/images/logo_putik.webp'
                    "
                    width="50"
                    alt="Logo"
                />
            </div>

            <div
                class="flex items-center space-x-3 md:order-2 md:space-x-0 rtl:space-x-reverse"
            >
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <button
                            type="button"
                            class="focus:ring-neutral-tertiary flex rounded-full bg-white text-sm focus:ring-4 md:me-0"
                        >
                            <span class="sr-only">Open user menu</span>
                            <div
                                v-if="auth?.user?.avatar"
                                class="h-8 w-8 overflow-hidden rounded-full"
                            >
                                <img
                                    class="h-full w-full object-cover"
                                    :src="auth.user.avatar"
                                    :alt="auth.user.name"
                                />
                            </div>
                            <div
                                v-else
                                class="bg-neutral-tertiary text-heading flex h-8 w-8 items-center justify-center rounded-full text-xs font-semibold"
                            >
                                {{ getInitials(auth?.user?.name || 'User') }}
                            </div>
                        </button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent
                        class="w-56"
                        align="end"
                        :side-offset="8"
                    >
                        <DropdownMenuLabel class="p-0 font-normal">
                            <div class="flex flex-col space-y-1 px-2 py-1.5">
                                <p class="text-heading text-sm font-medium">
                                    {{ auth?.user?.name || 'User' }}
                                </p>
                                <p class="text-body text-xs">
                                    {{ auth?.user?.email || '' }}
                                </p>
                            </div>
                        </DropdownMenuLabel>
                        <DropdownMenuSeparator />
                        <DropdownMenuGroup>
                            <DropdownMenuItem as-child>
                                <Link href="#">Pengaturan Akun</Link>
                            </DropdownMenuItem>
                            <DropdownMenuItem as-child>
                                <Link :href="dashboard().url"
                                    >Dashboard Admin</Link
                                >
                            </DropdownMenuItem>
                        </DropdownMenuGroup>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem as-child>
                            <Link
                                :href="logout().url"
                                method="post"
                                as="button"
                                class="w-full text-start"
                                >Keluar</Link
                            >
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
                <button
                    data-collapse-toggle="navbar-user"
                    type="button"
                    class="text-body rounded-base hover:bg-neutral-secondary-soft hover:text-heading focus:ring-neutral-tertiary inline-flex h-10 w-10 items-center justify-center p-2 text-sm focus:ring-2 focus:outline-none md:hidden"
                    aria-controls="navbar-user"
                    aria-expanded="false"
                >
                    <span class="sr-only">Open main menu</span>
                    <svg
                        class="h-6 w-6"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-width="2"
                            d="M5 7h14M5 12h14M5 17h14"
                        />
                    </svg>
                </button>
            </div>
            <div
                class="hidden w-full items-center justify-between md:order-1 md:flex md:w-auto"
                id="navbar-cta"
            >
                <ul
                    class="border-default rounded-base bg-neutral-secondary-soft md:bg-neutral-primary mt-4 flex flex-col border p-4 font-medium text-white md:mt-0 md:flex-row md:space-x-8 md:border-0 md:p-0 rtl:space-x-reverse"
                >
                    <li>
                        <Link
                            :href="home().url"
                            class="bg-brand md:text-fg-brand block rounded px-3 py-2 md:bg-transparent md:p-0"
                            aria-current="page"
                            >Beranda</Link
                        >
                    </li>
                    <li>
                        <Link
                            :href="tentangKami().url"
                            class="text-heading hover:bg-neutral-tertiary md:hover:text-fg-brand block rounded px-3 py-2 md:border-0 md:p-0 md:hover:bg-transparent md:dark:hover:bg-transparent"
                            >Tentang Kami</Link
                        >
                    </li>
                    <li>
                        <DropdownMenu>
                            <DropdownMenuTrigger as-child>
                                <button
                                    class="text-heading hover:bg-neutral-tertiary md:hover:text-fg-brand flex items-center gap-1 rounded px-3 py-2 md:border-0 md:p-0 md:hover:bg-transparent"
                                >
                                    Layanan
                                    <ChevronDown class="h-4 w-4" />
                                </button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="start" :side-offset="8">
                                <DropdownMenuGroup>
                                    <DropdownMenuItem as-child>
                                        <Link :href="layananKami().url"
                                            >Layanan Kami</Link
                                        >
                                    </DropdownMenuItem>
                                    <DropdownMenuItem as-child>
                                        <Link :href="daftarLayanan().url"
                                            >Daftar Layanan</Link
                                        >
                                    </DropdownMenuItem>
                                </DropdownMenuGroup>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </li>
                    <li>
                        <a
                            href="#"
                            class="text-heading hover:bg-neutral-tertiary md:hover:text-fg-brand block rounded px-3 py-2 md:border-0 md:p-0 md:hover:bg-transparent md:dark:hover:bg-transparent"
                            >Artikel</a
                        >
                    </li>
                    <li>
                        <Link
                            :href="kontak().url"
                            class="text-heading hover:bg-neutral-tertiary md:hover:text-fg-brand block rounded px-3 py-2 md:border-0 md:p-0 md:hover:bg-transparent md:dark:hover:bg-transparent"
                            >Kontak</Link
                        >
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
