import { useCallback, useRef, useState } from 'react';

export function useClipboard({ resetMs = 2000 } = {}) {
    const [copied, setCopied] = useState(false);
    const timer = useRef(null);

    const copy = useCallback(
        async (text) => {
            if (!text) return false;
            try {
                await navigator.clipboard.writeText(String(text));
                setCopied(true);
                if (timer.current) clearTimeout(timer.current);
                timer.current = setTimeout(() => setCopied(false), resetMs);
                return true;
            } catch {
                return false;
            }
        },
        [resetMs],
    );

    return { copied, copy };
}
