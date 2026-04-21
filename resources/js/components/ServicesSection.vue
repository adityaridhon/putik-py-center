<script setup lang="ts">
import { bookingLayanan } from '@/routes';
import { Link } from '@inertiajs/vue3';
import {
    BookOpen,
    Brain,
    BriefcaseBusiness,
    GraduationCap,
    HeartHandshake,
    MessageCircle,
} from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
    services?: Array<{
        id: number;
        name: string;
        description: string | null;
        image_url?: string | null;
    }>;
}>();

const bookingHref = bookingLayanan().url;

const iconList = [
    MessageCircle,
    HeartHandshake,
    BookOpen,
    GraduationCap,
    BriefcaseBusiness,
    Brain,
];

const defaultServiceImages = [
    '/images/Konseling_1.png',
    '/images/TesKep_1.png',
    '/images/TesSD_1.png',
    '/images/Penjurusan_1.png',
    '/images/TesPer_1.png',
    '/images/Mapping_1.png',
];

const serviceItems = computed(() => {
    if (props.services && props.services.length > 0) {
        return props.services.map((service, index) => ({
            id: service.id,
            title: service.name,
            description:
                service.description ||
                'Deskripsi layanan tidak tersedia. Silakan hubungi admin untuk informasi lebih lanjut.',
            icon: iconList[index % iconList.length],
            image:
                service.image_url && service.image_url.trim().length > 0
                    ? service.image_url
                    : defaultServiceImages[index % defaultServiceImages.length],
            primaryAction: 'Jadwalkan Layanan',
        }));
    }

    return [];
});
</script>

<template>
    <section
        class="mx-auto max-w-7xl space-y-14 px-4 py-10 sm:px-6 sm:py-12 md:space-y-16 lg:space-y-20 lg:px-8 lg:py-14"
    >
        <div
            v-for="service in serviceItems"
            :key="service.id"
            class="grid grid-cols-1 items-center gap-8 rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200 sm:p-6 md:gap-10 lg:grid-cols-2 lg:gap-12 lg:p-8"
        >
            <div
                class="flex justify-center"
                :class="service.id % 2 === 0 ? 'lg:order-2' : ''"
            >
                <div
                    class="w-full max-w-lg overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-slate-200"
                >
                    <img
                        :src="service.image"
                        :alt="service.title"
                        class="h-72 w-full object-cover sm:h-80"
                    />
                </div>
            </div>

            <div class="flex flex-col justify-center px-1 sm:px-2 lg:px-4">
                <div
                    class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-primary"
                >
                    <component :is="service.icon" class="h-6 w-6 text-white" />
                </div>

                <h3
                    class="mb-3 text-xl leading-tight font-semibold sm:text-2xl"
                >
                    {{ service.title }}
                </h3>

                <p
                    class="mb-7 max-w-xl text-sm leading-relaxed text-slate-600 sm:mb-8 sm:text-base"
                >
                    {{ service.description }}
                </p>

                <div class="flex gap-4">
                    <Link
                        :href="bookingHref"
                        class="rounded-xl bg-primary px-5 py-3 text-sm text-white transition hover:bg-[#22352A] sm:px-6 sm:text-base"
                    >
                        {{ service.primaryAction }}
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
