import { type Ref } from 'vue';

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

export interface UseQuestionCreatorOptions {
    questions: Ref<Question[]>;
    questionType: 'multiple_choice' | 'short_answer' | 'number_input';
    isImageType?: boolean;
    onUpdate?: (questions: Question[]) => void;
    onDelete?: (questionId: string) => void;
}

export function useQuestionCreator(options: UseQuestionCreatorOptions) {
    const {
        questions,
        questionType,
        isImageType = false,
        onUpdate,
        onDelete,
    } = options;

    // Methods
    const generateId = () => crypto.randomUUID();

    const createNewQuestion = (): Question => {
        const newQuestion: Question = {
            id: generateId(),
            question: '',
            type: questionType,
        };

        if (questionType === 'multiple_choice') {
            newQuestion.options = ['', '', '', '', ''];
            newQuestion.correctAnswer = '';
            if (isImageType) {
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
        } else if (questionType === 'short_answer') {
            newQuestion.shortAnswer = '';
        } else if (questionType === 'number_input') {
            newQuestion.correctAnswer = [];
        }

        return newQuestion;
    };

    const addQuestion = () => {
        const newQuestion = createNewQuestion();
        questions.value.push(newQuestion);
        updateModelValue();
    };

    const removeQuestion = (index: number) => {
        const question = questions.value[index];
        if (onDelete) {
            onDelete(question.id);
        }
        questions.value.splice(index, 1);
        updateModelValue();
    };

    const updateModelValue = () => {
        if (onUpdate) {
            onUpdate(questions.value);
        }
    };

    const markAsModified = (questionIndex: number) => {
        const question = questions.value[questionIndex];
        if (question.dbId) {
            question.isModified = true;
            updateModelValue();
        }
    };

    // Number Input Methods
    const toggleNumber = (questionIndex: number, number: number) => {
        const question = questions.value[questionIndex];
        if (questionType === 'number_input') {
            const correctAnswer = (question.correctAnswer as number[]) || [];
            const index = correctAnswer.indexOf(number);

            if (index > -1) {
                correctAnswer.splice(index, 1);
            } else {
                correctAnswer.push(number);
            }

            question.correctAnswer = [...correctAnswer];
            markAsModified(questionIndex);
            updateModelValue();
        }
    };

    const isNumberSelected = (questionIndex: number, number: number) => {
        const question = questions.value[questionIndex];
        if (questionType === 'number_input') {
            return ((question.correctAnswer as number[]) || []).includes(
                number,
            );
        }
        return false;
    };

    const getSelectedNumbers = (questionIndex: number) => {
        const question = questions.value[questionIndex];
        if (questionType === 'number_input') {
            return ((question.correctAnswer as number[]) || []).join('');
        }
        return '';
    };

    // Image Upload Methods
    const handleQuestionImageUpload = (questionIndex: number, event: Event) => {
        const target = event.target as HTMLInputElement;
        const file = target.files?.[0];

        if (file && file.type.startsWith('image/')) {
            const question = questions.value[questionIndex];
            question.questionImage = file;

            const reader = new FileReader();
            reader.onload = (e) => {
                question.questionImagePreview = e.target?.result as string;
                markAsModified(questionIndex);
                updateModelValue();
            };
            reader.readAsDataURL(file);
        }
    };

    const handleOptionImageUpload = (
        questionIndex: number,
        optionIndex: number,
        event: Event,
    ) => {
        const target = event.target as HTMLInputElement;
        const file = target.files?.[0];

        if (file && file.type.startsWith('image/')) {
            const question = questions.value[questionIndex];
            if (!question.optionImages) {
                question.optionImages = [null, null, null, null, null];
            }
            if (!question.optionImagePreviews) {
                question.optionImagePreviews = [null, null, null, null, null];
            }

            question.optionImages[optionIndex] = file;

            const reader = new FileReader();
            reader.onload = (e) => {
                question.optionImagePreviews![optionIndex] = e.target
                    ?.result as string;
                markAsModified(questionIndex);
                updateModelValue();
            };
            reader.readAsDataURL(file);
        }
    };

    const removeQuestionImage = (questionIndex: number) => {
        const question = questions.value[questionIndex];
        question.questionImage = null;
        question.questionImagePreview = null;
        markAsModified(questionIndex);
        updateModelValue();
    };

    const removeOptionImage = (questionIndex: number, optionIndex: number) => {
        const question = questions.value[questionIndex];
        if (question.optionImages) {
            question.optionImages[optionIndex] = null;
        }
        if (question.optionImagePreviews) {
            question.optionImagePreviews[optionIndex] = null;
        }
        markAsModified(questionIndex);
        updateModelValue();
    };

    // Utility Methods
    const getQuestionTypeLabel = () => {
        switch (questionType) {
            case 'multiple_choice':
                return 'Pilihan Ganda (A-E)';
            case 'short_answer':
                return 'Isian Singkat';
            case 'number_input':
                return 'Input Angka 0-9';
            default:
                return 'Tidak Diketahui';
        }
    };

    return {
        // Methods
        addQuestion,
        removeQuestion,
        updateModelValue,
        markAsModified,

        // Number Input
        toggleNumber,
        isNumberSelected,
        getSelectedNumbers,

        // Image Upload
        handleQuestionImageUpload,
        handleOptionImageUpload,
        removeQuestionImage,
        removeOptionImage,

        // Utility
        getQuestionTypeLabel,
    };
}
