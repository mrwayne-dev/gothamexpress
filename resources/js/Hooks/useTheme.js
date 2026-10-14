import { useCallback, useEffect, useState } from 'react';

const STORAGE_KEY = 'ge-theme';

function readInitialTheme(fallback = 'light') {
    if (typeof document === 'undefined') return fallback;
    const current = document.documentElement.dataset.theme;
    if (current === 'light' || current === 'dark') return current;
    try {
        const stored = localStorage.getItem(STORAGE_KEY);
        if (stored === 'light' || stored === 'dark') return stored;
    } catch {
        /* ignore */
    }
    return fallback;
}

function applyTheme(next) {
    if (typeof document === 'undefined') return;
    document.documentElement.dataset.theme = next;
    try {
        localStorage.setItem(STORAGE_KEY, next);
        // Persist to a cookie so the server can echo data-theme on first paint
        document.cookie = `ge-theme=${next};path=/;max-age=${60 * 60 * 24 * 365};samesite=lax`;
    } catch {
        /* ignore */
    }
}

export function useTheme(initial = 'light') {
    const [theme, setThemeState] = useState(() => readInitialTheme(initial));

    useEffect(() => {
        applyTheme(theme);
    }, [theme]);

    const setTheme = useCallback((next) => setThemeState(next === 'dark' ? 'dark' : 'light'), []);
    const toggle = useCallback(() => setThemeState((t) => (t === 'dark' ? 'light' : 'dark')), []);

    return { theme, setTheme, toggle, isDark: theme === 'dark' };
}
