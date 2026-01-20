<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';
import Button from '@/components/ui/button/Button.vue';
import {
    Card,
    CardAction,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Instagram, Mail, Pencil, Phone } from 'lucide-vue-next';

const headline =
    'Mitra terpercaya dalam pemecahan masalah psikologis untuk individu, pendidikan, dan perusahaan di Balikpapan sejak 2006';

const tentang =
    'Putik didirikan sebagai lembaga yang bergerak di bidang pelayanan psikologi, meliputi Children Center, layanan konseling, terapi, dan pemeriksaan psikologi. Pembentukan Putik bertujuan menjadi wadah bagi sarjana psikologi dalam menyalurkan gagasan dan keilmuannya untuk mendukung kesejahteraan masyarakat.';

const kontak = [
    {
        icon: Phone,
        value: '0812 5581 350',
    },
    {
        icon: Mail,
        value: 'putik_pc@yahoo.com',
    },
    {
        icon: Instagram,
        value: '@putikpsycenter',
    },
];
</script>

<template>
    <Card class="@container/card">
        <CardHeader>
            <div class="flex flex-row justify-between">
                <div class="max-w-xs">
                    <CardTitle class="font-semibold">
                        Gambar Landing Page
                    </CardTitle>
                    <img src="/images/logo_putik.webp" alt="headline" />
                </div>
                <div class="flex max-w-2xl flex-col gap-3">
                    <div class="space-y-2">
                        <CardTitle class="font-semibold"> Headline </CardTitle>
                        <CardDescription>{{ headline }}</CardDescription>
                    </div>
                    <div class="space-y-2">
                        <CardTitle class="font-semibold">
                            Tentang Putik
                        </CardTitle>
                        <CardDescription>{{ tentang }}</CardDescription>
                    </div>
                    <div class="space-y-2">
                        <CardTitle class="font-semibold">
                            Kontak Putik
                        </CardTitle>
                        <CardDescription class="flex gap-2">
                            <Badge
                                v-for="(item, index) in kontak"
                                :key="index"
                                class="bg-blue-500 text-white"
                            >
                                <component :is="item.icon" />
                                {{ item.value }}
                            </Badge>
                        </CardDescription>
                    </div>
                </div>
            </div>
        </CardHeader>
        <CardFooter class="">
            <CardAction class="mx-auto w-full px-10">
                <Button class="w-full"> <Pencil /> Edit</Button>
            </CardAction>
        </CardFooter>
    </Card>
</template>
