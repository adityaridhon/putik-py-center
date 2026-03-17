<script setup lang="ts">

interface Props {
  modelValue?: string[]
}

const props = withDefaults(defineProps<Props>(), {
  modelValue: () => [],
})

const emit = defineEmits(["update:modelValue"])

const updateValue = (index:number,value:string)=>{

const newValue = [...props.modelValue]

newValue[index] = value

emit("update:modelValue",newValue)

}

</script>

<template>

<table class="w-full border">

<thead class="bg-gray-100">

<tr>
<th class="border p-2 w-16">No</th>
<th class="border p-2">Tuliskan Pekerjaan</th>
</tr>

</thead>

<tbody>

<tr v-for="n in 3" :key="n">

<td class="border text-center">
{{ n }}
</td>

<td class="border p-2">

<input
type="text"
class="w-full border px-3 py-2 rounded"
:placeholder="'Pekerjaan '+n"
:value="modelValue[n-1]"
@input="updateValue(n-1, ($event.target as HTMLInputElement).value)"
/>

</td>

</tr>

</tbody>

</table>

</template>