import { forwardRef, useId } from 'react';
import { cn } from '@/Lib/cn';
import { FormField } from './FormField';

export const FormSelect = forwardRef(function FormSelect(
    { id, label, required, error, help, options = [], placeholder, className, children, ...rest },
    ref,
) {
    const autoId = useId();
    const selectId = id || autoId;
    return (
        <FormField id={selectId} label={label} required={required} error={error} help={help}>
            <select
                ref={ref}
                id={selectId}
                className={cn('ge-select', error && 'ge-select--error', className)}
                required={required}
                {...rest}
            >
                {placeholder ? (
                    <option value="" disabled>
                        {placeholder}
                    </option>
                ) : null}
                {options.map((opt) =>
                    typeof opt === 'string' ? (
                        <option key={opt} value={opt}>
                            {opt}
                        </option>
                    ) : (
                        <option key={opt.value} value={opt.value} disabled={opt.disabled}>
                            {opt.label}
                        </option>
                    ),
                )}
                {children}
            </select>
        </FormField>
    );
});
