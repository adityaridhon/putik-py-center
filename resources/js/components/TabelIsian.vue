<script setup lang="ts">
interface Props {
    modelValue?: string[];
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: () => [],
});

const emit = defineEmits(['update:modelValue']);

const updateValue = (index: number, value: string) => {
    const newValue = [...props.modelValue];

    newValue[index] = value;

    emit('update:modelValue', newValue);
};
</script>

<template>
    <div class="overflow-x-auto rounded-xl border">
        <table class="w-full min-w-[520px] border-collapse">
            <thead class="bg-gray-100 text-xs sm:text-sm">
                <tr>
                    <th class="w-16 border p-2">No</th>
                    <th class="border p-2">Tuliskan Pekerjaan</th>
                </tr>
            </thead>

            <tbody class="text-xs sm:text-sm">
                <tr v-for="n in 3" :key="n">
                    <td class="border text-center">
                        {{ n }}
                    </td>

                    <td class="border p-2">
                        <input
                            type="text"
                            class="w-full rounded border px-3 py-2 text-xs sm:text-sm"
                            :placeholder="'Pekerjaan ' + n"
                            :value="modelValue[n - 1]"
                            @input="
                                updateValue(
                                    n - 1,
                                    ($event.target as HTMLInputElement).value,
                                )
                            "
                        />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
