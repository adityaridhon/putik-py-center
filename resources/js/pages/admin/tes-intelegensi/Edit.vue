<script setup lang="ts">
import QuestionCreator from '@/components/admin/tes-intelegensi/QuestionCreator.vue';
import SubtestEditForm from '@/components/admin/tes-intelegensi/SubtestEditForm.vue';
import PageHeader from '@/components/PageHeader.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import Label from '@/components/ui/label/Label.vue';
import {
    useQuestionManagement,
    type Category,
    type QuestionsData,
} from '@/composables/useQuestionManagement';
import AppLayout from '@/layouts/AppLayout.vue';
import { intelegensi } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Loader2, Save } from 'lucide-vue-next';
import { onMounted } from 'vue';

interface Props {
    category: Category;
    questions: QuestionsData;
}

const props = defineProps<Props>();

const {
    localQuestions,
    deletedQuestionIds,
    isLoadingQuestions,
    numberOfQuestions,
    isSaving,
    questionType,
    isImageType,
    existingQuestionsCount,
    newQuestionsCount,
    modifiedQuestionsCount,
    deletedQuestionsCount,
    hasChanges,
    validQuestionsCount,
    isGenerateDisabled,
    loadExistingQuestions,
    generateQuestions,
    incrementQuestions,
    decrementQuestions,
    handleQuestionDelete,
    saveQuestions,
    getAnswerTypeLabel,
} = useQuestionManagement(props.category, props.questions);

// Load questions
onMounted(() => {
    loadExistingQuestions();
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Manajemen Tes Intelegensi',
        href: intelegensi.url(),
    },
    {
        title: `Edit ${props.category.name}`,
        href: '#',
    },
];
</script>

<template>
    <Head :title="`Edit ${category.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <PageHeader
            :title="`Edit ${category.name}`"
            :back-url="'/admin/asesmen/intelegensi'"
        />
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <!-- Heading -->
            <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <h1 class="text-2xl font-bold">
                        {{ category.code }} - {{ category.name }}
                    </h1>
                    <p class="text-sm text-gray-600">
                        {{ category.description || 'Tidak ada deskripsi' }}
                    </p>
                    <div class="flex items-center gap-3 text-sm">
                        <span class="text-gray-500">
                            {{ getAnswerTypeLabel() }}
                        </span>
                        <span class="text-gray-500">
                            Durasi: {{ category.duration_minutes }} menit
                        </span>
                        <span class="text-gray-500">
                            Target: {{ category.total_questions }} soal
                        </span>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="space-y-6">
                <SubtestEditForm />

                <!-- Bulk Question Creator -->
                <div
                    v-if="localQuestions.length === 0 && !isLoadingQuestions"
                    class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm"
                >
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                Buat Soal Tes Intelegensi
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Masukkan jumlah soal yang ingin dibuat, sistem
                                akan otomatis membuat form input untuk semua
                                soal sekaligus.
                            </p>
                        </div>

                        <div class="flex-col justify-center gap-4">
                            <div class="mx-auto max-w-xl space-y-2 text-center">
                                <Label
                                    for="question-count"
                                    class="justify-center"
                                >
                                    Jumlah Soal yang Akan Dibuat
                                </Label>
                                <div
                                    class="mx-auto flex w-40 items-center justify-center gap-2"
                                >
                                    <Button
                                        type="button"
                                        class="bg-red-500 hover:bg-red-600"
                                        size="icon"
                                        @click="decrementQuestions"
                                        :disabled="
                                            Number(numberOfQuestions) <= 1 ||
                                            !numberOfQuestions
                                        "
                                    >
                                        <span class="text-xl font-bold">−</span>
                                    </Button>
                                    <Input
                                        id="question-count"
                                        v-model="numberOfQuestions"
                                        min="1"
                                        max="50"
                                        placeholder="0"
                                        class="text-center text-2xl font-semibold"
                                        @keypress.enter="generateQuestions"
                                    />
                                    <Button
                                        type="button"
                                        size="icon"
                                        class="bg-green-500 hover:bg-green-600"
                                        @click="incrementQuestions"
                                        :disabled="
                                            Number(numberOfQuestions) >= 50
                                        "
                                    >
                                        <span class="text-xl font-bold">+</span>
                                    </Button>
                                </div>
                                <p class="text-xs text-gray-500">
                                    Minimal 1, maksimal 50 soal per batch
                                </p>
                            </div>
                            <div class="mt-4 flex justify-center">
                                <Button
                                    @click="generateQuestions"
                                    :disabled="isGenerateDisabled"
                                >
                                    Generate {{ numberOfQuestions || 0 }} Soal
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loading State -->
                <div
                    v-if="isLoadingQuestions"
                    class="flex flex-col items-center justify-center rounded-lg border border-gray-200 bg-white p-12"
                >
                    <Loader2 class="h-8 w-8 animate-spin text-blue-600" />
                    <p class="mt-4 text-sm text-gray-600">
                        Memuat soal yang sudah ada...
                    </p>
                </div>

                <!-- Question Creator -->
                <div
                    v-if="localQuestions.length > 0 && !isLoadingQuestions"
                    class="space-y-6"
                >
                    <QuestionCreator
                        v-model="localQuestions"
                        :question-type="questionType"
                        :subtest-name="category.name"
                        :is-image-type="isImageType"
                        @delete-question="handleQuestionDelete"
                    />

                    <!-- Save Button Section -->
                    <div
                        v-if="
                            localQuestions.length > 0 ||
                            deletedQuestionsCount > 0
                        "
                        class="sticky bottom-0 z-10 mt-6 rounded-lg border border-gray-200 bg-white p-6 shadow-lg"
                    >
                        <div class="flex items-center justify-between">
                            <div class="space-y-1">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    Simpan Perubahan
                                </h3>
                                <div
                                    class="flex flex-wrap gap-2 text-sm text-gray-600"
                                >
                                    <span
                                        v-if="existingQuestionsCount > 0"
                                        class="text-blue-600"
                                    >
                                        {{ existingQuestionsCount }} soal
                                        tersimpan
                                    </span>
                                    <span
                                        v-if="newQuestionsCount > 0"
                                        class="text-green-600"
                                    >
                                        • {{ newQuestionsCount }} soal baru
                                    </span>
                                    <span
                                        v-if="modifiedQuestionsCount > 0"
                                        class="text-orange-600"
                                    >
                                        • {{ modifiedQuestionsCount }} soal
                                        diubah
                                    </span>
                                    <span
                                        v-if="deletedQuestionsCount > 0"
                                        class="text-red-600"
                                    >
                                        • {{ deletedQuestionsCount }} soal
                                        dihapus
                                    </span>
                                    <span
                                        v-if="!hasChanges"
                                        class="text-gray-500"
                                    >
                                        • Tidak ada perubahan
                                    </span>
                                </div>
                            </div>
                            <Button
                                @click="saveQuestions"
                                :disabled="isSaving || !hasChanges"
                                size="lg"
                                class="min-w-[200px]"
                            >
                                <Loader2
                                    v-if="isSaving"
                                    class="mr-2 h-5 w-5 animate-spin"
                                />
                                <Save v-else class="mr-2 h-5 w-5" />
                                {{
                                    isSaving
                                        ? 'Menyimpan...'
                                        : hasChanges
                                          ? 'Simpan Perubahan'
                                          : 'Tidak Ada Perubahan'
                                }}
                            </Button>
                        </div>

                        <!-- Validation Info -->
                        <div
                            v-if="
                                hasChanges &&
                                validQuestionsCount <
                                    newQuestionsCount + modifiedQuestionsCount
                            "
                            class="mt-4 rounded-lg border border-yellow-200 bg-yellow-50 p-3"
                        >
                            <p class="text-sm text-yellow-800">
                                <span class="font-semibold"
                                    >{{
                                        newQuestionsCount +
                                        modifiedQuestionsCount -
                                        validQuestionsCount
                                    }}
                                    soal</span
                                >
                                belum lengkap. Pastikan semua pertanyaan, opsi,
                                dan jawaban benar sudah terisi.
                            </p>
                        </div>

                        <!-- Success Indicator -->
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
