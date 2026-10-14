import { forwardRef } from 'react';
import { cn } from '@/Lib/cn';

/**
 * Button
 * variant: primary | secondary | outline | ghost | danger | inverse
 * size: sm | md | lg
 */
export const Button = forwardRef(function Button(
    {
        type = 'button',
        variant = 'primary',
        size = 'md',
        loading = false,
        disabled = false,
        fullWidth = false,
        icon = null,
        iconPosition = 'left',
        className,
        children,
        ...rest
    },
    ref,
) {
    const isDisabled = disabled || loading;
    return (
        <button
            ref={ref}
            type={type}
            className={cn(
                'ge-btn',
                `ge-btn--${variant}`,
                `ge-btn--${size}`,
                fullWidth && 'ge-btn--full',
                className,
            )}
            disabled={isDisabled}
            aria-busy={loading || undefined}
            {...rest}
        >
            {loading ? <span className="ge-btn__spinner" aria-hidden="true" /> : icon && iconPosition === 'left' ? icon : null}
            {children ? <span>{children}</span> : null}
            {!loading && icon && iconPosition === 'right' ? icon : null}
        </button>
    );
});
