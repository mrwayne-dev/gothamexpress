import { createContext, useCallback, useContext, useRef, useState } from 'react';

const ConfirmCtx = createContext(null);

export function useConfirm() {
    const ctx = useContext(ConfirmCtx);
    if (!ctx) {
        throw new Error('useConfirm must be used inside <ConfirmProvider>');
    }
    return ctx.confirm;
}

export function ConfirmProvider({ children }) {
    const [state, setState] = useState(null);
    const resolver = useRef(null);

    const confirm = useCallback(
        (opts = {}) =>
            new Promise((resolve) => {
                setState({
                    title: opts.title || 'Are you sure?',
                    message: opts.message || '',
                    confirmLabel: opts.confirmLabel || 'Confirm',
                    cancelLabel: opts.cancelLabel || 'Cancel',
                    danger: Boolean(opts.danger),
                });
                resolver.current = resolve;
            }),
        [],
    );

    const close = useCallback(
        (result) => {
            setState(null);
            if (resolver.current) {
                resolver.current(result);
                resolver.current = null;
            }
        },
        [],
    );

    return (
        <ConfirmCtx.Provider value={{ confirm }}>
            {children}
            {state ? <ConfirmSheet {...state} onCancel={() => close(false)} onConfirm={() => close(true)} /> : null}
        </ConfirmCtx.Provider>
    );
}

/* Lightweight dialog — avoids importing Modal to break cycles. */
function ConfirmSheet({ title, message, confirmLabel, cancelLabel, danger, onCancel, onConfirm }) {
    return (
        <div className="ge-modal-overlay" role="dialog" aria-modal="true" onClick={onCancel}>
            <div
                className="ge-modal ge-modal--sm"
                onClick={(e) => e.stopPropagation()}
                role="document"
            >
                <div className="ge-modal__header">
                    <h3 className="ge-modal__title">{title}</h3>
                </div>
                {message ? <div className="ge-modal__body">{message}</div> : null}
                <div className="ge-modal__footer">
                    <button type="button" className="ge-btn ge-btn--outline ge-btn--md" onClick={onCancel}>
                        {cancelLabel}
                    </button>
                    <button
                        type="button"
                        className={`ge-btn ge-btn--md ${danger ? 'ge-btn--danger' : 'ge-btn--primary'}`}
                        onClick={onConfirm}
                        autoFocus
                    >
                        {confirmLabel}
                    </button>
                </div>
            </div>
        </div>
    );
}
