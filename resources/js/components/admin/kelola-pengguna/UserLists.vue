<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import {
    InputGroup,
    InputGroupAddon,
    InputGroupInput,
} from '@/components/ui/input-group';
import {
    Pagination,
    PaginationContent,
    PaginationEllipsis,
    PaginationItem,
    PaginationNext,
    PaginationPrevious,
} from '@/components/ui/pagination';
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
import { Link, router } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { Eye, SearchIcon } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

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
    applyFilters(1);
}, 500);

// Apply filters to backend
const applyFilters = (page = 1) => {
    router.get(
        kelolaPengguna().url,
        {
            search: searchQuery.value || undefined,
            sort:
                selectedSort.value !== 'semua' ? selectedSort.value : undefined,
            page,
        },
        {
            preserveState: true,
            preserveScroll: true,
        },
    );
};

// Watch untuk search (dengan debounce)
watch(searchQuery, () => {
    performSearch();
});

// Watch untuk filter dropdown (langsung apply)
watch(selectedSort, () => {
    applyFilters(1);
});

const goToUsersPage = (page: number) => {
    applyFilters(page);
};
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
                        <SelectItem value="jumlah-tes-terbanyak"
                            >Jumlah Tes (Terbanyak)</SelectItem
                        >
                        <SelectItem value="jumlah-tes-tersedikit"
                            >Jumlah Tes (Tersedikit)</SelectItem
                        >
                        <SelectItem value="terbaru"
                            >Terdaftar Terbaru</SelectItem
                        >
                        <SelectItem value="terlama"
                            >Terdaftar Terlama</SelectItem
                        >
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
                        Jumlah Tes
                    </TableHead>
                    <TableHead
                        class="w-40 text-center font-semibold text-white"
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
                        >{{ (props.users?.from || 0) + index }}
                    </TableCell>
                    <TableCell class="text-center">
                        {{ user.nama }}
                    </TableCell>
                    <TableCell class="text-center">
                        {{ user.jumlah_tes }}
                    </TableCell>
                    <TableCell class="w-32 text-center">
                        <Link :href="`/admin/kelola-pengguna/${user.id}`">
                            <Button>
                                <Eye class="h-4 w-4" /> Lihat Detail
                            </Button>
                        </Link>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>

    <!-- Pagination -->
    <div v-if="props.users && props.users.last_page > 1" class="mt-4">
        <div class="w-full flex-col items-center justify-between">
            <div class="mb-2 text-center text-sm text-gray-600">
                Menampilkan {{ props.users.from }} - {{ props.users.to }} dari
                {{ props.users.total }} pengguna
            </div>

            <Pagination
                :total="props.users.total"
                :items-per-page="props.users.per_page"
                :default-page="props.users.current_page"
                v-slot="{ page }"
            >
                <PaginationContent v-slot="{ items }">
                    <PaginationPrevious
                        :disabled="props.users.current_page === 1"
                        @click="goToUsersPage(props.users.current_page - 1)"
                    />

                    <template v-for="(item, index) in items" :key="index">
                        <PaginationItem
                            v-if="item.type === 'page'"
                            :value="item.value"
                            :is-active="item.value === props.users.current_page"
                            @click="goToUsersPage(item.value)"
                        >
                            {{ item.value }}
                        </PaginationItem>

                        <PaginationEllipsis v-else />
                    </template>

                    <PaginationNext
                        :disabled="
                            props.users.current_page === props.users.last_page
                        "
                        @click="goToUsersPage(props.users.current_page + 1)"
                    />
                </PaginationContent>
            </Pagination>
        </div>
    </div>
</template>
