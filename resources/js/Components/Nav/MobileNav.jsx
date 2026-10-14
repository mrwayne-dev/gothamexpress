import { Link, usePage } from '@inertiajs/react';
import { cn } from '@/Lib/cn';

export function MobileNav({ items = [], className }) {
    const { url } = usePage();
    return (
        <nav className={cn('ge-mobile-nav', className)} aria-label="Mobile navigation">
            {items.map((item) => {
                const Icon = item.icon;
                const active = url === item.href || url.startsWith(`${item.href}/`);
                return (
                    <Link
                        key={item.href}
                        href={item.href}
                        className={cn('ge-mobile-nav__item', active && 'ge-mobile-nav__item--active')}
                    >
                        {Icon ? <Icon className="ge-mobile-nav__icon" weight={active ? 'fill' : 'bold'} /> : null}
                        <span>{item.label}</span>
                    </Link>
                );
            })}
        </nav>
    );
}
