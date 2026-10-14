import { forwardRef, useId } from 'react';
import { cn } from '@/Lib/cn';
import { FormField } from './FormField';

export const FormInput = forwardRef(function FormInput(
    { id, label, required, error, help, className, type = 'text', ...rest },
    ref,
) {
    const autoId = useId();
    const inputId = id || autoId;
    return (
        <FormField id={inputId} label={label} required={required} error={error} help={help}>
            <input
                ref={ref}
                id={inputId}
                type={type}
                className={cn('ge-input', error && 'ge-input--error', className)}
                aria-invalid={error ? 'true' : undefined}
                required={required}
                {...rest}
            />
        </FormField>
    );
});
