import { TrendDown, TrendUp } from '@phosphor-icons/react';
import { cn } from '@/Lib/cn';

export function StatCard({
    icon,
    value,
    label,
    trend, // { value: '+12%', direction: 'up'|'down' }
    variant = 'default',
    className,
}) {
    const Icon = icon;
    return (
        <div className={cn('ge-stat', variant === 'grid' && 'ge-stat--grid', className)}>
            {Icon ? (
                <span className="ge-stat__icon">
                    <Icon weight="bold" />
                </span>
            ) : null}
            <div className="ge-stat__value tabular-nums">{value}</div>
            {label ? <div className="ge-stat__label">{label}</div> : null}
            {trend ? (
                <div className={cn('ge-stat__trend', trend.direction === 'down' && 'ge-stat__trend--down')}>
                    {trend.direction === 'down' ? <TrendDown weight="bold" /> : <TrendUp weight="bold" />}
                    <span>{trend.value}</span>
                </div>
            ) : null}
        </div>
    );
}
