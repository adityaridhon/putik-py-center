<script setup lang="ts">
import { computed } from 'vue';

type ArticleCard = {
    deskripsi: string;
};

const props = defineProps<{
    article: ArticleCard;
}>();

// Check if content is HTML format (from TipTap editor)
const isHtmlContent = computed(() => {
    const content = props.article.deskripsi;
    return content.includes('<p>') || content.includes('<h1>') || content.includes('<h2>') || content.includes('<em>') || content.includes('<strong>');
});

// Add Tailwind prose classes to HTML content for proper styling
const styledHtmlContent = computed(() => {
    if (!isHtmlContent.value) return '';
    
    let html = props.article.deskripsi;
    
    // Add classes to paragraphs
    html = html.replace(/<p>/g, '<p class="text-gray-700 leading-8 text-base text-justify sm:text-lg">');
    
    // Add classes to headings
    html = html.replace(/<h1>/g, '<h1 class="text-2xl font-bold mt-6 mb-4 text-gray-900">');
    html = html.replace(/<h2>/g, '<h2 class="text-xl font-bold mt-5 mb-3 text-gray-900">');
    html = html.replace(/<h3>/g, '<h3 class="text-lg font-bold mt-4 mb-2 text-gray-900">');
    html = html.replace(/<h4>/g, '<h4 class="text-base font-bold mt-3 mb-2 text-gray-900">');
    
    // Add classes to lists and list items
    html = html.replace(/<ul>/g, '<ul class="list-disc ml-5 text-gray-700">');
    html = html.replace(/<ol>/g, '<ol class="list-decimal ml-5 text-gray-700">');
    html = html.replace(/<li>/g, '<li class="text-gray-700 leading-7 ml-2">');
    
    // Add classes to links
    html = html.replace(/<a /g, '<a class="text-blue-600 underline hover:text-blue-800" ');
    
    // Add classes to blockquotes
    html = html.replace(/<blockquote>/g, '<blockquote class="border-l-4 border-gray-300 pl-4 italic text-gray-700 my-4">');
    
    return html;
});

// Extract paragraphs from plaintext format (for legacy support)
const paragraphs = computed(() => {
    const content = props.article.deskripsi;
    
    // If content contains HTML (TipTap output), parse paragraphs from <p> tags
    if (isHtmlContent.value) {
        // Create temporary DOM element to parse HTML
        const temp = document.createElement('div');
        temp.innerHTML = content;
        
        // Extract text from block elements (p, h1-h6, li, blockquote, etc.)
        const blockElements: string[] = [];
        
        temp.querySelectorAll('p, h1, h2, h3, h4, h5, h6, blockquote, li').forEach((el) => {
            const text = el.textContent?.trim();
            if (text) {
                blockElements.push(text);
            }
        });
        
        // If block elements found, return them; otherwise fallback to all text
        if (blockElements.length > 0) {
            return blockElements.filter((para) => para.length > 0);
        }
        
        // Fallback: extract all text
        const allText = temp.textContent?.trim() || '';
        return allText.length > 0 ? [allText] : [];
    }
    
    // Plaintext format with double newlines (legacy support)
    return content
        .split(/\n\n+/)
        .map((para) =>
            para
                .replace(/<[^>]*>/g, '')
                .replace(/\s+/g, ' ')
                .trim(),
        )
        .filter((para) => para.length > 0);
});
</script>

<template>
    <article class="space-y-5">
        <!-- If content is HTML, render it directly with proper styling -->
        <div
            v-if="isHtmlContent"
            v-html="styledHtmlContent"
            class="prose prose-base max-w-none
                   prose-p:text-gray-700 prose-p:leading-8 prose-p:text-base prose-p:text-justify sm:prose-p:text-lg
                   prose-h1:text-2xl prose-h1:font-bold prose-h1:mt-6 prose-h1:mb-4
                   prose-h2:text-xl prose-h2:font-bold prose-h2:mt-5 prose-h2:mb-3
                   prose-h3:text-lg prose-h3:font-bold prose-h3:mt-4 prose-h3:mb-2
                   prose-strong:font-bold prose-strong:text-gray-900
                   prose-em:italic prose-em:text-gray-700
                   prose-a:text-blue-600 prose-a:underline hover:prose-a:text-blue-800
                   prose-ul:list-disc prose-ul:ml-5 prose-ul:text-gray-700
                   prose-ol:list-decimal prose-ol:ml-5 prose-ol:text-gray-700
                   prose-li:text-gray-700 prose-li:leading-7
                   prose-blockquote:border-l-4 prose-blockquote:border-gray-300 prose-blockquote:pl-4 prose-blockquote:italic"
        />
        
        <!-- Fallback: plaintext paragraphs -->
        <p
            v-for="(para, index) in paragraphs"
            v-else
            :key="index"
            class="text-gray-700 leading-8 text-base text-justify sm:text-lg"
        >
            {{ para }}
        </p>
    </article>
</template>
