<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import {
    InputGroup,
    InputGroupAddon,
    InputGroupInput,
} from '@/components/ui/input-group';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { kelolaPengguna } from '@/routes';
import { router, Link, usePage } from '@inertiajs/vue3';
import { Eye, SearchIcon, ShieldAlert, ShieldCheck } from 'lucide-vue-next';
import { ref, computed, watch } from 'vue';
import { debounce } from 'lodash';

// Ambil data admin login saat ini (is_superadmin) dari props
const page = usePage();
const isSuperAdmin = computed(() => !!page.props.auth?.user?.is_superadmin);

// Props dari parent (backend)
const props = defineProps<{
    users?: any;
    filters?: {
        search?: string;
        sort?: string;
    };
}>();

// Reactive search and filters
const searchQuery = ref(props.filters?.search || '');
const selectedSort = ref(props.filters?.sort || 'semua');

// Dummy data sebagai fallback
const defaultUsers = [
    {
        id: 1,
        nama: 'Ahmad Fauzi',
        email: 'ahmad@example.com',
        jumlah_tes: 3,
    },
    {
        id: 2,
        nama: 'Siti Nurhaliza',
        email: 'siti@example.com',
        jumlah_tes: 2,
    },
    {
        id: 3,
        nama: 'Budi Santoso',
        email: 'budi@example.com',
        jumlah_tes: 1,
    },
    {
        id: 4,
        nama: 'Dewi Lestari',
        email: 'dewi@example.com',
        jumlah_tes: 2,
    },
    {
        id: 5,
        nama: 'Rizki Pratama',
        email: 'rizki@example.com',
        jumlah_tes: 1,
    },
];

// Use backend data if available
const users = computed(() => props.users?.data || defaultUsers);

// Debounced search function
const performSearch = debounce(() => {
    applyFilters();
}, 500);

// Apply filters to backend
const applyFilters = () => {
    router.get(
        kelolaPengguna().url,
        {
            search: searchQuery.value || undefined,
            sort: selectedSort.value !== 'semua' ? selectedSort.value : undefined,
        },
        {
            preserveState: true,
            preserveScroll: true,
        }
    );
};

// Switch role function
const toggleRole = (user: any) => {
    if (!isSuperAdmin.value) return;

    const newRole = user.role === 'admin' ? 'user' : 'admin';
    const konfirmasi = confirm(
        `Apakah Anda yakin ingin mengubah role "${user.nama}" menjadi ${newRole.toUpperCase()}?`
    );

    if (konfirmasi) {
        router.put(`/admin/kelola-pengguna/${user.id}/role`, {
            role: newRole,
        }, {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                // Notifikasi sukses otomatis dari flash session (opsional)
            }
        });
    }
};

// Watch untuk search (dengan debounce)
watch(searchQuery, () => {
    performSearch();
});

// Watch untuk filter dropdown (langsung apply)
watch(selectedSort, () => {
    applyFilters();
});
</script>

<template>
    <!-- Filter Options -->
    <div class="mb-4 flex items-center gap-4">
        <!-- Search -->
        <div>
            <InputGroup>
                <InputGroupInput 
                    v-model="searchQuery"
                    placeholder="Cari pengguna..." 
                />
                <InputGroupAddon>
                    <SearchIcon />
                </InputGroupAddon>
            </InputGroup>
        </div>

        <!-- Filter -->
        <div>
            <Select v-model="selectedSort">
                <SelectTrigger class="w-60">
                    <SelectValue placeholder="Semua" />
                </SelectTrigger>
                <SelectContent>
                    <SelectGroup>
                        <SelectLabel>Urutkan</SelectLabel>
                        <SelectItem value="semua">Semua</SelectItem>
                        <SelectItem value="nama-az">Nama (A-Z)</SelectItem>
                        <SelectItem value="nama-za">Nama (Z-A)</SelectItem>
                        <SelectItem value="jumlah-tes-terbanyak">Jumlah Tes (Terbanyak)</SelectItem>
                        <SelectItem value="jumlah-tes-tersedikit">Jumlah Tes (Tersedikit)</SelectItem>
                        <SelectItem value="terbaru">Terdaftar Terbaru</SelectItem>
                        <SelectItem value="terlama">Terdaftar Terlama</SelectItem>
                    </SelectGroup>
                </SelectContent>
            </Select>
        </div>
    </div>
    <!-- Table users -->
    <div
        class="overflow-hidden rounded-lg border border-gray-200 shadow-sm dark:border-gray-800"
    >
        <Table>
            <TableHeader class="bg-primary">
                <TableRow class="border-0 hover:bg-transparent">
                    <TableHead
                        class="w-16 text-center font-semibold text-white"
                    >
                        No
                    </TableHead>
                    <TableHead class="text-center font-semibold text-white">
                        Nama
                    </TableHead>
                    <TableHead class="text-center font-semibold text-white">
                        Role
                    </TableHead>
                    <TableHead class="text-center font-semibold text-white">
                        Jumlah Tes
                    </TableHead>
                    <TableHead
                        class="w-64 text-center font-semibold text-white"
                    >
                        Aksi
                    </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow
                    v-for="(user, index) in users"
                    :key="user.id"
                    class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                >
                    <TableCell
                        class="text-center font-semibold text-gray-600 dark:text-gray-400"
                        >{{ index + 1 }}
                    </TableCell>
                    <TableCell class="text-center">
                        {{ user.nama }}
                        <div class="text-xs text-gray-500">{{ user.email }}</div>
                    </TableCell>
                    <TableCell class="text-center">
                        <span :class="[
                            'px-2 py-1 text-xs font-semibold rounded-full',
                            user.role === 'admin' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700'
                        ]">
                            {{ (user.role || 'user').toUpperCase() }}
                        </span>
                    </TableCell>
                    <TableCell class="text-center">
                        {{ user.jumlah_tes }}
                    </TableCell>
                    <TableCell class="text-center">
                        <div class="flex justify-center gap-2">
                            <Link :href="`/admin/kelola-pengguna/${user.id}`">
                                <Button size="sm" variant="outline">
                                    <Eye class="h-4 w-4 mr-1" /> Detail
                                </Button>
                            </Link>

                            <Button 
                                v-if="isSuperAdmin"
                                size="sm" 
                                variant="outline"
                                @click="toggleRole(user)"
                            >
                                <ShieldAlert v-if="user.role === 'admin'" class="h-4 w-4 mr-1" />
                                <ShieldCheck v-else class="h-4 w-4 mr-1" />
                                {{ user.role === 'admin' ? 'Cabut Admin' : 'Jadikan Admin' }}
                            </Button>
                        </div>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>

    <!-- Pagination -->
    <div v-if="props.users?.links" class="mt-4 flex justify-center gap-1">
        <Link
            v-for="(link, index) in props.users.links"
            :key="index"
            :href="link.url || '#'"
            :class="[
                'px-3 py-1 rounded border',
                link.active
                    ? 'bg-primary text-white border-primary'
                    : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50',
                !link.url && 'opacity-50 cursor-not-allowed pointer-events-none'
            ]"
            v-html="link.label"
            preserve-scroll
        />
    </div>
</template>
