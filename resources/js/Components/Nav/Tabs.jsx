import { useState } from 'react';
import { cn } from '@/Lib/cn';

/**
 * items: [{ key, label }]
 * controlled: value + onChange; uncontrolled: defaultValue
 */
export function Tabs({ items = [], value, defaultValue, onChange, className }) {
    const [internal, setInternal] = useState(defaultValue || items[0]?.key);
    const current = value !== undefined ? value : internal;
    const handle = (key) => {
        if (value === undefined) setInternal(key);
        onChange?.(key);
    };
    return (
        <div className={cn('ge-tabs', className)} role="tablist">
            {items.map((item) => (
                <button
                    key={item.key}
                    type="button"
                    role="tab"
                    aria-selected={current === item.key}
                    className={cn('ge-tabs__btn', current === item.key && 'ge-tabs__btn--active')}
                    onClick={() => handle(item.key)}
                >
                    {item.label}
                </button>
            ))}
        </div>
    );
}

Tabs.Panel = function Panel({ value, when, children }) {
    if (value !== when) return null;
    return <div role="tabpanel">{children}</div>;
};
