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
import { detail } from '@/routes/kelolaPengguna';
import { Link } from '@inertiajs/vue3';
import { Eye, SearchIcon } from 'lucide-vue-next';
import { ref } from 'vue';

interface UsersReport {
    id: number;
    nama: string;
    jumlah_tes: string;
}

const UserReports = ref<UsersReport[]>([
    {
        id: 1,
        nama: 'Ahmad Fauzi',
        jumlah_tes: '3',
    },
    {
        id: 2,
        nama: 'Siti Nurhaliza',
        jumlah_tes: '2',
    },
    {
        id: 3,
        nama: 'Budi Santoso',
        jumlah_tes: '1',
    },
    {
        id: 4,
        nama: 'Dewi Lestari',
        jumlah_tes: '2',
    },
    {
        id: 5,
        nama: 'Rizki Pratama',
        jumlah_tes: '1',
    },
]);

const selectedFilter = ref('semua');
</script>

<template>
    <!-- Filter Options -->
    <div class="mb-4 flex items-center gap-4">
        <!-- Search -->
        <div>
            <InputGroup>
                <InputGroupInput placeholder="Cari pengguna..." />
                <InputGroupAddon>
                    <SearchIcon />
                </InputGroupAddon>
            </InputGroup>
        </div>

        <!-- Filter -->
        <div>
            <Select v-model="selectedFilter">
                <SelectTrigger class="w-60">
                    <SelectValue placeholder="Semua" />
                </SelectTrigger>
                <SelectContent>
                    <SelectGroup>
                        <SelectLabel>Urutkan</SelectLabel>
                        <SelectItem value="semua">Semua</SelectItem>
                        <SelectItem value="nama-az">Nama (A-Z)</SelectItem>
                        <SelectItem value="jenis-tes-az"
                            >Jenis Tes (A-Z)</SelectItem
                        >
                        <SelectItem value="tanggal-terbaru"
                            >Tanggal Terbaru</SelectItem
                        >
                        <SelectItem value="tanggal-terlama"
                            >Tanggal Terlama</SelectItem
                        >
                    </SelectGroup>
                    <SelectGroup>
                        <SelectLabel>Jenis Tes</SelectLabel>
                        <SelectItem value="tes-minat-bakat"
                            >Tes Minat Bakat</SelectItem
                        >
                        <SelectItem value="tes-intelengensi"
                            >Tes Intelengensi</SelectItem
                        >
                        <SelectItem value="tes-gaya-belajar"
                            >Tes Gaya Belajar</SelectItem
                        >
                    </SelectGroup>
                    <SelectGroup>
                        <SelectLabel>Status</SelectLabel>
                        <SelectItem value="status-selesai"
                            >Status: Selesai</SelectItem
                        >
                        <SelectItem value="status-menunggu"
                            >Status: Menunggu Analisis</SelectItem
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
                    v-for="(report, index) in UserReports"
                    :key="report.id"
                    class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50"
                >
                    <TableCell
                        class="text-center font-semibold text-gray-600 dark:text-gray-400"
                        >{{ index + 1 }}
                    </TableCell>
                    <TableCell class="text-center">
                        {{ report.nama }}
                    </TableCell>
                    <TableCell class="text-center">
                        {{ report.jumlah_tes }}
                    </TableCell>
                    <TableCell class="w-32 text-center">
                        <Link :href="detail(report.id).url">
                            <Button
                                ><Eye class="h-4 w-4" /> Lihat Detail</Button
                            >
                        </Link>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>
