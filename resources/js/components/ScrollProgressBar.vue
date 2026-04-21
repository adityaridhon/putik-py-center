<script setup lang="ts">
import { onMounted, onUnmounted, ref } from 'vue';

const scrollProgress = ref(0);

const handleScroll = () => {
    const scrollTop = window.scrollY;
    const docHeight =
        document.documentElement.scrollHeight - window.innerHeight;
    const scrolled = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
    scrollProgress.value = scrolled;
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>

<template>
    <div class="fixed top-1/2 right-4 z-50 h-[45vh] w-2 -translate-y-1/2">
        <div
            class="relative h-full overflow-hidden rounded-full bg-primary/15 shadow-sm"
        >
            <div
                class="absolute top-0 right-0 left-0 rounded-full bg-primary transition-[height] duration-300 ease-out"
                :style="{ height: scrollProgress + '%' }"
            />
        </div>
    </div>
</template>
