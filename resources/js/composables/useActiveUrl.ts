import { toUrl } from '@/lib/utils';
import type { InertiaLinkProps } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { computed, readonly } from 'vue';

const page = usePage();
const currentUrlReactive = computed(
    () => new URL(page.url, window?.location.origin).pathname,
);

export function useActiveUrl() {
    function urlIsActive(
        urlToCheck: NonNullable<InertiaLinkProps['href']>,
        currentUrl?: string,
    ) {
        const urlToCompare = currentUrl ?? currentUrlReactive.value;
        const urlToCheckPath = toUrl(urlToCheck);

        // Exact match
        if (urlToCheckPath === urlToCompare) {
            return true;
        }

        // Check if current URL starts with the menu URL (for subpages)
        if (urlToCompare.startsWith(urlToCheckPath + '/')) {
            return true;
        }

        return false;
    }

    return {
        currentUrl: readonly(currentUrlReactive),
        urlIsActive,
    };
}
