<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Card, CardAction, CardHeader } from '@/components/ui/card';
import { create, edit } from '@/routes/minatBakat';
import { Link } from '@inertiajs/vue3';
import { FileQuestion, Folder, PencilRuler } from 'lucide-vue-next';

defineProps<{
    index: number;
}>();
</script>

<template>
    <Card>
        <CardHeader class="flex flex-col items-center justify-between">
            <div class="flex flex-col items-center gap-2">
                <Folder class="h-20 w-20 text-primary" />
                <h3 class="text-lg font-semibold">
                    Kategori {{ String.fromCharCode(64 + index) }}
                </h3>
            </div>
            <CardAction class="mx-auto mt-1 flex flex-col gap-2">
                <Link :href="create().url">
                    <Button variant="default" size="sm" class="w-full"
                        ><FileQuestion /> Buat soal</Button
                    >
                </Link>
                <Link :href="edit(index).url">
                    <Button variant="secondary" size="sm" class="w-full"
                        ><PencilRuler /> Kelola Soal</Button
                    >
                </Link>
            </CardAction>
        </CardHeader>
    </Card>
</template>
