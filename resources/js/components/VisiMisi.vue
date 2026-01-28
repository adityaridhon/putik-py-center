<script setup lang="ts">
const items = [
    {
        judul: 'Visi',
        deskripsi: [
            'Menjadi sarana dan wadah informasi bagi para sarjana psikologi ataupun orang-orang yang memiliki minat dan kepedulian untuk memberikan segala bentuk jasa kepada masyarakat dalam pemecahan masalah psikologi.',
            'Menjadikan profesi psikologi, khususnya di Balikpapan dikenal tiap aspek kehidupan.',
        ],
        logo: '/images/visi.png',
        color: 'bg-primary',
    },
    {
        judul: 'Misi',
        deskripsi:
            'Menjadikan Balikpapan sebagai destinasi wisata unggulan di Kalimantan yang berkelanjutan, dengan mengedepankan keindahan dan pelestarian budaya lokal, serta pelayanan berkualitas tinggi.',
        logo: '/images/misi.png',
        color: 'bg-primary',
    },
];
</script>

<template>
    <section class="py-14 text-center">
        <div
            class="mx-auto grid max-w-5xl grid-cols-1 gap-12 px-6 md:px-8 md:grid-cols-2 md:gap-24"
        >
            <div
                v-for="item in items"
                :key="item.judul"
                class="flex min-h-[360px] flex-col rounded-2xl bg-primary p-6 shadow-lg transition hover:-translate-y-2 hover:shadow-2xl"
            >
                <img
                    :src="item.logo"
                    :alt="item.judul"
                    class="mx-auto mb-3 w-8"
                />

                <h3 class="mb-4 text-center text-xl font-bold text-white">
                    {{ item.judul }}
                </h3>

                <ul
                    v-if="Array.isArray(item.deskripsi)"
                    class="flex-1 list-disc space-y-4 pl-5 text-left text-white"
                >
                    <li v-for="(point, i) in item.deskripsi" :key="i">
                        {{ point }}
                    </li>
                </ul>

                <p
                    v-else
                    class="flex-1 text-center text-white"
                >
                    {{ item.deskripsi }}
                </p>
            </div>
        </div>
    </section>
</template>