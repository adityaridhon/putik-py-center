<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Card, CardAction, CardHeader } from '@/components/ui/card';
import { edit } from '@/routes/minatBakat';
import { Link } from '@inertiajs/vue3';
import { Folder, PencilRuler } from 'lucide-vue-next';

defineProps<{
    category: any;
}>();
</script>

<template>
    <Card>
        <CardHeader class="flex flex-col items-center justify-between">
            <div class="flex flex-col items-center gap-2">
                <Folder class="h-20 w-20 text-primary" />
                <h3 class="text-lg font-semibold">
                    {{ category.name }}
                </h3>
            </div>
            <CardAction class="mx-auto mt-1 flex flex-col gap-2 w-full">
                <Link :href="edit(category.id).url">
                    <Button variant="secondary" size="sm" class="w-full"
                        ><PencilRuler class="mr-2 h-4 w-4" /> Kelola Soal</Button
                    >
                </Link>
            </CardAction>
        </CardHeader>
    </Card>
</template>
