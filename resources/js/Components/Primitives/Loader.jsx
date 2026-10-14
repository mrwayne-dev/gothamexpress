import { cn } from '@/Lib/cn';

/** mode: 'bar' | 'skeleton' | 'spinner' */
export function Loader({ mode = 'spinner', className, width, height, ...rest }) {
    if (mode === 'bar') {
        return <div className={cn('ge-loader-bar', className)} role="progressbar" aria-label="Loading" {...rest} />;
    }
    if (mode === 'skeleton') {
        return (
            <div
                className={cn('ge-skeleton', className)}
                style={{ width: width || '100%', height: height || 16 }}
                aria-hidden="true"
                {...rest}
            />
        );
    }
    return (
        <span
            className={cn('ge-spinner', className)}
            role="status"
            aria-label="Loading"
            {...rest}
        />
    );
}
