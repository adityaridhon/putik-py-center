<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import PageHeader from '@/components/PageHeader.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { bankSoal } from '@/routes';
import { update } from '@/routes/bankSoal';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';

const page = usePage()
const batch = page.props.batch as any

const form = useForm({
    test_type: batch.test_type,
    expired_at: batch.expired_at,
    note: batch.note || '',
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Bank Soal',
        href: bankSoal().url,
    },
    {
        title: 'Edit Token',
        href: '#',
    },
];

const handleSubmit = () => {
    form.put(update(batch).url, {
        onError: () => {
            alert('Gagal memperbarui batch');
        },
    });
};
</script>

<template>
    <Head title="Edit Token Bank Soal" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <PageHeader
            title="Edit Token Bank Soal"
            description="Ubah informasi batch token."
            :back-url="bankSoal().url"
        />

        <!-- Form -->
        <div class="p-6">
            <div class="mx-auto max-w-2xl">
                <form @submit.prevent="handleSubmit" class="space-y-6">
                    <!-- Pilih Tes -->
                    <div class="space-y-3">
                        <Label class="text-base font-semibold">Jenis Tes</Label>
                        <RadioGroup v-model="form.test_type" class="space-y-2">
                            <div class="flex items-center space-x-2">
                                <RadioGroupItem value="minat-bakat" id="minat-bakat" />
                                <Label
                                    for="minat-bakat"
                                    class="cursor-pointer font-normal"
                                >
                                    Tes Minat Bakat
                                </Label>
                            </div>
                            <div class="flex items-center space-x-2">
                                <RadioGroupItem value="intelegensi" id="intelegensi" />
                                <Label
                                    for="intelegensi"
                                    class="cursor-pointer font-normal"
                                >
                                    Tes Intelegensi
                                </Label>
                            </div>
                            <div class="flex items-center space-x-2">
                                <RadioGroupItem
                                    value="gaya-belajar"
                                    id="gaya-belajar"
                                />
                                <Label
                                    for="gaya-belajar"
                                    class="cursor-pointer font-normal"
                                >
                                    Tes Gaya Belajar
                                </Label>
                            </div>
                        </RadioGroup>
                    </div>

                    <!-- Masa Berlaku -->
                    <div class="space-y-2">
                        <Label for="expired-at" class="text-base font-semibold">
                            Masa Berlaku
                        </Label>
                        <Input
                            id="expired-at"
                            v-model="form.expired_at"
                            type="date"
                            required
                        />
                    </div>

                    <!-- Catatan (Opsional) -->
                    <div class="space-y-2">
                        <Label for="note" class="text-base font-semibold">
                            Catatan (Opsional)
                        </Label>
                        <Input
                            id="note"
                            v-model="form.note"
                            type="text"
                            placeholder="Nama kelas/Institusi"
                        />
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end gap-3">
                        <Link :href="bankSoal().url">
                            <Button type="button" variant="outline">
                                Batal
                            </Button>
                        </Link>
                        <Button type="submit" :disabled="form.processing">
                            Simpan Perubahan
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
