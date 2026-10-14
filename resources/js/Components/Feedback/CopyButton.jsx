import { Check, Copy } from '@phosphor-icons/react';
import { useClipboard } from '@/Hooks/useClipboard';
import { cn } from '@/Lib/cn';

export function CopyButton({ value, label = 'Copy', className }) {
    const { copied, copy } = useClipboard();
    return (
        <button
            type="button"
            className={cn('ge-copy-btn', copied && 'ge-copy-btn--copied', className)}
            onClick={() => copy(value)}
            aria-label={copied ? 'Copied' : label}
            title={copied ? 'Copied' : label}
        >
            {copied ? <Check weight="bold" size={12} /> : <Copy weight="bold" size={12} />}
            <span>{copied ? 'Copied' : label}</span>
        </button>
    );
}
