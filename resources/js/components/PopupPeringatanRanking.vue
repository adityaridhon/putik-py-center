<script setup lang="ts">
interface Props {
    open: boolean;
    message?: string;
}

withDefaults(defineProps<Props>(), {
    message: 'Ranking sudah dipakai. Silakan pilih ranking lain.',
});

const emit = defineEmits(['close']);

const handleClose = () => {
    emit('close');
};
</script>

<template>
    <div
        v-if="open"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
    >
        <div class="w-full max-w-sm rounded-xl bg-white p-6 shadow-xl">
            <h3 class="text-lg font-semibold text-gray-800">Peringatan</h3>

            <p class="mt-2 text-sm text-gray-600">
                {{ message }}
            </p>

            <div class="mt-5 flex justify-end">
                <button
                    type="button"
                    @click="handleClose"
                    class="rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white transition hover:opacity-90"
                >
                    OK
                </button>
            </div>
        </div>
    </div>
</template>
