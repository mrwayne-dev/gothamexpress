import { useEffect } from 'react';
import { ToastProvider } from '@/Hooks/useToast';
import { ConfirmProvider } from '@/Hooks/useConfirm';
import { ToastContainer } from '@/Components/Primitives/Toast';

/**
 * Wraps the Inertia page tree with global providers.
 * Also stamps the server-provided theme on <html data-theme> on first paint.
 */
export function AppProviders({ initialTheme = 'light', children }) {
    useEffect(() => {
        if (typeof document === 'undefined') return;
        if (!document.documentElement.dataset.theme) {
            document.documentElement.dataset.theme = initialTheme;
        }
    }, [initialTheme]);

    return (
        <ToastProvider>
            <ConfirmProvider>
                {children}
                <ToastContainer />
            </ConfirmProvider>
        </ToastProvider>
    );
}
