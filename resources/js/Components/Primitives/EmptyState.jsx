import { Package } from '@phosphor-icons/react';
import { cn } from '@/Lib/cn';

export function EmptyState({ icon, title, message, action, className }) {
    const Icon = icon || Package;
    return (
        <div className={cn('ge-empty', className)}>
            <span className="ge-empty__icon">
                <Icon weight="bold" />
            </span>
            {title ? <div className="ge-empty__title">{title}</div> : null}
            {message ? <p className="ge-empty__message">{message}</p> : null}
            {action ? <div>{action}</div> : null}
        </div>
    );
}
