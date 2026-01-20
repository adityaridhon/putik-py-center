<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import {
    Card,
    CardAction,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { BookCheck, SquarePen } from 'lucide-vue-next';

const datacard = [
    {
        title: 'Artikel Terbit',
        value: '5',
        icon: BookCheck,
    },
    {
        title: 'Artikel Draft',
        value: '12',
        icon: SquarePen,
    },
];
</script>

<template>
    <Card class="@container/card" v-for="value in datacard" key="value.title">
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
                <Badge variant="outline"> +12.5% </Badge>
            </CardAction>
        </CardHeader>
    </Card>
</template>
