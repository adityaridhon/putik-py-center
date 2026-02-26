import intelegensi from '@/routes/intelegensi';
import { router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

export interface Question {
    id: string;
    dbId?: number;
    question: string;
    type: 'multiple_choice' | 'short_answer' | 'number_input';
    options?: string[];
    correctAnswer?: string | number[];
    shortAnswer?: string;
    questionImage?: File | string | null;
    questionImagePreview?: string | null;
    optionImages?: (File | string | null)[];
    optionImagePreviews?: (string | null)[];
    isModified?: boolean;
}

export interface Category {
    id: number;
    code: string;
    name: string;
    question_type: string;
    answer_type: 'multiple_choice' | 'text';
    total_questions: number;
    duration_minutes: number;
    description: string | null;
    instruction: string | null;
    order: number;
    is_active: boolean;
}

export interface QuestionsData {
    data: any[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}

export function useQuestionManagement(
    category: Category,
    questionsData: QuestionsData,
) {
    // State
    const localQuestions = ref<Question[]>([]);
    const deletedQuestionIds = ref<number[]>([]);
    const isLoadingQuestions = ref(false);
    const numberOfQuestions = ref<number | string>('');
    const isSaving = ref(false);

    // Computed - Question Type
    const questionType = computed<
        'multiple_choice' | 'short_answer' | 'number_input'
    >(() => {
        if (
            category.question_type === 'numeric' ||
            category.question_type === 'series'
        ) {
            return 'number_input';
        }
        if (category.answer_type === 'multiple_choice') {
            return 'multiple_choice';
        }
        return 'short_answer';
    });

    const isImageType = computed(() => {
        return category.question_type === 'image';
    });

    // Computed - Counts
    const existingQuestionsCount = computed(() => {
        return localQuestions.value.filter((q) => q.dbId).length;
    });

    const newQuestionsCount = computed(() => {
        return localQuestions.value.filter((q) => !q.dbId).length;
    });

    const modifiedQuestionsCount = computed(() => {
        return localQuestions.value.filter((q) => q.dbId && q.isModified)
            .length;
    });

    const deletedQuestionsCount = computed(() => {
        return deletedQuestionIds.value.length;
    });

    const hasChanges = computed(() => {
        return (
            newQuestionsCount.value > 0 ||
            modifiedQuestionsCount.value > 0 ||
            deletedQuestionsCount.value > 0
        );
    });

    const validQuestionsCount = computed(() => {
        return localQuestions.value.filter((q) => {
            const isNewQuestion = !q.dbId;
            const isModifiedQuestion = q.dbId && q.isModified;

            if (!isNewQuestion && !isModifiedQuestion) return false;

            if (isImageType.value) {
                if (isNewQuestion) {
                    const hasQuestionContent =
                        q.questionImage || q.question.trim();
                    if (!hasQuestionContent) return false;

                    const hasAllOptionImages = q.optionImages?.every(
                        (img) => img !== null,
                    );
                    const hasCorrectAnswer = !!q.correctAnswer;
                    return hasAllOptionImages && hasCorrectAnswer;
                } else {
                    const hasCorrectAnswer = !!q.correctAnswer;
                    return hasCorrectAnswer;
                }
            }

            if (!q.question.trim()) return false;

            if (questionType.value === 'multiple_choice') {
                const hasAllOptions = q.options?.every((opt) => opt.trim());
                const hasCorrectAnswer = !!q.correctAnswer;
                return hasAllOptions && hasCorrectAnswer;
            } else if (questionType.value === 'short_answer') {
                return !!q.shortAnswer?.trim();
            } else {
                return (
                    Array.isArray(q.correctAnswer) && q.correctAnswer.length > 0
                );
            }
        }).length;
    });

    const isGenerateDisabled = computed(() => {
        const num = Number(numberOfQuestions.value);
        return !numberOfQuestions.value || num <= 0 || isNaN(num);
    });

    // Methods
    const generateId = () => crypto.randomUUID();

    const loadExistingQuestions = () => {
        if (!questionsData.data || questionsData.data.length === 0) {
            return;
        }

        isLoadingQuestions.value = true;

        const loadedQuestions: Question[] = questionsData.data.map(
            (dbQuestion) => {
                const question: Question = {
                    id: dbQuestion.id.toString(),
                    dbId: dbQuestion.id,
                    question: dbQuestion.question_text || '',
                    type: questionType.value,
                    isModified: false,
                };

                if (questionType.value === 'multiple_choice') {
                    if (isImageType.value) {
                        question.options = ['', '', '', '', ''];
                        question.correctAnswer = dbQuestion.correct_answer;
                        question.questionImage = null;
                        question.questionImagePreview =
                            dbQuestion.question_image
                                ? `/storage/${dbQuestion.question_image}`
                                : null;
                        question.optionImages = [null, null, null, null, null];
                        question.optionImagePreviews = [
                            dbQuestion.option_a
                                ? `/storage/${dbQuestion.option_a}`
                                : null,
                            dbQuestion.option_b
                                ? `/storage/${dbQuestion.option_b}`
                                : null,
                            dbQuestion.option_c
                                ? `/storage/${dbQuestion.option_c}`
                                : null,
                            dbQuestion.option_d
                                ? `/storage/${dbQuestion.option_d}`
                                : null,
                            dbQuestion.option_e
                                ? `/storage/${dbQuestion.option_e}`
                                : null,
                        ];
                    } else {
                        question.options = [
                            dbQuestion.option_a || '',
                            dbQuestion.option_b || '',
                            dbQuestion.option_c || '',
                            dbQuestion.option_d || '',
                            dbQuestion.option_e || '',
                        ];
                        question.correctAnswer = dbQuestion.correct_answer;
                    }
                } else if (questionType.value === 'short_answer') {
                    question.shortAnswer = dbQuestion.correct_answer || '';
                } else if (questionType.value === 'number_input') {
                    const answerString = dbQuestion.correct_answer || '';
                    question.correctAnswer = answerString
                        .split('')
                        .map((char: string) => parseInt(char));
                }

                return question;
            },
        );

        localQuestions.value = loadedQuestions;
        isLoadingQuestions.value = false;
    };

    const generateQuestions = () => {
        const count =
            typeof numberOfQuestions.value === 'string'
                ? parseInt(numberOfQuestions.value)
                : numberOfQuestions.value;

        if (!count || count <= 0 || count > 50) {
            alert('Mohon masukkan jumlah soal yang valid (1-50)');
            return;
        }

        localQuestions.value = [];

        for (let i = 0; i < count; i++) {
            const newQuestion: Question = {
                id: generateId(),
                question: '',
                type: questionType.value,
            };

            if (questionType.value === 'multiple_choice') {
                newQuestion.options = ['', '', '', '', ''];
                newQuestion.correctAnswer = '';
                if (isImageType.value) {
                    newQuestion.questionImage = null;
                    newQuestion.questionImagePreview = null;
                    newQuestion.optionImages = [null, null, null, null, null];
                    newQuestion.optionImagePreviews = [
                        null,
                        null,
                        null,
                        null,
                        null,
                    ];
                }
            } else if (questionType.value === 'short_answer') {
                newQuestion.shortAnswer = '';
            } else if (questionType.value === 'number_input') {
                newQuestion.correctAnswer = [];
            }

            localQuestions.value.push(newQuestion);
        }

        numberOfQuestions.value = '';
    };

    const incrementQuestions = () => {
        const current =
            typeof numberOfQuestions.value === 'string'
                ? parseInt(numberOfQuestions.value) || 0
                : numberOfQuestions.value || 0;

        if (current < 50) {
            numberOfQuestions.value = current + 1;
        }
    };

    const decrementQuestions = () => {
        const current =
            typeof numberOfQuestions.value === 'string'
                ? parseInt(numberOfQuestions.value) || 0
                : numberOfQuestions.value || 0;

        if (current > 1) {
            numberOfQuestions.value = current - 1;
        }
    };

    const handleQuestionDelete = (questionId: string) => {
        const questionIndex = localQuestions.value.findIndex(
            (q) => q.id === questionId,
        );
        if (questionIndex === -1) return;

        const question = localQuestions.value[questionIndex];

        if (question.dbId) {
            deletedQuestionIds.value.push(question.dbId);
        }

        localQuestions.value.splice(questionIndex, 1);
    };

    const validateQuestions = () => {
        const newQuestions = localQuestions.value.filter((q) => !q.dbId);
        const modifiedQuestions = localQuestions.value.filter(
            (q) => q.dbId && q.isModified,
        );
        const allQuestionsToSave = [...newQuestions, ...modifiedQuestions];

        if (isImageType.value) {
            const newQuestionsWithoutImage = newQuestions.filter(
                (q) => !q.questionImage && !q.question.trim(),
            );
            if (newQuestionsWithoutImage.length > 0) {
                alert(
                    `Ada ${newQuestionsWithoutImage.length} soal baru yang belum memiliki gambar atau deskripsi!`,
                );
                return false;
            }

            const newQuestionsWithIncompleteOptions = newQuestions.filter(
                (q) => {
                    if (!q.correctAnswer) return true;
                    const hasAllOptionImages = q.optionImages?.every(
                        (img) => img !== null,
                    );
                    return !hasAllOptionImages;
                },
            );

            if (newQuestionsWithIncompleteOptions.length > 0) {
                alert(
                    `Ada ${newQuestionsWithIncompleteOptions.length} soal baru yang belum lengkap (gambar opsi atau jawaban benar belum diisi)!`,
                );
                return false;
            }

            const modifiedQuestionsWithoutAnswer = modifiedQuestions.filter(
                (q) => !q.correctAnswer,
            );
            if (modifiedQuestionsWithoutAnswer.length > 0) {
                alert(
                    `Ada ${modifiedQuestionsWithoutAnswer.length} soal yang diubah belum memiliki jawaban benar!`,
                );
                return false;
            }
        } else {
            const emptyQuestions = allQuestionsToSave.filter(
                (q) => !q.question.trim(),
            );
            if (emptyQuestions.length > 0) {
                alert(
                    `Ada ${emptyQuestions.length} soal yang belum diisi pertanyaannya!`,
                );
                return false;
            }

            if (questionType.value === 'multiple_choice') {
                const invalidQuestions = allQuestionsToSave.filter((q) => {
                    const hasEmptyOptions = q.options?.some(
                        (opt) => !opt.trim(),
                    );
                    const hasNoCorrectAnswer = !q.correctAnswer;
                    return hasEmptyOptions || hasNoCorrectAnswer;
                });

                if (invalidQuestions.length > 0) {
                    alert(
                        `Ada ${invalidQuestions.length} soal yang belum lengkap (opsi atau jawaban benar belum diisi)!`,
                    );
                    return false;
                }
            } else if (questionType.value === 'number_input') {
                const invalidQuestions = allQuestionsToSave.filter((q) => {
                    return (
                        !Array.isArray(q.correctAnswer) ||
                        q.correctAnswer.length === 0
                    );
                });

                if (invalidQuestions.length > 0) {
                    alert(
                        `Ada ${invalidQuestions.length} soal yang belum memiliki jawaban angka!`,
                    );
                    return false;
                }
            }
        }

        return true;
    };

    const buildFormData = () => {
        const newQuestions = localQuestions.value.filter((q) => !q.dbId);
        const modifiedQuestions = localQuestions.value.filter(
            (q) => q.dbId && q.isModified,
        );

        const formData = new FormData();
        formData.append('category_id', category.id.toString());

        deletedQuestionIds.value.forEach((id, index) => {
            formData.append(`deleted_question_ids[${index}]`, id.toString());
        });

        const appendQuestionToFormData = (
            q: Question,
            index: number,
            isUpdate: boolean,
        ) => {
            if (isUpdate && q.dbId) {
                formData.append(`questions[${index}][id]`, q.dbId.toString());
            }

            formData.append(
                `questions[${index}][question_text]`,
                q.question || '',
            );

            let correctAnswerValue = '';
            if (
                questionType.value === 'number_input' &&
                Array.isArray(q.correctAnswer)
            ) {
                correctAnswerValue = q.correctAnswer.join('');
            } else if (questionType.value === 'short_answer') {
                correctAnswerValue = q.shortAnswer || '';
            } else {
                correctAnswerValue = (q.correctAnswer as string) || '';
            }
            formData.append(
                `questions[${index}][correct_answer]`,
                correctAnswerValue,
            );

            if (q.questionImage instanceof File) {
                formData.append(
                    `questions[${index}][question_image]`,
                    q.questionImage,
                );
            }

            if (questionType.value === 'multiple_choice') {
                q.options?.forEach((opt, optIndex) => {
                    const optLabel = String.fromCharCode(97 + optIndex);

                    if (isImageType.value) {
                        if (q.optionImages?.[optIndex] instanceof File) {
                            formData.append(
                                `questions[${index}][option_${optLabel}]`,
                                q.optionImages[optIndex] as File,
                            );
                        }
                        if (opt) {
                            formData.append(
                                `questions[${index}][option_${optLabel}_text]`,
                                opt,
                            );
                        }
                    } else {
                        formData.append(
                            `questions[${index}][option_${optLabel}]`,
                            opt || '',
                        );
                    }
                });
            }
        };

        newQuestions.forEach((q, index) => {
            appendQuestionToFormData(q, index, false);
        });

        modifiedQuestions.forEach((q, index) => {
            const updateIndex = newQuestions.length + index;
            appendQuestionToFormData(q, updateIndex, true);
        });

        return formData;
    };

    const saveQuestions = () => {
        const newQuestions = localQuestions.value.filter((q) => !q.dbId);
        const modifiedQuestions = localQuestions.value.filter(
            (q) => q.dbId && q.isModified,
        );

        console.log('Saving questions:', {
            isImageType: isImageType.value,
            questionType: questionType.value,
            newQuestionsCount: newQuestions.length,
            modifiedQuestionsCount: modifiedQuestions.length,
            deletedCount: deletedQuestionIds.value.length,
            newQuestions: newQuestions,
        });

        if (
            newQuestions.length === 0 &&
            modifiedQuestions.length === 0 &&
            deletedQuestionIds.value.length === 0
        ) {
            alert('Tidak ada perubahan untuk disimpan!');
            return;
        }

        if (!validateQuestions()) {
            return;
        }

        const formData = buildFormData();

        isSaving.value = true;
        router.post(intelegensi.questions.bulkStore.url(), formData, {
            onSuccess: () => {
                isSaving.value = false;
                deletedQuestionIds.value = [];
                router.reload({ only: ['questions'] });
            },
            onError: (errors) => {
                isSaving.value = false;
                console.error('Error saving questions:', errors);
                alert(
                    'Gagal menyimpan soal. Silakan cek console untuk detail error.',
                );
            },
        });
    };

    const getAnswerTypeLabel = () => {
        if (category.question_type === 'numeric') {
            return 'Input Angka 1-10 (Numerik)';
        }
        if (category.question_type === 'series') {
            return 'Input Angka 1-10 (Deret Angka)';
        }
        if (category.answer_type === 'multiple_choice') {
            return 'Pilihan Ganda (A-E)';
        }
        return 'Isian Singkat';
    };

    return {
        // State
        localQuestions,
        deletedQuestionIds,
        isLoadingQuestions,
        numberOfQuestions,
        isSaving,

        // Computed
        questionType,
        isImageType,
        existingQuestionsCount,
        newQuestionsCount,
        modifiedQuestionsCount,
        deletedQuestionsCount,
        hasChanges,
        validQuestionsCount,
        isGenerateDisabled,

        // Methods
        loadExistingQuestions,
        generateQuestions,
        incrementQuestions,
        decrementQuestions,
        handleQuestionDelete,
        saveQuestions,
        getAnswerTypeLabel,
    };
}
