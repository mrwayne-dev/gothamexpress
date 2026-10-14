import { cloneElement, useRef, useState } from 'react';
import { createPortal } from 'react-dom';

export function Tooltip({ children, label }) {
    const [pos, setPos] = useState(null);
    const ref = useRef(null);

    const show = () => {
        const el = ref.current;
        if (!el) return;
        const r = el.getBoundingClientRect();
        setPos({ left: r.left + r.width / 2, top: r.top - 6 });
    };
    const hide = () => setPos(null);

    return (
        <>
            {cloneElement(children, {
                ref,
                onMouseEnter: show,
                onMouseLeave: hide,
                onFocus: show,
                onBlur: hide,
            })}
            {pos && typeof document !== 'undefined'
                ? createPortal(
                      <div
                          className="ge-tooltip"
                          role="tooltip"
                          style={{ left: pos.left, top: pos.top, transform: 'translate(-50%, -100%)' }}
                      >
                          {label}
                      </div>,
                      document.body,
                  )
                : null}
        </>
    );
}
