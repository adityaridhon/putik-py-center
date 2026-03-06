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
import { laporanPsikologi } from '@/routes';
import { router, Link } from '@inertiajs/vue3';
import { SearchIcon, Trash, Upload } from 'lucide-vue-next';
import { ref, computed, watch } from 'vue';
import { debounce } from 'lodash';

// Props dari parent (backend)
const props = defineProps<{
    sessions?: any;
    filters?: {
        search?: string;
        test_type?: string;
        status?: string;
    };
}>();

// Reactive search and filters
const searchQuery = ref(props.filters?.search || '');
const selectedTestType = ref(props.filters?.test_type || 'semua');
const selectedStatus = ref(props.filters?.status || 'semua');

// Dummy data sebagai fallback
const defaultReports = [
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
];

// Use backend data if available
const reports = computed(() => props.sessions?.data || defaultReports);

// Debounced search function
const performSearch = debounce(() => {
    applyFilters();
}, 500);

// Apply filters to backend
const applyFilters = () => {
    router.get(
        laporanPsikologi().url,
        {
            search: searchQuery.value || undefined,
            test_type: selectedTestType.value !== 'semua' ? selectedTestType.value : undefined,
            status: selectedStatus.value !== 'semua' ? selectedStatus.value : undefined,
        },
        {
            preserveState: true,
            preserveScroll: true,
        }
    );
};

// Watch untuk search (dengan debounce)
watch(searchQuery, () => {
    performSearch();
});

// Watch untuk filter dropdown (langsung apply)
watch([selectedTestType, selectedStatus], () => {
    applyFilters();
});

// Delete function
const deleteReport = (id: number) => {
    if (confirm('Apakah Anda yakin ingin menghapus data tes ini?')) {
        router.delete(`/admin/laporan-psikologi/${id}`, {
            preserveScroll: true,
            onSuccess: () => {
                // Success handled by flash message
            },
        });
    }
};

</script>

<template>
    <div>
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

            <!-- Filter Jenis Tes -->
            <div>
                <Select v-model="selectedTestType">
                    <SelectTrigger class="w-60">
                        <SelectValue placeholder="Semua Jenis Tes" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Jenis Tes</SelectLabel>
                            <SelectItem value="semua">Semua</SelectItem>
                            <SelectItem value="interest">Tes Minat Bakat</SelectItem>
                            <SelectItem value="intelligence">Tes Intelegensi</SelectItem>
                            <SelectItem value="learning_style">Tes Gaya Belajar</SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
            </div>

            <!-- Filter Status -->
            <div>
                <Select v-model="selectedStatus">
                    <SelectTrigger class="w-60">
                        <SelectValue placeholder="Semua Status" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Status</SelectLabel>
                            <SelectItem value="semua">Semua</SelectItem>
                            <SelectItem value="selesai">Selesai</SelectItem>
                            <SelectItem value="menunggu_analisis">Menunggu Analisis</SelectItem>
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
                                            <Link :href="`/admin/laporan-psikologi/${report.id}`">
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
                                                @click="deleteReport(report.id)"
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

        <!-- Pagination -->
        <div v-if="props.sessions?.links" class="mt-4 flex justify-center gap-1">
            <Link
                v-for="(link, index) in props.sessions.links"
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
    </div>
</template>
