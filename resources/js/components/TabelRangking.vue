<script setup lang="ts">
import { ref } from 'vue';

import PopupPeringatanRanking from '@/components/PopupPeringatanRanking.vue';

interface Props {
    pekerjaan: string[];
    modelValue: Array<number | null>;
}

const props = defineProps<Props>();

const emit = defineEmits(['update:modelValue']);

const isPopupOpen = ref(false);

const parseRankingValue = (rawValue: string): number | null => {
    if (rawValue === '') {
        return null;
    }

    const parsed = Number(rawValue);

    if (!Number.isInteger(parsed) || parsed < 1 || parsed > 12) {
        return null;
    }

    return parsed;
};

const updateValue = (index: number, value: number | null) => {
    const newValue = [...props.modelValue];

    // Cek duplikat hanya untuk nilai ranking yang terisi.
    if (
        value !== null &&
        newValue.some(
            (item, itemIndex) => itemIndex !== index && item === value,
        )
    ) {
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
        <div class="space-y-3 md:hidden">
            <div
                v-for="(item, index) in pekerjaan"
                :key="index"
                class="rounded-xl border bg-white p-4 shadow-sm"
            >
                <div class="mb-3 flex items-start justify-between gap-3">
                    <p class="text-sm leading-relaxed text-gray-800">
                        <span class="font-semibold">{{ index + 1 }}.</span>
                        {{ item }}
                    </p>

                    <select
                        class="shrink-0 rounded border px-2 py-1 text-sm"
                        :value="modelValue[index] ?? ''"
                        @change="
                            updateValue(
                                index,
                                parseRankingValue(
                                    ($event.target as HTMLSelectElement).value,
                                ),
                            )
                        "
                    >
                        <option value="">...</option>
                        <option v-for="n in 12" :key="n" :value="n">
                            {{ n }}
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <div class="hidden overflow-x-auto rounded-xl border md:block">
            <table class="w-full min-w-[560px] border-collapse">
                <thead class="bg-gray-100 text-xs sm:text-sm">
                    <tr>
                        <th class="w-16 border p-2">No</th>
                        <th class="border p-2">Pekerjaan</th>
                        <th class="w-40 border p-2">Peringkat (1-12)</th>
                    </tr>
                </thead>

                <tbody class="text-xs sm:text-sm">
                    <tr v-for="(item, index) in pekerjaan" :key="index">
                        <td class="border text-center">{{ index + 1 }}</td>

                        <td class="border p-2 leading-relaxed">
                            {{ item }}
                        </td>

                        <td class="border text-center">
                            <select
                                class="rounded border px-2 py-1 text-xs sm:text-sm"
                                :value="modelValue[index] ?? ''"
                                @change="
                                    updateValue(
                                        index,
                                        parseRankingValue(
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
        </div>

        <PopupPeringatanRanking :open="isPopupOpen" @close="closePopup" />
    </div>
</template>
