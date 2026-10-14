import { useEffect, useRef } from 'react';
import { createPortal } from 'react-dom';
import { X } from '@phosphor-icons/react';
import { cn } from '@/Lib/cn';

export function Modal({ open, onClose, size = 'md', children, title, ariaLabel }) {
    const panelRef = useRef(null);

    useEffect(() => {
        if (!open) return;
        const prev = document.body.style.overflow;
        document.body.style.overflow = 'hidden';
        const onKey = (e) => {
            if (e.key === 'Escape') onClose?.();
        };
        document.addEventListener('keydown', onKey);
        return () => {
            document.body.style.overflow = prev;
            document.removeEventListener('keydown', onKey);
        };
    }, [open, onClose]);

    if (!open || typeof document === 'undefined') return null;

    return createPortal(
        <div
            className="ge-modal-overlay"
            role="dialog"
            aria-modal="true"
            aria-label={ariaLabel || title}
            onMouseDown={(e) => {
                if (e.target === e.currentTarget) onClose?.();
            }}
        >
            <div
                ref={panelRef}
                className={cn('ge-modal', `ge-modal--${size}`)}
                onMouseDown={(e) => e.stopPropagation()}
            >
                {title ? (
                    <div className="ge-modal__header">
                        <h3 className="ge-modal__title">{title}</h3>
                        <button type="button" className="ge-modal__close" onClick={onClose} aria-label="Close">
                            <X weight="bold" />
                        </button>
                    </div>
                ) : null}
                {children}
            </div>
        </div>,
        document.body,
    );
}

Modal.Header = function Header({ children, onClose }) {
    return (
        <div className="ge-modal__header">
            <h3 className="ge-modal__title">{children}</h3>
            {onClose ? (
                <button type="button" className="ge-modal__close" onClick={onClose} aria-label="Close">
                    <X weight="bold" />
                </button>
            ) : null}
        </div>
    );
};

Modal.Body = function Body({ children }) {
    return <div className="ge-modal__body">{children}</div>;
};

Modal.Footer = function Footer({ children }) {
    return <div className="ge-modal__footer">{children}</div>;
};
