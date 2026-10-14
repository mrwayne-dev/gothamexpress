import { createContext, useCallback, useContext, useMemo, useRef, useState } from 'react';

const ToastCtx = createContext(null);

/** Returns toast dispatch helpers. Must be used inside <ToastProvider>. */
export function useToast() {
    const ctx = useContext(ToastCtx);
    if (!ctx) {
        throw new Error('useToast must be used inside <ToastProvider>');
    }
    return ctx;
}

export function ToastProvider({ children }) {
    const [toasts, setToasts] = useState([]);
    const nextId = useRef(1);

    const dismiss = useCallback((id) => {
        setToasts((list) => list.filter((t) => t.id !== id));
    }, []);

    const push = useCallback(
        (tone, message, { duration = 4000, title } = {}) => {
            const id = nextId.current++;
            setToasts((list) => [...list, { id, tone, message, title }]);
            if (duration > 0) {
                setTimeout(() => dismiss(id), duration);
            }
            return id;
        },
        [dismiss],
    );

    const api = useMemo(
        () => ({
            toasts,
            dismiss,
            success: (msg, opts) => push('success', msg, opts),
            error: (msg, opts) => push('error', msg, opts),
            info: (msg, opts) => push('info', msg, opts),
            warning: (msg, opts) => push('warning', msg, opts),
        }),
        [toasts, push, dismiss],
    );

    return <ToastCtx.Provider value={api}>{children}</ToastCtx.Provider>;
}
