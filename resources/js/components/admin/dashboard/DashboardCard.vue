<script setup lang="ts">
import { computed } from 'vue';
import { Badge } from '@/components/ui/badge';
import {
    Card,
    CardAction,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import { BookOpen, Calendar, FileText } from 'lucide-vue-next';

const props = defineProps<{
    stats?: {
        janjiMingguIni: number;
        laporanPsikologi: number;
        artikelTerbit: number;
    };
    trends?: {
        janjiMingguIni: number;
        laporanPsikologi: number;
        artikelTerbit: number;
    };
}>();

const datacard = computed(() => {
    const stats = props.stats || {
        janjiMingguIni: 0,
        laporanPsikologi: 0,
        artikelTerbit: 0,
    };

    return [
        {
            title: 'Janji Minggu ini',
            value: stats.janjiMingguIni,
            trend: props.trends?.janjiMingguIni ?? 0,
            icon: Calendar,
        },
        {
            title: 'Laporan Psikologi',
            value: stats.laporanPsikologi,
            trend: props.trends?.laporanPsikologi ?? 0,
            icon: FileText,
        },
        {
            title: 'Artikel Terbit',
            value: stats.artikelTerbit,
            trend: props.trends?.artikelTerbit ?? 0,
            icon: BookOpen,
        },
    ];
});

const formatTrend = (trend: number) => {
    const sign = trend >= 0 ? '+' : '';
    return `${sign}${trend.toFixed(1)}%`;
};
</script>

<template>
    <Card class="@container/card" v-for="value in datacard" :key="value.title">
        <CardHeader>
            <div class="flex items-start gap-4">
                <div class="rounded-lg bg-primary/5 p-2">
                    <component :is="value.icon" class="h-10 w-8 text-primary" />
                </div>
                <div class="flex-1">
                    <CardDescription>{{ value.title }}</CardDescription>
                    <CardTitle
                        class="text-2xl font-semibold tabular-nums @[250px]/card:text-3xl"
                    >
                        {{ value.value }}
                    </CardTitle>
                </div>
            </div>
            <CardAction>
                <TooltipProvider :delay-duration="0">
                    <Tooltip>
                        <TooltipTrigger as-child>
                            <Badge variant="outline"> {{ formatTrend(value.trend) }} </Badge>
                        </TooltipTrigger>
                        <TooltipContent>
                            <p>Dibanding minggu lalu</p>
                        </TooltipContent>
                    </Tooltip>
                </TooltipProvider>
            </CardAction>
        </CardHeader>
    </Card>
</template>
