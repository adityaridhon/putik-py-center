<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Toaster } from '@/components/ui/sonner';
import { getInitials } from '@/composables/useInitials';
import { useFlashMessages } from '@/composables/useToast';
import {
    artikel,
    daftarLayanan,
    dashboard,
    home,
    kontak,
    layananKami,
    login,
    logout,
    tentangKami,
    userDashboard,
} from '@/routes';
import type { Auth } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { ChevronDown } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const page = usePage();
const props = defineProps<{
    profile?: {
        logo_url?: string | null;
    };
    title?: string;
}>();

const auth = computed(
    () =>
        page.props.auth as Auth & {
            user?: Auth['user'] & {
                role?: string;
            };
        },
);
const menuOpen = ref(false);

const companyProfile = computed(
    () =>
        (
            page.props as {
                companyProfile?: {
                    logo_url?: string | null;
                };
            }
        ).companyProfile,
);

const logoUrl = computed(
    () => props.profile?.logo_url ?? companyProfile.value?.logo_url,
);

const logoSrc = computed(() =>
    logoUrl.value ? `/storage/${logoUrl.value}` : '/images/logo_putik.webp',
);

const isTitleMode = computed(() => Boolean(props.title));

const normalizePath = (url: string) => {
    const [path] = url.split('?');

    if (!path) {
        return '/';
    }

    return path.length > 1 && path.endsWith('/') ? path.slice(0, -1) : path;
};

const currentPath = computed(() => normalizePath(page.url || '/'));

const isRouteActive = (url: string, exact = true) => {
    const targetPath = normalizePath(url);

    if (exact) {
        return currentPath.value === targetPath;
    }

    if (targetPath === '/') {
        return currentPath.value === '/';
    }

    return (
        currentPath.value === targetPath ||
        currentPath.value.startsWith(`${targetPath}/`)
    );
};

const isLayananActive = computed(
    () =>
        isRouteActive(layananKami().url, false) ||
        isRouteActive(daftarLayanan().url, false) ||
        currentPath.value.startsWith('/booking-layanan'),
);

const linkClasses = (active: boolean) => [
    'block rounded px-3 py-2 transition-colors md:border-0 md:bg-transparent md:p-0',
    active
        ? 'text-emerald-200'
        : 'text-white hover:bg-neutral-tertiary hover:text-emerald-200 md:hover:bg-transparent',
];

const layananTriggerClasses = computed(() => [
    'flex items-center gap-1 rounded px-3 py-2 transition-colors md:border-0 md:p-0',
    isLayananActive.value
        ? 'text-emerald-200'
        : 'text-white hover:bg-neutral-tertiary hover:text-emerald-200 md:hover:bg-transparent',
]);

const layananItemClasses = (active: boolean) =>
    active ? 'text-primary font-semibold' : 'text-slate-700';

const closeMenu = () => {
    menuOpen.value = false;
};

useFlashMessages();
</script>

<template>
    <Toaster position="top-right" :duration="4000" rich-colors />
    <nav v-if="isTitleMode" class="w-full bg-primary px-3 py-3 sm:px-6">
        <div class="mx-auto flex w-full max-w-5xl items-center gap-2 sm:gap-3">
            <img
                :src="logoSrc"
                alt="Putik Psychology Center"
                class="h-7 w-auto shrink-0 sm:h-8"
            />

            <h1
                class="flex-1 pr-7 text-center text-sm font-bold tracking-wide text-white sm:pr-8 sm:text-xl md:text-2xl"
            >
                {{ props.title }}
            </h1>
        </div>
    </nav>
    <nav
        v-else
        class="border-default fixed start-0 top-0 z-20 w-full border-b bg-primary"
    >
        <div
            class="mx-auto flex max-w-7xl flex-wrap items-center justify-between p-4"
        >
            <div class="logo">
                <img :src="logoSrc" width="50" alt="Logo" />
            </div>

            <div
                class="flex items-center space-x-3 md:order-2 md:space-x-0 rtl:space-x-reverse"
            >
                <DropdownMenu v-if="auth?.user">
                    <DropdownMenuTrigger as-child>
                        <button
                            type="button"
                            class="focus:ring-neutral-tertiary hidden rounded-full bg-white text-sm focus:ring-4 focus:outline-none md:me-0 md:flex"
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
                            <DropdownMenuItem
                                as-child
                                v-if="auth?.user?.role === 'admin'"
                            >
                                <Link :href="dashboard().url"
                                    >Dashboard Admin</Link
                                >
                            </DropdownMenuItem>
                            <DropdownMenuItem as-child v-else>
                                <Link :href="userDashboard().url"
                                    >Dashboard User</Link
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
                <Button
                    v-else
                    as-child
                    variant="secondary"
                    class="hidden md:inline-flex"
                >
                    <Link :href="login().url">Login</Link>
                </Button>
                <button
                    type="button"
                    class="rounded-base inline-flex h-10 w-10 items-center justify-center p-2 text-sm text-white hover:bg-white/10 hover:text-white focus:ring-2 focus:ring-white/40 focus:outline-none md:hidden"
                    aria-controls="navbar-cta"
                    :aria-expanded="menuOpen"
                    @click="menuOpen = !menuOpen"
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
                class="w-full items-center justify-between md:order-1 md:flex md:w-auto"
                :class="menuOpen ? 'mt-4 flex' : 'hidden md:flex'"
                id="navbar-cta"
            >
                <ul
                    class="border-default rounded-base bg-neutral-secondary-soft md:bg-neutral-primary w-full flex-col border p-4 font-medium text-white md:mt-0 md:flex md:w-auto md:flex-row md:space-x-8 md:border-0 md:p-0 rtl:space-x-reverse"
                >
                    <li v-if="auth?.user" class="mb-3 md:hidden">
                        <div
                            class="border-default flex items-center gap-3 border-b pb-3"
                        >
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
                            <div class="min-w-0">
                                <p
                                    class="truncate text-sm font-semibold text-white"
                                >
                                    {{ auth?.user?.name || 'User' }}
                                </p>
                                <p class="truncate text-xs text-white/80">
                                    {{ auth?.user?.email || '' }}
                                </p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <Link
                            :href="home().url"
                            :class="linkClasses(isRouteActive(home().url))"
                            :aria-current="
                                isRouteActive(home().url) ? 'page' : undefined
                            "
                            @click="closeMenu"
                            >Beranda</Link
                        >
                    </li>
                    <li>
                        <Link
                            :href="tentangKami().url"
                            :class="
                                linkClasses(
                                    isRouteActive(tentangKami().url, false),
                                )
                            "
                            @click="closeMenu"
                            >Tentang Kami</Link
                        >
                    </li>
                    <li>
                        <DropdownMenu>
                            <DropdownMenuTrigger as-child>
                                <button :class="layananTriggerClasses">
                                    Layanan
                                    <ChevronDown class="h-4 w-4" />
                                </button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="start" :side-offset="8">
                                <DropdownMenuGroup>
                                    <DropdownMenuItem as-child>
                                        <Link
                                            :href="layananKami().url"
                                            :class="
                                                layananItemClasses(
                                                    isRouteActive(
                                                        layananKami().url,
                                                        false,
                                                    ),
                                                )
                                            "
                                            @click="closeMenu"
                                            >Layanan Kami</Link
                                        >
                                    </DropdownMenuItem>
                                    <DropdownMenuItem as-child>
                                        <Link
                                            :href="daftarLayanan().url"
                                            :class="
                                                layananItemClasses(
                                                    isRouteActive(
                                                        daftarLayanan().url,
                                                        false,
                                                    ),
                                                )
                                            "
                                            @click="closeMenu"
                                            >Tes Online</Link
                                        >
                                    </DropdownMenuItem>
                                </DropdownMenuGroup>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </li>
                    <li>
                        <Link
                            :href="artikel().url"
                            :class="
                                linkClasses(isRouteActive(artikel().url, false))
                            "
                            @click="closeMenu"
                            >Artikel</Link
                        >
                    </li>
                    <li>
                        <Link
                            :href="kontak().url"
                            :class="
                                linkClasses(isRouteActive(kontak().url, false))
                            "
                            @click="closeMenu"
                            >Kontak</Link
                        >
                    </li>
                    <li v-if="auth?.user" class="md:hidden">
                        <Link
                            :href="userDashboard().url"
                            method="post"
                            as="button"
                            :class="linkClasses(false)"
                            @click="closeMenu"
                        >
                            Dashboard User</Link
                        >
                    </li>
                    <li v-if="auth?.user" class="md:hidden">
                        <Link
                            :href="logout().url"
                            method="post"
                            as="button"
                            :class="linkClasses(false)"
                            @click="closeMenu"
                            >Logout</Link
                        >
                    </li>
                    <li v-if="!auth?.user" class="md:hidden">
                        <Link
                            :href="login().url"
                            :class="linkClasses(isRouteActive(login().url))"
                            @click="closeMenu"
                            >Login</Link
                        >
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
