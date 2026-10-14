import { List } from '@phosphor-icons/react';
import { cn } from '@/Lib/cn';

export function Header({ title, breadcrumb, actions, onToggleSidebar, className }) {
    return (
        <header className={cn('ge-header', className)}>
            <div className="ge-header__left">
                {onToggleSidebar ? (
                    <button
                        type="button"
                        className="ge-sidebar-drawer-trigger"
                        onClick={onToggleSidebar}
                        aria-label="Open menu"
                    >
                        <List weight="bold" />
                    </button>
                ) : null}
                <div>
                    {breadcrumb ? <div className="text-xs text-muted">{breadcrumb}</div> : null}
                    {title ? <h1 className="ge-header__title">{title}</h1> : null}
                </div>
            </div>
            {actions ? <div className="ge-header__right">{actions}</div> : null}
        </header>
    );
}
