/**
 * Lightweight stylised world map used in the marketing Clients section.
 * Hand-drawn simplified continent silhouettes (not geographically precise)
 * + a handful of operation-point markers with halos.
 *
 * Day-5's tracking page gets a precise world map via react-simple-maps.
 * This is only for marketing; keeping it ~3KB inline.
 */
export function WorldMapMini({ markers = DEFAULT_MARKERS }) {
    return (
        <svg
            viewBox="0 0 1000 460"
            xmlns="http://www.w3.org/2000/svg"
            aria-label="Operations map"
            role="img"
        >
            <g className="ge-fm__map-country">
                {/* North America */}
                <path d="M60,80 L150,55 L240,70 L295,120 L310,180 L270,230 L220,245 L170,250 L130,220 L95,180 L75,130 Z" />
                {/* Central America */}
                <path d="M220,250 L240,275 L255,310 L275,330 L260,350 L240,335 L230,310 L215,290 Z" />
                {/* South America */}
                <path d="M270,335 L310,330 L340,355 L365,400 L355,440 L320,445 L295,430 L285,405 L278,375 Z" />
                {/* Europe */}
                <path d="M480,105 L540,95 L585,110 L590,140 L560,165 L520,170 L495,160 L475,140 Z" />
                {/* Africa */}
                <path d="M500,175 L560,170 L600,195 L625,245 L625,295 L610,335 L585,370 L555,385 L530,370 L510,335 L495,290 L490,235 Z" />
                {/* Middle East + South-west Asia bridge */}
                <path d="M600,170 L645,170 L680,195 L690,225 L670,240 L635,230 L610,205 Z" />
                {/* Asia (bulk) */}
                <path d="M620,100 L720,80 L820,95 L880,130 L905,175 L890,220 L855,250 L800,255 L745,245 L705,220 L680,195 L650,165 L625,135 Z" />
                {/* India */}
                <path d="M720,240 L755,250 L745,285 L725,290 L710,275 L705,255 Z" />
                {/* Southeast Asia */}
                <path d="M820,255 L870,260 L895,285 L880,310 L855,315 L825,300 L810,280 Z" />
                {/* Australia */}
                <path d="M860,345 L920,335 L955,355 L955,390 L920,405 L875,395 L855,375 Z" />
                {/* Japan */}
                <path d="M905,165 L925,160 L935,180 L925,200 L910,195 L900,180 Z" />
                {/* UK + Ireland */}
                <path d="M460,100 L475,95 L480,115 L470,125 L458,118 Z" />
                {/* Greenland */}
                <path d="M330,30 L390,25 L420,55 L410,90 L370,95 L340,75 Z" />
            </g>

            {markers.map((m, i) => (
                <g key={i} transform={`translate(${m.x} ${m.y})`}>
                    <circle className="ge-fm__map-halo" r="18" />
                    <circle className="ge-fm__map-dot" r="4.5" />
                </g>
            ))}
        </svg>
    );
}

const DEFAULT_MARKERS = [
    { x: 220, y: 170, label: 'Dallas' },     // North America
    { x: 325, y: 390, label: 'São Paulo' },  // South America
    { x: 540, y: 135, label: 'London' },     // Europe
    { x: 585, y: 300, label: 'Lagos' },      // Africa
    { x: 680, y: 215, label: 'Dubai' },      // Middle East
    { x: 735, y: 265, label: 'Mumbai' },     // India
    { x: 835, y: 185, label: 'Shanghai' },   // East Asia
    { x: 910, y: 375, label: 'Sydney' },     // Australia
];
