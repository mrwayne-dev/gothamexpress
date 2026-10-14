import { cn } from '@/Lib/cn';

export function AmountDisplay({ value, currency = 'USD', showCurrency = true, className, locale }) {
    const num = Number(value) || 0;
    const formatter = new Intl.NumberFormat(locale, {
        style: 'currency',
        currency,
        maximumFractionDigits: 2,
    });
    const [whole, suffix] = formatter.format(num).split(/\s/);
    return (
        <span className={cn('ge-amount', 'tabular-nums', className)}>
            {whole}
            {showCurrency && suffix ? <span className="ge-amount__currency">{suffix}</span> : null}
        </span>
    );
}
