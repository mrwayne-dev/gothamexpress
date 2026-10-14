import { cn } from '@/Lib/cn';

export function Progress({ value, indeterminate = false, className }) {
    const clamped = Math.min(100, Math.max(0, Number(value) || 0));
    return (
        <div className={cn('ge-progress', indeterminate && 'ge-progress--indeterminate', className)}>
            <div
                className="ge-progress__bar"
                role="progressbar"
                aria-valuenow={indeterminate ? undefined : clamped}
                aria-valuemin={0}
                aria-valuemax={100}
                style={indeterminate ? undefined : { width: `${clamped}%` }}
            />
        </div>
    );
}
