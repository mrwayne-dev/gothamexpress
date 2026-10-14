import { cn } from '@/Lib/cn';

export function Badge({ tone = 'neutral', size = 'md', dot = false, children, className }) {
    return (
        <span className={cn('ge-badge', `ge-badge--${tone}`, size === 'sm' && 'ge-badge--sm', className)}>
            {dot ? <span className="ge-badge__dot" /> : null}
            {children}
        </span>
    );
}

/** Status badge helper — maps a status string to the right tone + label. */
const STATUS_TONE_MAP = {
    processing: 'warning',
    in_transit: 'info',
    delivered: 'success',
    cancelled: 'neutral',
    unpaid: 'warning',
    paid: 'success',
    pending: 'info',
    confirmed: 'success',
    failed: 'error',
    expired: 'neutral',
};

const STATUS_LABEL_MAP = {
    in_transit: 'In transit',
};

export function StatusBadge({ status, className }) {
    const key = String(status || '').toLowerCase();
    const tone = STATUS_TONE_MAP[key] || 'neutral';
    const label = STATUS_LABEL_MAP[key] || key.replace(/_/g, ' ');
    return <Badge tone={tone} className={className}>{label}</Badge>;
}
