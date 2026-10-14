import { Moon, Sun } from '@phosphor-icons/react';
import { useTheme } from '@/Hooks/useTheme';
import { cn } from '@/Lib/cn';

export function ThemeToggle({ className }) {
    const { theme, toggle } = useTheme();
    const isDark = theme === 'dark';
    return (
        <button
            type="button"
            className={cn('ge-theme-toggle', className)}
            onClick={toggle}
            aria-label={isDark ? 'Switch to light mode' : 'Switch to dark mode'}
            title={isDark ? 'Switch to light mode' : 'Switch to dark mode'}
        >
            {isDark ? <Sun weight="bold" /> : <Moon weight="bold" />}
        </button>
    );
}
