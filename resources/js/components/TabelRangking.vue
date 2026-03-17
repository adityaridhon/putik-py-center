<script setup lang="ts">
import { ref } from 'vue';

import PopupPeringatanRanking from '@/components/PopupPeringatanRanking.vue';

interface Props {
    pekerjaan: string[];
    modelValue: number[];
}

const props = defineProps<Props>();

const emit = defineEmits(['update:modelValue']);

const isPopupOpen = ref(false);

const updateValue = (index: number, value: number) => {
    const newValue = [...props.modelValue];

    // cek duplikat ranking
    if (newValue.includes(value) && newValue[index] !== value) {
        isPopupOpen.value = true;
        return;
    }

    newValue[index] = value;

    emit('update:modelValue', newValue);
};

const closePopup = () => {
    isPopupOpen.value = false;
};
</script>

<template>
    <div class="py-4">
        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="w-16 border p-2">No</th>
                    <th class="border p-2">Pekerjaan</th>
                    <th class="w-40 border p-2">Peringkat (1-12)</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="(item, index) in pekerjaan" :key="index">
                    <td class="border text-center">{{ index + 1 }}</td>

                    <td class="border p-2">
                        {{ item }}
                    </td>

                    <td class="border text-center">
                        <select
                            class="rounded border px-2 py-1"
                            :value="modelValue[index]"
                            @change="
                                updateValue(
                                    index,
                                    Number(
                                        ($event.target as HTMLSelectElement)
                                            .value,
                                    ),
                                )
                            "
                        >
                            <option value="">...</option>

                            <option v-for="n in 12" :key="n" :value="n">
                                {{ n }}
                            </option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>

        <PopupPeringatanRanking :open="isPopupOpen" @close="closePopup" />
    </div>
</template>
