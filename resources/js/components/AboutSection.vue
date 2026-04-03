<script setup lang="ts">
defineProps<{
    profile?: {
        company_name?: string;
        about?: string;
        logo_url?: string;
    };
}>();
</script>

<template>
    <section class="py-10 sm:py-12 md:py-14">
        <div
            class="wrapper mx-auto flex w-full max-w-7xl flex-col items-center gap-6 px-4 sm:px-6 md:flex-row md:items-center md:gap-8 md:px-8 lg:gap-12 lg:px-10"
        >
            <div
                class="image flex w-full justify-center md:w-1/2 md:justify-start"
            >
                <img
                    :src="
                        profile?.logo_url
                            ? `/storage/${profile.logo_url}`
                            : '/images/Company_Profile.png'
                    "
                    alt="Company Profile"
                    class="w-full max-w-[360px] sm:max-w-[460px] md:max-w-[420px] lg:max-w-[520px]"
                />
            </div>

            <div class="caption w-full text-left md:w-1/2">
                <h1
                    class="font-title mb-3 text-2xl font-bold sm:mb-4 sm:text-3xl md:text-4xl lg:text-5xl"
                >
                    TENTANG
                    {{ profile?.company_name?.toUpperCase() || 'PUTIK' }}
                </h1>

                <p
                    class="w-full text-justify text-sm leading-relaxed text-primary sm:text-base"
                >
                    {{
                        profile?.about ||
                        'Putik didirikan sebagai lembaga yang bergerak di bidang pelayanan psikologi, meliputi Children Center, layanan konseling, terapi, dan pemeriksaan psikologi. Pembentukan Putik bertujuan menjadi wadah bagi sarjana psikologi dalam menyalurkan gagasan dan keilmuannya untuk mendukung kesejahteraan masyarakat.'
                    }}
                </p>
            </div>
        </div>
    </section>
</template>
