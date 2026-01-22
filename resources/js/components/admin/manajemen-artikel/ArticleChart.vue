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
import { Donut } from '@unovis/ts';
import { VisDonut, VisSingleContainer } from '@unovis/vue';

const chartData = [
    { kategori: 'edukasi', jumlah: 275, fill: 'var(--color-edukasi)' },
    {
        kategori: 'pengembangan-diri',
        jumlah: 200,
        fill: 'var(--color-pengembangan-diri)',
    },
    { kategori: 'event', jumlah: 187, fill: 'var(--color-event)' },
];
type Data = (typeof chartData)[number];

const chartConfig = {
    jumlah: {
        label: 'Jumlah Artikel ',
        color: undefined,
    },
    edukasi: {
        label: 'Edukasi',
        color: 'var(--chart-1)',
    },
    'pengembangan-diri': {
        label: 'Pengembangan Diri',
        color: 'var(--chart-2)',
    },
    event: {
        label: 'Event',
        color: 'var(--chart-3)',
    },
} satisfies ChartConfig;
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
