import { cn } from '@/Lib/cn';

/** Wrapper that provides label + error + help text for form controls. */
export function FormField({ id, label, required, error, help, className, children }) {
    return (
        <div className={cn('ge-field', className)}>
            {label ? (
                <label className="ge-field__label" htmlFor={id}>
                    {label}
                    {required ? <span className="ge-field__required" aria-hidden="true">*</span> : null}
                </label>
            ) : null}
            {children}
            {error ? (
                <span className="ge-field__error" role="alert">
                    {error}
                </span>
            ) : help ? (
                <span className="ge-field__help">{help}</span>
            ) : null}
        </div>
    );
}
