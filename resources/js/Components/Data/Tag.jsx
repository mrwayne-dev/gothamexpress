import { X } from '@phosphor-icons/react';
import { cn } from '@/Lib/cn';

export function Tag({ children, onRemove, className }) {
    return (
        <span className={cn('ge-tag', className)}>
            <span>{children}</span>
            {onRemove ? (
                <button type="button" className="ge-tag__remove" onClick={onRemove} aria-label="Remove">
                    <X weight="bold" size={10} />
                </button>
            ) : null}
        </span>
    );
}
