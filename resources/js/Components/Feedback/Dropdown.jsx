import { useEffect, useRef, useState } from 'react';
import { cn } from '@/Lib/cn';

export function Dropdown({ trigger, children, align = 'right', className }) {
    const [open, setOpen] = useState(false);
    const ref = useRef(null);

    useEffect(() => {
        if (!open) return;
        const onDoc = (e) => {
            if (ref.current && !ref.current.contains(e.target)) setOpen(false);
        };
        const onKey = (e) => {
            if (e.key === 'Escape') setOpen(false);
        };
        document.addEventListener('mousedown', onDoc);
        document.addEventListener('keydown', onKey);
        return () => {
            document.removeEventListener('mousedown', onDoc);
            document.removeEventListener('keydown', onKey);
        };
    }, [open]);

    return (
        <div className={cn('ge-dropdown', className)} ref={ref}>
            {trigger({ open, toggle: () => setOpen((o) => !o) })}
            {open ? (
                <div
                    className={cn('ge-dropdown__panel', align === 'left' && 'ge-dropdown__panel--left')}
                    role="menu"
                >
                    {typeof children === 'function' ? children({ close: () => setOpen(false) }) : children}
                </div>
            ) : null}
        </div>
    );
}

Dropdown.Item = function Item({ children, onClick, danger = false, icon }) {
    return (
        <button type="button" role="menuitem" className={cn('ge-dropdown__item', danger && 'ge-dropdown__item--danger')} onClick={onClick}>
            {icon ? <span>{icon}</span> : null}
            {children}
        </button>
    );
};

Dropdown.Divider = function Divider() {
    return <div className="ge-dropdown__divider" />;
};
