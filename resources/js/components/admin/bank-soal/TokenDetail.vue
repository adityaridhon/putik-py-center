<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import { useClipboard } from '@vueuse/core';
import { Calendar, Check, Copy, FileText, Hash } from 'lucide-vue-next';
import { ref, computed, type PropType } from 'vue';

export interface TestToken {
    id: number;
    token: string;
    is_used: boolean;
    used_at?: string | null;
}

export interface TestTokenBatch {
    id: number;
    test_type: string;
    total_tokens: number;
    expired_at: string;
    note?: string;
    created_at?: string;
    tokens?: TestToken[];
}

const props = defineProps({
    batch: {
        type: Object as PropType<TestTokenBatch>,
        required: true,
    },
});

const { copy, copied, isSupported } = useClipboard();
const copiedTokenId = ref<number | null>(null);

const copyToken = async (tokenCode: string, tokenId: number) => {
    await copy(tokenCode);
    copiedTokenId.value = tokenId;
    setTimeout(() => {
        copiedTokenId.value = null;
    }, 2000);
};

const getStatusBadge = (isUsed: boolean) => {
    return isUsed
        ? 'bg-gray-100 text-gray-800 hover:bg-gray-100'
        : 'bg-green-100 text-green-800 hover:bg-green-100';
};

const getStatusText = (isUsed: boolean) => {
    return isUsed ? 'Terpakai' : 'Tersedia';
};

const testTypeLabel: Record<string, string> = {
    'minat-bakat': 'Tes Minat Bakat',
    'intelegensi': 'Tes Intelegensi',
    'gaya-belajar': 'Tes Gaya Belajar',
};

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('id-ID', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
    });
};

const availableTokenCount = computed(() => {
    return props.batch.tokens?.filter(t => !t.is_used).length || 0;
});
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
                        <p class="font-medium">
                            {{ testTypeLabel[batch.test_type] || batch.test_type }}
                        </p>
                    </div>
                    <div class="space-y-2">
                        <Label class="text-sm text-muted-foreground"
                            >Jumlah Token</Label
                        >
                        <p class="font-medium">
                            {{ batch.total_tokens }} Token
                        </p>
                    </div>
                    <div class="space-y-2">
                        <Label class="text-sm text-muted-foreground"
                            >Masa Berlaku</Label
                        >
                        <div class="flex items-center gap-2">
                            <Calendar class="h-4 w-4 text-muted-foreground" />
                            <p class="font-medium">
                                {{ formatDate(batch.expired_at) }}
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
                                {{ formatDate(batch.created_at || '') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div v-if="batch.note" class="space-y-2 border-t pt-2">
                    <Label class="text-sm text-muted-foreground">Catatan</Label>
                    <div class="flex items-center gap-2">
                        <FileText class="h-4 w-4 text-muted-foreground" />
                        <p class="font-medium">{{ batch.note }}</p>
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
                        {{ availableTokenCount }} / {{ batch.total_tokens }} Tersedia
                    </Badge>
                </div>
            </CardHeader>
            <CardContent>
                <div v-if="batch.tokens && batch.tokens.length > 0" class="space-y-3">
                    <div
                        v-for="token in batch.tokens"
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
                                    {{ token.token }}
                                </p>
                                <div class="flex items-center gap-2">
                                    <Badge
                                        :class="getStatusBadge(token.is_used)"
                                    >
                                        {{ getStatusText(token.is_used) }}
                                    </Badge>
                                    <span
                                        v-if="token.used_at"
                                        class="text-xs text-muted-foreground"
                                    >
                                        Digunakan pada: {{ formatDate(token.used_at) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <Button
                            v-if="isSupported"
                            variant="outline"
                            size="sm"
                            @click="copyToken(token.token, token.id)"
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
                <div v-else class="rounded-lg border border-dashed border-gray-300 p-8 text-center dark:border-gray-700">
                    <p class="text-gray-500 dark:text-gray-400">
                        Tidak ada token untuk batch ini.
                    </p>
                </div>
            </CardContent>
        </Card>
    </div>
</template>
