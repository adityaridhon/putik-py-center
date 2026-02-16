<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import Label from '@/components/ui/label/Label.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import {
    useQuestionCreator,
    type Question,
} from '@/composables/useQuestionCreator';
import { Check, ImagePlus, Plus, Trash2, X } from 'lucide-vue-next';
import { ref, watch } from 'vue';

interface Props {
    modelValue?: Question[];
    questionType: 'multiple_choice' | 'short_answer' | 'number_input';
    subtestName?: string;
    isImageType?: boolean;
}

interface Emits {
    (e: 'update:modelValue', value: Question[]): void;
    (e: 'delete-question', questionId: string): void;
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const questions = ref<Question[]>(props.modelValue || []);

// Watch for model value changes from parent
watch(
    () => props.modelValue,
    (newValue) => {
        if (newValue) {
            questions.value = newValue;
        }
    },
);

// Use composable for all question creator logic
const {
    addQuestion,
    removeQuestion,
    updateModelValue,
    markAsModified,
    toggleNumber,
    isNumberSelected,
    getSelectedNumbers,
    handleQuestionImageUpload,
    handleOptionImageUpload,
    removeQuestionImage,
    removeOptionImage,
    getQuestionTypeLabel,
} = useQuestionCreator({
    questions,
    questionType: props.questionType,
    isImageType: props.isImageType,
    onUpdate: (updatedQuestions) => {
        emit('update:modelValue', updatedQuestions);
    },
    onDelete: (questionId) => {
        emit('delete-question', questionId);
    },
});

// Wrapper to handle input changes and mark as modified
const handleInputChange = (questionIndex: number) => {
    markAsModified(questionIndex);
    updateModelValue();
};
</script>

<template>
    <div class="space-y-6">
        <div class="space-y-2">
            <h2 class="text-lg font-semibold">
                Manajemen Soal{{
                    props.subtestName ? ` - ${props.subtestName}` : ''
                }}
            </h2>
        </div>
        <div
            v-if="questions.length > 0"
            class="rounded-lg border border-blue-200 bg-blue-50 p-4"
        >
            <h3 class="mb-2 font-medium text-blue-900">Ringkasan</h3>
            <div class="space-y-1 text-sm text-blue-800">
                <p>
                    Total soal:
                    <span class="font-semibold">{{ questions.length }}</span>
                </p>
                <p>
                    Tipe soal:
                    <span class="font-semibold">{{
                        getQuestionTypeLabel()
                    }}</span>
                </p>
                <p>
                    Soal siap:
                    <span class="font-semibold text-green-600"
                        >{{
                            questions.filter((q) => q.question.trim() !== '')
                                .length
                        }}/{{ questions.length }}</span
                    >
                </p>
            </div>
        </div>

        <div
            v-if="questions.length === 0"
            class="rounded-lg border-2 border-dashed border-gray-300 py-12 text-center text-gray-500"
        >
            <div class="space-y-3">
                <div class="mx-auto h-12 w-12 text-gray-400">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                    </svg>
                </div>
                <p class="text-lg font-medium">Belum ada soal</p>
                <p class="text-sm">
                    Mulai dengan menambahkan soal pertama untuk subtest ini
                </p>
                <Button @click="addQuestion" class="mt-4">
                    <Plus class="mr-2 h-4 w-4" />
                    Tambah Soal Pertama
                </Button>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div
                v-for="(question, index) in questions"
                :key="question.id"
                class="space-y-4 rounded-lg border border-gray-200 bg-white p-4"
            >
                <!-- Question Header -->
                <div class="flex items-center justify-between">
                    <h3
                        class="rounded-xl bg-primary/80 px-3 py-1.5 font-medium text-white"
                    >
                        {{ index + 1 }}
                    </h3>
                    <Button
                        @click="removeQuestion(index)"
                        variant="outline"
                        size="sm"
                        class="text-red-600 hover:text-red-700"
                    >
                        <Trash2 class="h-4 w-4" />
                    </Button>
                </div>

                <!-- Question Text -->
                <div class="space-y-2">
                    <Label :for="`question-${question.id}`">Pertanyaan</Label>
                    <Textarea
                        v-if="!props.isImageType"
                        :id="`question-${question.id}`"
                        v-model="question.question"
                        placeholder="Masukkan pertanyaan..."
                        class="resize-none"
                        rows="3"
                        @input="handleInputChange(index)"
                    />
                    <Input
                        v-else
                        :id="`question-${question.id}`"
                        v-model="question.question"
                        placeholder="Masukkan deskripsi soal (opsional)..."
                        @input="handleInputChange(index)"
                    />
                </div>

                <!-- Question Image Upload (for image type) -->
                <div v-if="props.isImageType" class="space-y-2">
                    <Label>Gambar Soal</Label>
                    <div
                        v-if="!question.questionImagePreview"
                        class="flex items-center gap-3"
                    >
                        <label
                            :for="`question-image-${question.id}`"
                            class="flex cursor-pointer items-center gap-2 rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 px-4 py-3 transition-colors hover:border-blue-400 hover:bg-blue-50"
                        >
                            <ImagePlus class="h-5 w-5 text-gray-600" />
                            <span class="text-sm font-medium text-gray-700"
                                >Upload Gambar Soal</span
                            >
                            <input
                                :id="`question-image-${question.id}`"
                                type="file"
                                accept="image/*"
                                class="hidden"
                                @change="
                                    handleQuestionImageUpload(index, $event)
                                "
                            />
                        </label>
                    </div>
                    <div v-else class="relative inline-block">
                        <img
                            :src="question.questionImagePreview"
                            alt="Preview soal"
                            class="h-40 w-auto rounded-lg border border-gray-300 object-contain"
                        />
                        <button
                            @click="removeQuestionImage(index)"
                            class="absolute -top-2 -right-2 rounded-full bg-red-500 p-1 text-white shadow-lg hover:bg-red-600"
                            type="button"
                        >
                            <X class="h-4 w-4" />
                        </button>
                    </div>
                </div>

                <!-- Multiple Choice Options -->
                <div
                    v-if="props.questionType === 'multiple_choice'"
                    class="space-y-2"
                >
                    <Label>Pilihan Jawaban</Label>
                    <div class="space-y-3">
                        <div
                            v-for="(option, optionIndex) in question.options"
                            :key="optionIndex"
                            :class="[
                                'rounded-lg border p-2 transition-colors',
                                question.correctAnswer ===
                                String.fromCharCode(65 + optionIndex)
                                    ? 'border-green-400 bg-green-50'
                                    : 'border-gray-200 bg-white',
                            ]"
                        >
                            <div class="flex items-start gap-3">
                                <label
                                    class="flex cursor-pointer items-center gap-2 pt-2"
                                >
                                    <input
                                        type="radio"
                                        :name="`correct-${question.id}`"
                                        :value="
                                            String.fromCharCode(
                                                65 + optionIndex,
                                            )
                                        "
                                        v-model="question.correctAnswer"
                                        @change="handleInputChange(index)"
                                        class="text-green-600"
                                    />
                                    <span class="w-8 font-medium text-gray-700"
                                        >{{
                                            String.fromCharCode(
                                                65 + optionIndex,
                                            )
                                        }}.</span
                                    >
                                </label>
                                <div class="flex-1 space-y-2">
                                    <Input
                                        v-if="!props.isImageType"
                                        v-model="question.options![optionIndex]"
                                        :placeholder="`Opsi ${String.fromCharCode(65 + optionIndex)}`"
                                        class="flex-1"
                                        @input="handleInputChange(index)"
                                    />
                                    <Input
                                        v-else
                                        v-model="question.options![optionIndex]"
                                        :placeholder="`Label opsi ${String.fromCharCode(65 + optionIndex)} (opsional)`"
                                        class="flex-1"
                                        @input="handleInputChange(index)"
                                    />

                                    <!-- Option Image Upload (for image type) -->
                                    <div v-if="props.isImageType">
                                        <div
                                            v-if="
                                                !question.optionImagePreviews?.[
                                                    optionIndex
                                                ]
                                            "
                                            class="flex items-center gap-2"
                                        >
                                            <label
                                                :for="`option-image-${question.id}-${optionIndex}`"
                                                class="flex cursor-pointer items-center gap-2 rounded-lg border border-dashed border-gray-300 bg-gray-50 px-3 py-2 text-sm transition-colors hover:border-blue-400 hover:bg-blue-50"
                                            >
                                                <ImagePlus
                                                    class="h-4 w-4 text-gray-600"
                                                />
                                                <span class="text-gray-700"
                                                    >Upload Gambar</span
                                                >
                                                <input
                                                    :id="`option-image-${question.id}-${optionIndex}`"
                                                    type="file"
                                                    accept="image/*"
                                                    class="hidden"
                                                    @change="
                                                        handleOptionImageUpload(
                                                            index,
                                                            optionIndex,
                                                            $event,
                                                        )
                                                    "
                                                />
                                            </label>
                                        </div>
                                        <div
                                            v-else
                                            class="relative inline-block"
                                        >
                                            <img
                                                :src="
                                                    question
                                                        .optionImagePreviews[
                                                        optionIndex
                                                    ]!
                                                "
                                                :alt="`Preview opsi ${String.fromCharCode(65 + optionIndex)}`"
                                                class="h-24 w-auto rounded-lg border border-gray-300 object-contain"
                                            />
                                            <button
                                                @click="
                                                    removeOptionImage(
                                                        index,
                                                        optionIndex,
                                                    )
                                                "
                                                class="absolute -top-1 -right-1 rounded-full bg-red-500 p-1 text-white shadow-lg hover:bg-red-600"
                                                type="button"
                                            >
                                                <X class="h-3 w-3" />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600">
                        Jawaban yang benar:
                        <span
                            v-if="question.correctAnswer"
                            class="font-medium text-green-600"
                            >{{ question.correctAnswer }}</span
                        >
                        <span v-else class="text-gray-400">Belum dipilih</span>
                    </p>
                </div>

                <!-- Short Answer -->
                <div
                    v-if="props.questionType === 'short_answer'"
                    class="space-y-2"
                >
                    <Label :for="`answer-${question.id}`"
                        >Jawaban yang Diharapkan</Label
                    >
                    <Input
                        :id="`answer-${question.id}`"
                        v-model="question.shortAnswer"
                        placeholder="Masukkan jawaban yang diharapkan..."
                        @input="handleInputChange(index)"
                    />
                    <p class="text-xs text-gray-500">
                        Jawaban ini akan digunakan sebagai referensi untuk
                        penilaian
                    </p>
                </div>

                <!-- Number Input -->
                <div
                    v-if="props.questionType === 'number_input'"
                    class="space-y-3"
                >
                    <Label>Pilih Angka Jawaban (1-10)</Label>
                    <p class="text-sm text-gray-600">
                        Klik angka yang merupakan jawaban yang benar:
                    </p>

                    <!-- Number Grid -->
                    <div class="flex justify-center gap-2">
                        <button
                            v-for="number in [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]"
                            :key="number"
                            @click="toggleNumber(index, number)"
                            :class="[
                                'h-12 w-12 rounded-lg border-2 font-semibold transition-all',
                                isNumberSelected(index, number)
                                    ? 'border-blue-500 bg-blue-500 text-white shadow-lg'
                                    : 'border-gray-300 bg-white text-gray-700 hover:border-blue-300 hover:bg-blue-50',
                            ]"
                            type="button"
                        >
                            {{ number }}
                        </button>
                    </div>

                    <!-- Selected Answer Preview -->
                    <div
                        class="flex items-center gap-2 rounded-lg bg-gray-50 p-3"
                    >
                        <Check class="h-4 w-4 text-green-600" />
                        <span class="text-sm font-medium">Jawaban:</span>
                        <span
                            v-if="getSelectedNumbers(index)"
                            class="font-mono text-lg font-bold text-blue-600"
                        >
                            {{ getSelectedNumbers(index) }}
                        </span>
                        <span v-else class="text-gray-400 italic"
                            >Belum ada yang dipilih</span
                        >
                    </div>

                    <p class="text-xs text-gray-500">
                        Pilih satu angka untuk jawaban tunggal (contoh: 5), atau
                        beberapa angka untuk jawaban multi-digit
                    </p>
                </div>
            </div>
        </div>
        <!-- Add Question Button (Bottom) -->
        <div v-if="questions.length > 0" class="flex justify-center pt-4">
            <Button
                @click="addQuestion"
                variant="outline"
                class="flex items-center gap-2 hover:border-blue-300 hover:bg-blue-50"
            >
                <Plus class="h-4 w-4" />
                Tambah Soal Baru
            </Button>
        </div>
    </div>
</template>
