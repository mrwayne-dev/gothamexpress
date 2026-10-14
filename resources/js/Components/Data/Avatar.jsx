import { cn } from '@/Lib/cn';

function initials(name) {
    if (!name) return '?';
    return String(name)
        .trim()
        .split(/\s+/)
        .slice(0, 2)
        .map((part) => part[0]?.toUpperCase() || '')
        .join('');
}

function hueFromName(name) {
    let h = 0;
    for (let i = 0; i < (name || '').length; i++) h = (h * 31 + name.charCodeAt(i)) % 360;
    return h;
}

export function Avatar({ name, src, alt, size = 'md', className }) {
    const style = src
        ? undefined
        : {
              background: `hsl(${hueFromName(name)} 65% 45%)`,
          };
    return (
        <span className={cn('ge-avatar', `ge-avatar--${size}`, className)} style={style} aria-label={alt || name}>
            {src ? <img src={src} alt={alt || name} /> : <span>{initials(name)}</span>}
        </span>
    );
}
