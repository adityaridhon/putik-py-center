<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';
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
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import { detail } from '@/routes/laporanPsikologi';
import { Link } from '@inertiajs/vue3';
import { SearchIcon, Trash, Upload } from 'lucide-vue-next';
import { ref } from 'vue';

const selectedFilter = ref('semua');

interface Report {
    id: number;
    nama: string;
    token: string;
    jenisTes: string;
    tanggal: string;
    status: 'Selesai' | 'Menunggu Analisis';
}

const reports = ref<Report[]>([
    {
        id: 1,
        nama: 'Ahmad Fauzi',
        token: '#abc123',
        jenisTes: 'Tes Minat Bakat',
        tanggal: '15 Februari 2026',
        status: 'Selesai',
    },
    {
        id: 2,
        nama: 'Siti Nurhaliza',
        token: '#abc123',
        jenisTes: 'Tes Intelengensi',
        tanggal: '20 Februari 2026',
        status: 'Menunggu Analisis',
    },
    {
        id: 3,
        nama: 'Budi Santoso',
        token: '#abc123',
        jenisTes: 'Tes Gaya Belajar',
        tanggal: '22 Februari 2026',
        status: 'Selesai',
    },
    {
        id: 4,
        nama: 'Dewi Lestari',
        token: '#abc123',
        jenisTes: 'Tes Minat Bakat',
        tanggal: '24 Februari 2026',
        status: 'Menunggu Analisis',
    },
    {
        id: 5,
        nama: 'Rizki Pratama',
        token: '#abc123',
        jenisTes: 'Tes Intelengensi',
        tanggal: '25 Februari 2026',
        status: 'Selesai',
    },
]);
</script>

<template>
    <div>
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
        <div
            class="overflow-hidden rounded-lg border border-gray-200 shadow-sm dark:border-gray-800"
        >
            <Table>
                <TableHeader class="bg-primary">
                    <TableRow class="border-0 hover:bg-transparent">
                        <TableHead class="text-center font-semibold text-white">
                            No
                        </TableHead>
                        <TableHead class="text-center font-semibold text-white">
                            Nama
                        </TableHead>
                        <TableHead class="text-center font-semibold text-white">
                            Token
                        </TableHead>
                        <TableHead class="text-center font-semibold text-white"
                            >Jenis Tes</TableHead
                        >
                        <TableHead class="text-center font-semibold text-white">
                            Tanggal
                        </TableHead>
                        <TableHead class="text-center font-semibold text-white">
                            Status
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
                        v-for="(report, index) in reports"
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
                            {{ report.token }}
                        </TableCell>
                        <TableCell class="text-center">
                            {{ report.jenisTes }}
                        </TableCell>
                        <TableCell class="text-center">
                            {{ report.tanggal }}
                        </TableCell>
                        <TableCell class="text-center">
                            <Badge
                                :variant="
                                    report.status === 'Selesai'
                                        ? 'default'
                                        : 'secondary'
                                "
                                :class="
                                    report.status === 'Menunggu Analisis'
                                        ? 'bg-yellow-500 text-white hover:bg-yellow-500/80'
                                        : ''
                                "
                            >
                                {{ report.status }}
                            </Badge>
                        </TableCell>
                        <TableCell class="align-middle">
                            <TooltipProvider>
                                <div
                                    class="flex items-center justify-center gap-1"
                                >
                                    <!-- Tombol untuk status Menunggu Analisis -->
                                    <Tooltip
                                        v-if="
                                            report.status ===
                                            'Menunggu Analisis'
                                        "
                                    >
                                        <TooltipTrigger as-child>
                                            <Link :href="detail(report.id).url">
                                                <Button
                                                    variant="default"
                                                    size="sm"
                                                >
                                                    <Upload class="h-4 w-4" />
                                                </Button>
                                            </Link>
                                        </TooltipTrigger>
                                        <TooltipContent>
                                            <p>Unggah Laporan</p>
                                        </TooltipContent>
                                    </Tooltip>

                                    <!-- Tombol Delete -->
                                    <Tooltip>
                                        <TooltipTrigger as-child>
                                            <Button
                                                variant="destructive"
                                                size="sm"
                                                :class="
                                                    report.status === 'Selesai'
                                                        ? 'w-18'
                                                        : ''
                                                "
                                            >
                                                <Trash class="h-4 w-4" />
                                            </Button>
                                        </TooltipTrigger>
                                        <TooltipContent>
                                            <p>Hapus</p>
                                        </TooltipContent>
                                    </Tooltip>
                                </div>
                            </TooltipProvider>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </div>
</template>
