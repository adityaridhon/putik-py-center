<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import {
    Card,
    CardAction,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { HandshakeIcon, Stethoscope } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
    servicesCount?: number;
    clientsCount?: number;
}>();

const datacard = computed(() => [
    {
        title: 'Layanan',
        value: props.servicesCount?.toString() || '0',
        icon: Stethoscope,
    },
    {
        title: 'Mitra',
        value: props.clientsCount?.toString() || '0',
        icon: HandshakeIcon,
    },
]);
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
                <Badge variant="outline"> +12.5% </Badge>
            </CardAction>
        </CardHeader>
    </Card>
</template>
