<script setup lang="ts">
import QuestionCreator from '@/components/admin/tes-intelegensi/QuestionCreator.vue';
import SubtestEditForm from '@/components/admin/tes-intelegensi/SubtestEditForm.vue';
import PageHeader from '@/components/PageHeader.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { intelegensi } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

interface Question {
    id: string;
    question: string;
    type: 'multiple_choice' | 'short_answer' | 'number_input';
    options?: string[];
    correctAnswer?: string | number[];
    shortAnswer?: string;
}

// Current subtest data (in real app would come from route params/props)
const currentSubtest = ref({
    id: 'SE',
    name: 'SE - Spatial Enhancement',
    description: 'Tes kemampuan spasial dan orientasi ruang',
});

// Questions for current subtest
const questions = ref<Question[]>([]);

// Selected question type for this subtest
const selectedQuestionType = ref<
    'multiple_choice' | 'short_answer' | 'number_input'
>('');

// Available question types
const questionTypes = [
    {
        value: 'multiple_choice',
        label: 'Pilihan Ganda (A-E)',
        icon: '🔘',
        description: '5 pilihan A-E dengan 1 jawaban benar',
    },
    {
        value: 'short_answer',
        label: 'Isian Singkat',
        icon: '✏️',
        description: 'Input teks bebas untuk jawaban singkat',
    },
    {
        value: 'number_input',
        label: 'Input Angka (0-9)',
        icon: '🔢',
        description: 'Klik angka 0-9 untuk membentuk jawaban',
    },
];

// Select question type and reset questions
const selectQuestionType = (
    type: 'multiple_choice' | 'short_answer' | 'number_input',
) => {
    selectedQuestionType.value = type;
    // Reset questions when type changes
    questions.value = [];
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Manajemen Tes Intelegensi',
        href: intelegensi().url,
    },
    {
        title: `Edit ${currentSubtest.value.name}`,
        href: '#',
    },
];
</script>

<template>
    <Head :title="`Edit ${currentSubtest.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <PageHeader
            :title="`Edit ${currentSubtest.name}`"
            :back-url="intelegensi().url"
        />
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <!-- Heading -->
            <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <h1 class="text-2xl font-bold">
                        Edit {{ currentSubtest.name }}
                    </h1>
                    <p class="text-sm text-gray-600">
                        {{ currentSubtest.description }}
                    </p>
                </div>
            </div>
            <!-- Content -->
            <div class="space-y-6">
                <SubtestEditForm />

                <!-- Question Type Selection -->
                <div class="rounded-lg border border-gray-200 bg-white p-6">
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                Pilih Tipe Jawaban untuk
                                {{ currentSubtest.name }}
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Pilih format jawaban yang akan digunakan untuk
                                semua soal di subtest ini.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                            <button
                                v-for="questionType in questionTypes"
                                :key="questionType.value"
                                @click="
                                    selectQuestionType(
                                        questionType.value as
                                            | 'multiple_choice'
                                            | 'short_answer'
                                            | 'number_input',
                                    )
                                "
                                :class="[
                                    'relative rounded-lg border-2 p-4 text-left transition-all hover:border-blue-300',
                                    selectedQuestionType === questionType.value
                                        ? 'border-blue-500 bg-blue-50 ring-1 ring-blue-500'
                                        : 'border-gray-200 hover:bg-gray-50',
                                ]"
                                type="button"
                            >
                                <div class="flex items-center gap-3">
                                    <span class="text-2xl">{{
                                        questionType.icon
                                    }}</span>
                                    <div>
                                        <p class="font-medium text-gray-900">
                                            {{ questionType.label }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ questionType.description }}
                                        </p>
                                    </div>
                                </div>
                                <div
                                    v-if="
                                        selectedQuestionType ===
                                        questionType.value
                                    "
                                    class="absolute -top-1 -right-1 rounded-full bg-blue-500 p-1.5"
                                >
                                    <svg
                                        class="h-3 w-3 text-white"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="3"
                                            d="M5 13l4 4L19 7"
                                        />
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Question Creator (only show when question type is selected) -->
                <div v-if="selectedQuestionType" class="border-t pt-6">
                    <QuestionCreator
                        v-model="questions"
                        :question-type="selectedQuestionType"
                        :subtest-name="currentSubtest.name"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
