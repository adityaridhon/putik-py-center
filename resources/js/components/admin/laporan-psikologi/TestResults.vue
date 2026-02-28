<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import Tabs from '@/components/ui/tabs/Tabs.vue';
import TabsContent from '@/components/ui/tabs/TabsContent.vue';
import TabsList from '@/components/ui/tabs/TabsList.vue';
import TabsTrigger from '@/components/ui/tabs/TabsTrigger.vue';
import { Brain, Flame, GraduationCap, User } from 'lucide-vue-next';

interface Props {
    participant?: {
        name: string;
        email: string;
        test_date: string;
        completion_time?: string;
    };
    intelligenceResults?: {
        subtests: Array<{
            name: string;
            questions: Array<{
                question: string;
                question_type:
                    | 'multiple_choice'
                    | 'short_answer'
                    | 'number_input';
                user_answer: string;
            }>;
        }>;
    };
    learningStyleResults?: {
        statements: Array<{
            statement: string;
            user_answer: number; // 1-3 scale
        }>;
    };
    interestResults?: {
        categories: Array<{
            name: string;
            questions: Array<{
                question: string;
                user_answer: string;
            }>;
        }>;
    };
}

const props = withDefaults(defineProps<Props>(), {
    participant: () => ({
        name: 'Reza Auditore',
        email: 'john@example.com',
        test_date: '2026-02-28',
        completion_time: '45 menit',
    }),
    intelligenceResults: () => ({
        subtests: [
            {
                name: 'Verbal',
                questions: [
                    {
                        question: 'Apa sinonim dari kata "senang"?',
                        question_type: 'multiple_choice',
                        user_answer: 'Gembira',
                    },
                    {
                        question: 'Sebutkan antonim dari kata "tinggi"',
                        question_type: 'short_answer',
                        user_answer: 'Rendah',
                    },
                ],
            },
            {
                name: 'Numerik',
                questions: [
                    {
                        question: 'Berapa hasil dari 2 + 3?',
                        question_type: 'number_input',
                        user_answer: '5',
                    },
                ],
            },
        ],
    }),
    learningStyleResults: () => ({
        statements: [
            {
                statement:
                    'Saya suka belajar dengan melihat gambar atau diagram.',
                user_answer: 1,
            },
            {
                statement:
                    'Saya lebih mudah mengingat sesuatu jika saya mendengarkannya.',
                user_answer: 3,
            },
        ],
    }),
    interestResults: () => ({
        categories: [
            {
                name: 'A',
                questions: [
                    {
                        question: 'Pilih 1 pekerjaan',
                        user_answer: 'polisi',
                    },
                ],
            },
        ],
    }),
});
</script>

<template>
    <div class="space-y-6">
        <!-- Header - Informasi Peserta -->
        <Card>
            <CardHeader>
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="flex h-16 w-16 items-center justify-center rounded-full bg-primary/10"
                        >
                            <User class="h-8 w-8 text-primary" />
                        </div>
                        <div>
                            <CardTitle class="text-2xl">{{
                                participant.name
                            }}</CardTitle>
                            <CardDescription class="mt-1">
                                {{ participant.email }}
                            </CardDescription>
                            <div class="mt-2 flex gap-4 text-sm text-gray-600">
                                <span
                                    >Tanggal Tes:
                                    {{ participant.test_date }}</span
                                >
                                <span
                                    >Durasi:
                                    {{ participant.completion_time }}</span
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </CardHeader>
        </Card>

        <!-- Alert Disclaimer -->

        <!-- Tabs untuk berbagai jenis tes -->
        <Tabs default-value="intelligence" class="w-full">
            <TabsList class="grid w-full grid-cols-3">
                <TabsTrigger value="intelligence" class="gap-2">
                    <Brain class="h-4 w-4" />
                    Tes Intelegensi
                </TabsTrigger>
                <TabsTrigger value="learning-style" class="gap-2">
                    <GraduationCap class="h-4 w-4" />
                    Gaya Belajar
                </TabsTrigger>
                <TabsTrigger value="interest" class="gap-2">
                    <Flame class="h-4 w-4" />
                    Minat Bakat
                </TabsTrigger>
            </TabsList>

            <!-- Tes Intelegensi -->
            <TabsContent value="intelligence" class="space-y-4">
                <!-- Subtests -->
                <div
                    v-for="subtest in intelligenceResults.subtests"
                    :key="subtest.name"
                >
                    <Card>
                        <CardHeader>
                            <CardTitle>{{ subtest.name }}</CardTitle>
                            <CardDescription
                                >Jawaban peserta pada subtes
                                {{ subtest.name }}</CardDescription
                            >
                        </CardHeader>
                        <CardContent>
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead class="w-12">No</TableHead>
                                        <TableHead>Pertanyaan</TableHead>
                                        <TableHead class="w-48"
                                            >Jawaban Peserta</TableHead
                                        >
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow
                                        v-for="(
                                            question, qIndex
                                        ) in subtest.questions"
                                        :key="qIndex"
                                    >
                                        <TableCell class="font-medium">{{
                                            qIndex + 1
                                        }}</TableCell>
                                        <TableCell>{{
                                            question.question
                                        }}</TableCell>
                                        <TableCell>
                                            <Badge
                                                variant="secondary"
                                                class="font-mono"
                                            >
                                                {{
                                                    question.user_answer ||
                                                    'Tidak dijawab'
                                                }}
                                            </Badge>
                                        </TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </CardContent>
                    </Card>
                </div>
            </TabsContent>

            <!-- Gaya Belajar -->
            <TabsContent value="learning-style" class="space-y-4">
                <!-- Statements -->
                <Card>
                    <CardHeader>
                        <CardTitle>Respon Pernyataan</CardTitle>
                        <CardDescription
                            >Jawaban peserta terhadap setiap pernyataan (Skala
                            1-3)</CardDescription
                        >
                    </CardHeader>
                    <CardContent>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead class="w-12">No</TableHead>
                                    <TableHead>Pernyataan</TableHead>
                                    <TableHead class="w-48 text-center"
                                        >Respon</TableHead
                                    >
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow
                                    v-for="(
                                        statement, index
                                    ) in learningStyleResults.statements"
                                    :key="index"
                                >
                                    <TableCell class="font-medium">{{
                                        index + 1
                                    }}</TableCell>
                                    <TableCell>{{
                                        statement.statement
                                    }}</TableCell>
                                    <TableCell>
                                        <div
                                            class="flex items-center justify-center gap-1"
                                        >
                                            <div
                                                v-for="n in 3"
                                                :key="n"
                                                :class="[
                                                    'h-8 w-8 rounded-full border-2',
                                                    n <= statement.user_answer
                                                        ? 'border-primary bg-primary text-white'
                                                        : 'border-gray-300 bg-white text-gray-400',
                                                ]"
                                                class="flex items-center justify-center text-sm font-medium"
                                            >
                                                {{ n }}
                                            </div>
                                        </div>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </CardContent>
                </Card>
            </TabsContent>

            <!-- Minat Bakat -->
            <TabsContent value="interest" class="space-y-4">
                <!-- Categories -->
                <div
                    v-for="category in interestResults.categories"
                    :key="category.name"
                >
                    <Card>
                        <CardHeader>
                            <CardTitle>Kategori: {{ category.name }}</CardTitle>
                            <CardDescription
                                >Respon peserta pada kategori
                                {{ category.name }}</CardDescription
                            >
                        </CardHeader>
                        <CardContent>
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead class="w-12">No</TableHead>
                                        <TableHead>Pernyataan</TableHead>
                                        <TableHead class="w-48 text-center"
                                            >Respon</TableHead
                                        >
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow
                                        v-for="(
                                            question, qIndex
                                        ) in category.questions"
                                        :key="qIndex"
                                    >
                                        <TableCell class="font-medium">{{
                                            qIndex + 1
                                        }}</TableCell>
                                        <TableCell>{{
                                            question.question
                                        }}</TableCell>
                                        <TableCell>
                                            <div
                                                class="flex items-center justify-center gap-1"
                                            >
                                                <Badge variant="secondary">
                                                    {{
                                                        question.user_answer ||
                                                        'Tidak dijawab'
                                                    }}
                                                </Badge>
                                            </div>
                                        </TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </CardContent>
                    </Card>
                </div>
            </TabsContent>
        </Tabs>
    </div>
</template>
