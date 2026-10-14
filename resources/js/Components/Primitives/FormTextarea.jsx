import { forwardRef, useId } from 'react';
import { cn } from '@/Lib/cn';
import { FormField } from './FormField';

export const FormTextarea = forwardRef(function FormTextarea(
    {
        id,
        label,
        required,
        error,
        help,
        className,
        rows = 4,
        maxLength,
        showCount = false,
        value = '',
        ...rest
    },
    ref,
) {
    const autoId = useId();
    const taId = id || autoId;
    return (
        <FormField id={taId} label={label} required={required} error={error} help={help}>
            <textarea
                ref={ref}
                id={taId}
                rows={rows}
                maxLength={maxLength}
                value={value}
                className={cn('ge-textarea', error && 'ge-textarea--error', className)}
                required={required}
                {...rest}
            />
            {showCount && maxLength ? (
                <span className="ge-textarea__count">
                    {String(value).length}/{maxLength}
                </span>
            ) : null}
        </FormField>
    );
});
