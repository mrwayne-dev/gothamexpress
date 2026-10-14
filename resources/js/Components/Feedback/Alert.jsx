import { useState } from 'react';
import { CheckCircle, Info, Warning, WarningCircle, X } from '@phosphor-icons/react';
import { cn } from '@/Lib/cn';

const ICONS = {
    info: Info,
    success: CheckCircle,
    warning: Warning,
    error: WarningCircle,
};

export function Alert({ tone = 'info', title, children, dismissible = false, className }) {
    const [open, setOpen] = useState(true);
    if (!open) return null;
    const Icon = ICONS[tone] || Info;
    return (
        <div className={cn('ge-alert', `ge-alert--${tone}`, className)} role="alert">
            <Icon weight="bold" size={18} />
            <div className="ge-alert__body">
                {title ? <strong className="ge-alert__title">{title}</strong> : null}
                {children}
            </div>
            {dismissible ? (
                <button type="button" className="ge-alert__dismiss" onClick={() => setOpen(false)} aria-label="Dismiss">
                    <X weight="bold" size={14} />
                </button>
            ) : null}
        </div>
    );
}
