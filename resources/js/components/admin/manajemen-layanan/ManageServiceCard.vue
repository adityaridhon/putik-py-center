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
import { Calendar, FileText } from 'lucide-vue-next';

const props = defineProps<{
    bookings?: any[];
    trends?: {
        janjiMendatang: number;
        janjiSelesai: number;
    };
}>();

const datacard = computed(() => {
    const data = props.bookings || [];
    
    const upcoming = data.filter(
        (b) => b.status === 'pending' || b.status === 'confirmed'
    ).length;

    const completed = data.filter(
        (b) => b.status === 'completed'
    ).length;

    return [
        {
            title: 'Janji Mendatang',
            value: upcoming,
            trend: props.trends?.janjiMendatang ?? 0,
            icon: Calendar,
        },
        {
            title: 'Janji Selesai',
            value: completed,
            trend: props.trends?.janjiSelesai ?? 0,
            icon: FileText,
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
