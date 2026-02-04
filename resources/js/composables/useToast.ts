import { usePage } from '@inertiajs/vue3';
import { watch } from 'vue';
import { toast } from 'vue-sonner';

/**
 * Composable untuk menangani flash messages dari backend
 * dan menampilkannya sebagai toast notifications
 */
export function useFlashMessages() {
    const page = usePage();

    console.log('useFlashMessages initialized');
    console.log('Initial flash props:', page.props.flash);

    // Watch for flash messages dari backend
    watch(
        () => page.props.flash,
        (flash) => {
            console.log('Flash watcher triggered:', flash);

            if (!flash) return;

            // Success message
            if (flash.success) {
                console.log('Showing success toast:', flash.success);
                toast.success(flash.success);
            }

            // Error message
            if (flash.error) {
                console.log('Showing error toast:', flash.error);
                toast.error(flash.error);
            }

            // Info message
            if (flash.info) {
                console.log('Showing info toast:', flash.info);
                toast.info(flash.info);
            }

            // Warning message
            if (flash.warning) {
                console.log('Showing warning toast:', flash.warning);
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
