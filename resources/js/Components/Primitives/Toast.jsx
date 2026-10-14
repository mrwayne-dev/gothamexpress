import { CheckCircle, Info, Warning, WarningCircle, X } from '@phosphor-icons/react';
import { useToast } from '@/Hooks/useToast';
import { cn } from '@/Lib/cn';

const ICONS = {
    success: CheckCircle,
    error: WarningCircle,
    warning: Warning,
    info: Info,
};

export function ToastContainer() {
    const { toasts, dismiss } = useToast();

    if (!toasts?.length) return null;

    return (
        <div className="ge-toast-container" role="region" aria-label="Notifications" aria-live="polite">
            {toasts.map((t) => {
                const Icon = ICONS[t.tone] || Info;
                return (
                    <div key={t.id} className={cn('ge-toast', `ge-toast--${t.tone}`)}>
                        <Icon className="ge-toast__icon" weight="bold" />
                        <div className="ge-toast__body">
                            {t.title ? <strong>{t.title}</strong> : null}
                            {t.title ? <div>{t.message}</div> : t.message}
                        </div>
                        <button
                            type="button"
                            className="ge-toast__close"
                            onClick={() => dismiss(t.id)}
                            aria-label="Dismiss"
                        >
                            <X weight="bold" />
                        </button>
                    </div>
                );
            })}
        </div>
    );
}
