<script setup lang="ts">
import type { ChartConfig } from '@/components/ui/chart';

import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import {
    ChartContainer,
    ChartTooltip,
    ChartTooltipContent,
    componentToString,
} from '@/components/ui/chart';
import { getCategoryColor } from '@/utils/categoryColors';
import { Donut } from '@unovis/ts';
import { VisDonut, VisSingleContainer } from '@unovis/vue';
import { computed } from 'vue';

const props = defineProps<{
    data?: { kategori: string; kategori_id: number; jumlah: number }[];
}>();

const chartData = computed(() => {
    if (!props.data || props.data.length === 0) return [];

    return props.data.map((item) => ({
        kategori: item.kategori,
        kategori_id: item.kategori_id,
        jumlah: item.jumlah,
        fill: getCategoryColor(item.kategori_id).chart,
    }));
});

const chartConfig = computed(() => {
    const config: ChartConfig = {
        jumlah: {
            label: 'Jumlah Artikel ',
            color: undefined,
        },
    };

    chartData.value.forEach((item) => {
        config[item.kategori] = {
            label:
                item.kategori.charAt(0).toUpperCase() + item.kategori.slice(1),
            color: getCategoryColor(item.kategori_id).chart,
        };
    });

    return config;
});

type Data = {
    kategori: string;
    kategori_id: number;
    jumlah: number;
    fill: string;
};
</script>

<template>
    <Card class="flex flex-col">
        <CardHeader class="items-center pb-0">
            <CardTitle>Distribusi Artikel per Kategori</CardTitle>
            <CardDescription
                >Total Artikel Berdasarkan Kategori</CardDescription
            >
        </CardHeader>
        <CardContent class="flex-1 pb-0">
            <ChartContainer
                :config="chartConfig"
                class="mx-auto aspect-square max-h-[250px]"
            >
                <VisSingleContainer
                    :data="chartData"
                    :margin="{ top: 30, bottom: 30 }"
                >
                    <VisDonut
                        :value="(d: Data) => d.jumlah"
                        :color="
                            (d: Data) =>
                                chartConfig[
                                    d.kategori as keyof typeof chartConfig
                                ].color
                        "
                        :arc-width="0"
                    />
                    <ChartTooltip
                        :triggers="{
                            [Donut.selectors.segment]: componentToString(
                                chartConfig,
                                ChartTooltipContent,
                                { hideLabel: true },
                            )!,
                        }"
                    />
                </VisSingleContainer>
            </ChartContainer>
        </CardContent>
        <CardFooter class="flex-col gap-3 text-sm">
            <div class="flex flex-wrap justify-center gap-4">
                <div
                    v-for="item in chartData"
                    :key="item.kategori"
                    class="flex items-center gap-2"
                >
                    <div
                        class="h-3 w-3 rounded-sm"
                        :style="{
                            backgroundColor:
                                chartConfig[
                                    item.kategori as keyof typeof chartConfig
                                ].color,
                        }"
                    ></div>
                    <span class="text-sm text-muted-foreground">
                        {{
                            chartConfig[
                                item.kategori as keyof typeof chartConfig
                            ].label
                        }}
                        ({{ item.jumlah }})
                    </span>
                </div>
            </div>
        </CardFooter>
    </Card>
</template>
