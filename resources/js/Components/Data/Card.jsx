import { cn } from '@/Lib/cn';

/** Card with Header, Body, Footer slots. */
export function Card({ variant = 'bordered', className, children, ...rest }) {
    return (
        <div className={cn('ge-card', variant !== 'bordered' && `ge-card--${variant}`, className)} {...rest}>
            {children}
        </div>
    );
}

Card.Header = function Header({ className, children, actions }) {
    return (
        <div className={cn('ge-card__header', className)}>
            <div className="ge-card__title">{children}</div>
            {actions ? <div className="cluster-sm">{actions}</div> : null}
        </div>
    );
};

Card.Body = function Body({ className, flush = false, children }) {
    return <div className={cn('ge-card__body', flush && 'ge-card__body--flush', className)}>{children}</div>;
};

Card.Footer = function Footer({ className, children }) {
    return <div className={cn('ge-card__footer', className)}>{children}</div>;
};
