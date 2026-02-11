<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import Label from '@/components/ui/label/Label.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import { Check, Plus, Trash2 } from 'lucide-vue-next';
import { ref } from 'vue';

interface Question {
    id: string;
    question: string;
    type: 'multiple_choice' | 'short_answer' | 'number_input';
    options?: string[];
    correctAnswer?: string | number[];
    shortAnswer?: string;
}

interface Props {
    modelValue?: Question[];
    questionType: 'multiple_choice' | 'short_answer' | 'number_input';
    subtestName?: string;
}

interface Emits {
    (e: 'update:modelValue', value: Question[]): void;
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const questions = ref<Question[]>(props.modelValue || []);

// Generate unique ID
const generateId = () => crypto.randomUUID();

// Add new question
const addQuestion = () => {
    const newQuestion: Question = {
        id: generateId(),
        question: '',
        type: props.questionType,
    };

    // Set default values based on question type
    if (props.questionType === 'multiple_choice') {
        newQuestion.options = ['', '', '', '', ''];
        newQuestion.correctAnswer = '';
    } else if (props.questionType === 'short_answer') {
        newQuestion.shortAnswer = '';
    } else if (props.questionType === 'number_input') {
        newQuestion.correctAnswer = [];
    }

    questions.value.push(newQuestion);
    updateModelValue();
};

// Remove question
const removeQuestion = (index: number) => {
    questions.value.splice(index, 1);
    updateModelValue();
};

// Get question type label
const getQuestionTypeLabel = () => {
    switch (props.questionType) {
        case 'multiple_choice':
            return 'Pilihan Ganda (A-E)';
        case 'short_answer':
            return 'Isian Singkat';
        case 'number_input':
            return 'Input Angka (0-9)';
        default:
            return 'Tidak Diketahui';
    }
};

// Toggle number selection
const toggleNumber = (questionIndex: number, number: number) => {
    const question = questions.value[questionIndex];
    if (props.questionType === 'number_input') {
        const correctAnswer = (question.correctAnswer as number[]) || [];
        const index = correctAnswer.indexOf(number);

        if (index > -1) {
            correctAnswer.splice(index, 1);
        } else {
            correctAnswer.push(number);
        }

        // Don't sort - keep the order of clicks
        question.correctAnswer = [...correctAnswer];
        updateModelValue();
    }
};

// Check if number is selected
const isNumberSelected = (questionIndex: number, number: number) => {
    const question = questions.value[questionIndex];
    if (props.questionType === 'number_input') {
        return ((question.correctAnswer as number[]) || []).includes(number);
    }
    return false;
};

// Update model value
const updateModelValue = () => {
    emit('update:modelValue', questions.value);
};

// Get selected numbers as string
const getSelectedNumbers = (questionIndex: number) => {
    const question = questions.value[questionIndex];
    if (props.questionType === 'number_input') {
        return ((question.correctAnswer as number[]) || []).join('');
    }
    return '';
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
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <span
                    class="rounded-full bg-blue-100 px-2 py-1 font-medium text-blue-800"
                    >{{ getQuestionTypeLabel() }}</span
                >
                <span>• Semua soal menggunakan tipe yang sama</span>
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

        <div
            v-for="(question, index) in questions"
            :key="question.id"
            class="space-y-4 rounded-lg border border-gray-200 bg-white p-4"
        >
            <!-- Question Header -->
            <div class="flex items-center justify-between">
                <h3 class="font-medium text-gray-900">Soal {{ index + 1 }}</h3>
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
                    :id="`question-${question.id}`"
                    v-model="question.question"
                    placeholder="Masukkan pertanyaan..."
                    class="resize-none"
                    rows="3"
                    @input="updateModelValue"
                />
            </div>

            <!-- Multiple Choice Options -->
            <div
                v-if="props.questionType === 'multiple_choice'"
                class="space-y-3"
            >
                <Label>Pilihan Jawaban</Label>
                <div class="space-y-2">
                    <div
                        v-for="(option, optionIndex) in question.options"
                        :key="optionIndex"
                        class="flex items-center gap-3"
                    >
                        <label class="flex cursor-pointer items-center gap-2">
                            <input
                                type="radio"
                                :name="`correct-${question.id}`"
                                :value="String.fromCharCode(65 + optionIndex)"
                                v-model="question.correctAnswer"
                                @change="updateModelValue"
                                class="text-blue-600"
                            />
                            <span class="w-8 font-medium"
                                >{{
                                    String.fromCharCode(65 + optionIndex)
                                }}.</span
                            >
                        </label>
                        <Input
                            v-model="question.options![optionIndex]"
                            :placeholder="`Opsi ${String.fromCharCode(65 + optionIndex)}`"
                            class="flex-1"
                            @input="updateModelValue"
                        />
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
            <div v-if="props.questionType === 'short_answer'" class="space-y-2">
                <Label :for="`answer-${question.id}`"
                    >Jawaban yang Diharapkan</Label
                >
                <Input
                    :id="`answer-${question.id}`"
                    v-model="question.shortAnswer"
                    placeholder="Masukkan jawaban yang diharapkan..."
                    @input="updateModelValue"
                />
                <p class="text-xs text-gray-500">
                    Jawaban ini akan digunakan sebagai referensi untuk penilaian
                </p>
            </div>

            <!-- Number Input -->
            <div v-if="props.questionType === 'number_input'" class="space-y-3">
                <Label>Pilih Angka Jawaban</Label>
                <p class="text-sm text-gray-600">
                    Klik angka yang merupakan jawaban yang benar:
                </p>

                <!-- Number Grid -->
                <div class="grid max-w-xs grid-cols-5 gap-2">
                    <button
                        v-for="number in [1, 2, 3, 4, 5, 6, 7, 8, 9, 0]"
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
                <div class="flex items-center gap-2 rounded-lg bg-gray-50 p-3">
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
                    Contoh: Untuk jawaban "20", klik angka 2 dan 0
                </p>
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

        <!-- Summary -->
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
    </div>
</template>
