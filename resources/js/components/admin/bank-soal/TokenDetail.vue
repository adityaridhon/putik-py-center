<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import { useClipboard } from '@vueuse/core';
import { Calendar, Check, Copy, FileText, Hash } from 'lucide-vue-next';
import { ref } from 'vue';

// Dummy data for demonstration
const tokenData = ref({
    test_type: 'Tes Gaya Belajar',
    token_count: 5,
    expiry_date: '15/01/2026',
    notes: 'Kelas 10A - SMA Negeri 1 Jakarta',
    created_at: '25/02/2026',
});

// Generate dummy tokens
const tokens = ref([
    { id: 1, code: 'TGB-2026-A1B2C3D4', status: 'available', used_by: null },
    { id: 2, code: 'TGB-2026-E5F6G7H8', status: 'available', used_by: null },
    {
        id: 3,
        code: 'TGB-2026-I9J0K1L2',
        status: 'used',
        used_by: 'Ahmad Rizki',
    },
    { id: 4, code: 'TGB-2026-M3N4O5P6', status: 'available', used_by: null },
    { id: 5, code: 'TGB-2026-Q7R8S9T0', status: 'available', used_by: null },
]);

const { copy, copied, isSupported } = useClipboard();
const copiedTokenId = ref<number | null>(null);

const copyToken = async (tokenCode: string, tokenId: number) => {
    await copy(tokenCode);
    copiedTokenId.value = tokenId;
    setTimeout(() => {
        copiedTokenId.value = null;
    }, 2000);
};

const getStatusBadge = (status: string) => {
    return status === 'available'
        ? 'bg-green-100 text-green-800 hover:bg-green-100'
        : 'bg-gray-100 text-gray-800 hover:bg-gray-100';
};

const getStatusText = (status: string) => {
    return status === 'available' ? 'Tersedia' : 'Terpakai';
};
</script>

<template>
    <div class="space-y-6">
        <!-- Summary Information -->
        <Card>
            <CardHeader>
                <CardTitle class="text-lg">Informasi Token</CardTitle>
            </CardHeader>
            <CardContent class="space-y-4">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="space-y-2">
                        <Label class="text-sm text-muted-foreground"
                            >Jenis Tes</Label
                        >
                        <p class="font-medium">{{ tokenData.test_type }}</p>
                    </div>
                    <div class="space-y-2">
                        <Label class="text-sm text-muted-foreground"
                            >Jumlah Token</Label
                        >
                        <p class="font-medium">
                            {{ tokenData.token_count }} Token
                        </p>
                    </div>
                    <div class="space-y-2">
                        <Label class="text-sm text-muted-foreground"
                            >Masa Berlaku</Label
                        >
                        <div class="flex items-center gap-2">
                            <Calendar class="h-4 w-4 text-muted-foreground" />
                            <p class="font-medium">
                                {{ tokenData.expiry_date }}
                            </p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <Label class="text-sm text-muted-foreground"
                            >Tanggal Dibuat</Label
                        >
                        <div class="flex items-center gap-2">
                            <Calendar class="h-4 w-4 text-muted-foreground" />
                            <p class="font-medium">
                                {{ tokenData.created_at }}
                            </p>
                        </div>
                    </div>
                </div>
                <div v-if="tokenData.notes" class="space-y-2 border-t pt-2">
                    <Label class="text-sm text-muted-foreground">Catatan</Label>
                    <div class="flex items-center gap-2">
                        <FileText class="h-4 w-4 text-muted-foreground" />
                        <p class="font-medium">{{ tokenData.notes }}</p>
                    </div>
                </div>
            </CardContent>
        </Card>

        <!-- Tokens List -->
        <Card>
            <CardHeader>
                <div class="flex items-center justify-between">
                    <CardTitle class="text-lg">Daftar Token</CardTitle>
                    <Badge variant="secondary">
                        {{
                            tokens.filter((t) => t.status === 'available')
                                .length
                        }}
                        / {{ tokens.length }} Tersedia
                    </Badge>
                </div>
            </CardHeader>
            <CardContent>
                <div class="space-y-3">
                    <div
                        v-for="token in tokens"
                        :key="token.id"
                        class="flex items-center justify-between rounded-lg border bg-card p-4 transition-colors hover:bg-accent/50"
                    >
                        <div class="flex flex-1 items-center gap-4">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10"
                            >
                                <Hash class="h-5 w-5 text-primary" />
                            </div>
                            <div class="flex-1 space-y-1">
                                <p class="font-mono text-sm font-semibold">
                                    {{ token.code }}
                                </p>
                                <div class="flex items-center gap-2">
                                    <Badge
                                        :class="getStatusBadge(token.status)"
                                    >
                                        {{ getStatusText(token.status) }}
                                    </Badge>
                                    <span
                                        v-if="token.used_by"
                                        class="text-xs text-muted-foreground"
                                    >
                                        Digunakan oleh: {{ token.used_by }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <Button
                            v-if="isSupported"
                            variant="outline"
                            size="sm"
                            @click="copyToken(token.code, token.id)"
                            :class="
                                copiedTokenId === token.id
                                    ? 'border-green-500 text-green-600'
                                    : ''
                            "
                        >
                            <Check
                                v-if="copiedTokenId === token.id"
                                class="mr-2 h-4 w-4"
                            />
                            <Copy v-else class="mr-2 h-4 w-4" />
                            {{
                                copiedTokenId === token.id
                                    ? 'Tersalin'
                                    : 'Salin'
                            }}
                        </Button>
                    </div>
                </div>
            </CardContent>
        </Card>
    </div>
</template>
