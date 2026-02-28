<script setup lang="ts">

interface FormData {
  nama: string
  hp: string
  email: string
  topik?: string
}

const props = defineProps<{
  form: FormData
  kategori: string
  layanan?: string
  opsi?: string
  perusahaan?: string
  tanggal: string
  jam: string
}>()

</script>

<template>
  <div class="border rounded p-6 bg-gray-50 space-y-2">
    <h3 class="font-bold text-lg">Konfirmasi Booking</h3>

    <p><b>Nama:</b> {{ props.form.nama }}</p>
    <p><b>HP:</b> {{ props.form.hp }}</p>
    <p><b>Email:</b> {{ props.form.email }}</p>
    <p><b>Kategori:</b> {{ props.kategori }}</p>

    <p v-if="props.layanan">
      <b>Layanan:</b> {{ props.layanan }}
    </p>

    <p v-if="props.opsi">
      <b>Opsi:</b> {{ props.opsi }}
    </p>

    <p v-if="props.perusahaan">
      <b>Perusahaan:</b> {{ props.perusahaan }}
    </p>

    <p><b>Tanggal:</b> {{ props.tanggal }}</p>
    <p><b>Jam:</b> {{ props.jam }}</p>

    <button class="bg-green-700 text-white px-4 py-2 rounded mt-4">
      WhatsApp
    </button>
  </div>
</template>