import { CaretDown, CaretUp } from '@phosphor-icons/react';
import { cn } from '@/Lib/cn';

/**
 * Compositional DataTable.
 * Low-coupling shell: parent passes `columns`, `rows`, `renderCell`, optional toolbar.
 * Sort/filter state is parent-owned (see useFilters / usePagination).
 */
export function DataTable({
    columns = [],
    rows = [],
    getRowKey = (r, i) => r.id ?? i,
    renderCell,
    emptyMessage = 'Nothing to show',
    sort,
    onSort,
    toolbar,
    footer,
    className,
}) {
    return (
        <div className={cn('ge-table-wrap', className)}>
            {toolbar ? <div className="ge-table-toolbar">{toolbar}</div> : null}
            <div className="ge-table-scroll">
                <table className="ge-table">
                    <thead>
                        <tr>
                            {columns.map((col) => (
                                <th
                                    key={col.key}
                                    className={cn(col.sortable && 'ge-table__th--sortable')}
                                    onClick={col.sortable ? () => onSort?.(col.key) : undefined}
                                    style={col.width ? { width: col.width } : undefined}
                                >
                                    <span className="cluster-sm">
                                        {col.label}
                                        {col.sortable && sort?.key === col.key ? (
                                            sort.dir === 'desc' ? <CaretDown weight="bold" /> : <CaretUp weight="bold" />
                                        ) : null}
                                    </span>
                                </th>
                            ))}
                        </tr>
                    </thead>
                    <tbody>
                        {rows.length === 0 ? (
                            <tr>
                                <td colSpan={columns.length} className="ge-table__empty">
                                    {emptyMessage}
                                </td>
                            </tr>
                        ) : (
                            rows.map((row, idx) => (
                                <tr key={getRowKey(row, idx)}>
                                    {columns.map((col) => (
                                        <td key={col.key} data-label={col.label}>
                                            {renderCell ? renderCell(row, col, idx) : row[col.key]}
                                        </td>
                                    ))}
                                </tr>
                            ))
                        )}
                    </tbody>
                </table>
            </div>
            {footer ? footer : null}
        </div>
    );
}
