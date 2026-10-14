import { forwardRef, useId } from 'react';

export const FormCheckbox = forwardRef(function FormCheckbox(
    { id, label, checked, onChange, disabled, ...rest },
    ref,
) {
    const autoId = useId();
    const cbId = id || autoId;
    return (
        <label htmlFor={cbId} className="ge-checkbox">
            <input
                ref={ref}
                id={cbId}
                type="checkbox"
                checked={checked}
                onChange={onChange}
                disabled={disabled}
                {...rest}
            />
            {label ? <span>{label}</span> : null}
        </label>
    );
});
