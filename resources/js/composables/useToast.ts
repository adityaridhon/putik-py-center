import { usePage } from '@inertiajs/vue3';
import { watch } from 'vue';
import { toast } from 'vue-sonner';

interface FlashMessages {
    success?: string;
    error?: string;
    info?: string;
    warning?: string;
}

/**
 * Composable untuk menangani flash messages dari backend
 * dan menampilkannya sebagai toast notifications
 */
export function useFlashMessages() {
    const page = usePage();

    watch(
        () => page.props.flash as FlashMessages | undefined,
        (flash: FlashMessages | undefined) => {
            if (!flash) return;

            // Success message
            if (flash.success) {
                toast.success(flash.success);
            }

            // Error message
            if (flash.error) {
                toast.error(flash.error);
            }

            // Info message
            if (flash.info) {
                toast.info(flash.info);
            }

            // Warning message
            if (flash.warning) {
                toast.warning(flash.warning);
            }
        },
        { deep: true, immediate: true },
    );
}

/**
 * Export toast functions untuk manual usage
 */
export { toast };
