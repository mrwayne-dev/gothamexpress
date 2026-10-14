import { useEffect, useRef, useState } from 'react';
import { cn } from '@/Lib/cn';

/**
 * 6-digit verification code input.
 * Auto-advances, supports paste, backspace to previous box, error shake.
 *
 * Props:
 *   value: string (controlled; must be 0..6 numeric chars)
 *   onChange(nextValue)
 *   onComplete(code6)
 *   length: 6 (default)
 *   error: boolean
 *   autoFocus: boolean
 */
export function CodeInput({ value = '', onChange, onComplete, length = 6, error = false, autoFocus = false }) {
    const refs = useRef([]);
    const [internal, setInternal] = useState(value);

    useEffect(() => {
        setInternal(value);
    }, [value]);

    useEffect(() => {
        if (autoFocus) {
            refs.current[0]?.focus();
        }
    }, [autoFocus]);

    function commit(next) {
        setInternal(next);
        onChange?.(next);
        if (next.length === length) {
            onComplete?.(next);
        }
    }

    function handleChange(e, idx) {
        const raw = e.target.value.replace(/\D/g, '');
        if (!raw) return;
        const digit = raw.slice(-1);
        const arr = internal.padEnd(length, ' ').split('');
        arr[idx] = digit;
        const next = arr.join('').replace(/\s+$/, '').slice(0, length);
        commit(next);
        if (idx < length - 1) {
            refs.current[idx + 1]?.focus();
        }
    }

    function handleKeyDown(e, idx) {
        if (e.key === 'Backspace') {
            if (internal[idx]) {
                const arr = internal.split('');
                arr[idx] = '';
                commit(arr.join(''));
            } else if (idx > 0) {
                refs.current[idx - 1]?.focus();
                const arr = internal.split('');
                arr[idx - 1] = '';
                commit(arr.join(''));
            }
        } else if (e.key === 'ArrowLeft' && idx > 0) {
            refs.current[idx - 1]?.focus();
        } else if (e.key === 'ArrowRight' && idx < length - 1) {
            refs.current[idx + 1]?.focus();
        }
    }

    function handlePaste(e) {
        const text = (e.clipboardData.getData('text') || '').replace(/\D/g, '').slice(0, length);
        if (!text) return;
        e.preventDefault();
        commit(text);
        const focusIdx = Math.min(text.length, length - 1);
        refs.current[focusIdx]?.focus();
    }

    return (
        <div className={cn('ge-code-input', error && 'ge-code-input--error')} onPaste={handlePaste}>
            {Array.from({ length }).map((_, idx) => (
                <input
                    key={idx}
                    ref={(el) => (refs.current[idx] = el)}
                    className="ge-code-input__box"
                    type="text"
                    inputMode="numeric"
                    pattern="[0-9]*"
                    maxLength={1}
                    value={internal[idx] || ''}
                    onChange={(e) => handleChange(e, idx)}
                    onKeyDown={(e) => handleKeyDown(e, idx)}
                    aria-label={`Digit ${idx + 1}`}
                />
            ))}
        </div>
    );
}
