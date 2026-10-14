import { Fragment } from 'react';
import { CheckCircle, Gear, Truck } from '@phosphor-icons/react';
import { cn } from '@/Lib/cn';

const STEPS = [
    { key: 'processing', label: 'Processing', Icon: Gear },
    { key: 'in_transit', label: 'Shipped', Icon: Truck },
    { key: 'delivered', label: 'Delivered', Icon: CheckCircle },
];

/** status: 'processing' | 'in_transit' | 'delivered' | 'cancelled' */
export function StatusTracker({ status = 'processing', className }) {
    const idx = STEPS.findIndex((s) => s.key === status);
    const activeIdx = idx === -1 ? 0 : idx;
    return (
        <div className={cn('ge-tracker', className)}>
            {STEPS.map((s, i) => {
                const state = i < activeIdx ? 'completed' : i === activeIdx ? 'active' : 'pending';
                return (
                    <Fragment key={s.key}>
                        <div className={cn('ge-tracker__step', `ge-tracker__step--${state}`)}>
                            <span className="ge-tracker__dot">
                                <s.Icon weight="bold" />
                            </span>
                            <span className="ge-tracker__label">{s.label}</span>
                        </div>
                        {i < STEPS.length - 1 ? (
                            <span
                                className={cn(
                                    'ge-tracker__bar',
                                    i < activeIdx && 'ge-tracker__bar--complete',
                                    i === activeIdx && 'ge-tracker__bar--active',
                                )}
                            />
                        ) : null}
                    </Fragment>
                );
            })}
        </div>
    );
}
