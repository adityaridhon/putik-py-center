<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import { store } from '@/routes/bankSoal';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    test_type: '',
    total_tokens: 5,
    expired_at: '',
    note: '',
});

const handleSubmit = () => {
    form.post(store().url, {
        onError: () => {
            alert('Gagal membuat token');
        },
    });
};
</script>

<template>
    <div class="space-y-6">
        <form @submit.prevent="handleSubmit" class="space-y-6">
            <!-- Pilih Tes -->
            <div class="space-y-3">
                <Label class="text-base font-semibold">Pilih Tes</Label>
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

            <!-- Jumlah Token -->
            <div class="space-y-2">
                <Label for="total-tokens" class="text-base font-semibold">
                    Jumlah Token
                </Label>
                <Input
                    id="total-tokens"
                    v-model.number="form.total_tokens"
                    type="number"
                    min="1"
                    placeholder="5"
                    required
                />
                <p class="text-sm text-muted-foreground">
                    Jumlah Token yang akan dibuat (1 token = 1 peserta)
                </p>
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
            <div class="flex justify-end">
                <Button type="submit" :disabled="form.processing">
                    Generate Token
                </Button>
            </div>
        </form>
    </div>
</template>
