import { Fragment } from 'react';
import { Link } from '@inertiajs/react';
import { CaretRight } from '@phosphor-icons/react';
import { cn } from '@/Lib/cn';

/**
 * items: [{ label, href? }]  — last item is treated as current page
 */
export function Breadcrumb({ items = [], className }) {
    if (!items.length) return null;
    return (
        <nav className={cn('ge-breadcrumb', className)} aria-label="Breadcrumb">
            {items.map((item, i) => {
                const last = i === items.length - 1;
                return (
                    <Fragment key={`${item.label}-${i}`}>
                        {item.href && !last ? (
                            <Link href={item.href}>{item.label}</Link>
                        ) : (
                            <span className={last ? 'ge-breadcrumb__current' : undefined}>{item.label}</span>
                        )}
                        {!last ? (
                            <span className="ge-breadcrumb__separator" aria-hidden="true">
                                <CaretRight weight="bold" size={10} />
                            </span>
                        ) : null}
                    </Fragment>
                );
            })}
        </nav>
    );
}
