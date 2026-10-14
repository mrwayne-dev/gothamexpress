import { cn } from '@/Lib/cn';

/**
 * Wraps native <input type="date"> for consistent styling.
 * Range mode shows two inputs separated by an em-dash.
 */
export function DatePicker({ value, onChange, rangeMode = false, startValue, endValue, onStartChange, onEndChange, className }) {
    if (rangeMode) {
        return (
            <div className={cn('ge-datepicker', className)}>
                <input type="date" value={startValue || ''} onChange={(e) => onStartChange?.(e.target.value)} />
                <span aria-hidden="true">—</span>
                <input type="date" value={endValue || ''} onChange={(e) => onEndChange?.(e.target.value)} />
            </div>
        );
    }
    return (
        <div className={cn('ge-datepicker', className)}>
            <input type="date" value={value || ''} onChange={(e) => onChange?.(e.target.value)} />
        </div>
    );
}
