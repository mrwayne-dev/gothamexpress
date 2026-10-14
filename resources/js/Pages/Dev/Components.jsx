import { useState } from 'react';
import { Head } from '@inertiajs/react';
import {
    Bell, CheckCircle, Gear, House, Info, Package, GearSix, Truck, Warning,
} from '@phosphor-icons/react';

import { Button } from '@/Components/Primitives/Button';
import { FormInput } from '@/Components/Primitives/FormInput';
import { FormSelect } from '@/Components/Primitives/FormSelect';
import { FormTextarea } from '@/Components/Primitives/FormTextarea';
import { FormCheckbox } from '@/Components/Primitives/FormCheckbox';
import { CodeInput } from '@/Components/Primitives/CodeInput';
import { Badge, StatusBadge } from '@/Components/Primitives/Badge';
import { Loader } from '@/Components/Primitives/Loader';
import { EmptyState } from '@/Components/Primitives/EmptyState';
import { Modal } from '@/Components/Primitives/Modal';

import { Card } from '@/Components/Data/Card';
import { StatCard } from '@/Components/Data/StatCard';
import { Timeline } from '@/Components/Data/Timeline';
import { StatusTracker } from '@/Components/Data/StatusTracker';
import { DataTable } from '@/Components/Data/DataTable';
import { Pagination } from '@/Components/Data/Pagination';
import { PackageCard } from '@/Components/Data/PackageCard';
import { WalletAddressCard } from '@/Components/Data/WalletAddressCard';
import { Avatar } from '@/Components/Data/Avatar';
import { Tag } from '@/Components/Data/Tag';

import { Breadcrumb } from '@/Components/Nav/Breadcrumb';
import { Tabs } from '@/Components/Nav/Tabs';
import { ThemeToggle } from '@/Components/Nav/ThemeToggle';

import { AmountDisplay } from '@/Components/Feedback/AmountDisplay';
import { Alert } from '@/Components/Feedback/Alert';
import { Progress } from '@/Components/Feedback/Progress';
import { Dropdown } from '@/Components/Feedback/Dropdown';
import { CopyButton } from '@/Components/Feedback/CopyButton';
import { FileUpload } from '@/Components/Feedback/FileUpload';
import { SearchBar } from '@/Components/Feedback/SearchBar';
import { DatePicker } from '@/Components/Feedback/DatePicker';
import { Tooltip } from '@/Components/Feedback/Tooltip';
import { QRDisplay } from '@/Components/Feedback/QRDisplay';
import { useToast } from '@/Hooks/useToast';
import { useConfirm } from '@/Hooks/useConfirm';

const TOKEN_COLORS = [
    ['Black', '--color-black'],
    ['Blue', '--color-blue'],
    ['Orange', '--color-orange'],
    ['Peach', '--color-peach'],
    ['White', '--color-white'],
    ['Gray 100', '--color-gray-100'],
    ['Gray 400', '--color-gray-400'],
    ['Gray 600', '--color-gray-600'],
    ['Gray 800', '--color-gray-800'],
    ['Success', '--color-success'],
    ['Error', '--color-error'],
    ['Warning', '--color-warning'],
    ['Info', '--color-info'],
];

export default function ComponentsGallery() {
    const toast = useToast();
    const confirm = useConfirm();
    const [modal, setModal] = useState(false);
    const [code, setCode] = useState('');
    const [search, setSearch] = useState('');
    const [tab, setTab] = useState('one');
    const [date, setDate] = useState('');

    const samplePackage = {
        id: 1,
        tracking_id: 'GTX-7A3F9B2C',
        package_name: 'Vinyl boxed set',
        amount: 275.5,
        status: 'in_transit',
        payment_status: 'paid',
        firstname: 'Bruce',
        lastname: 'Wayne',
        location: 'Gotham, NY',
    };

    const sampleWallet = {
        currency: 'USDT',
        network: 'TRC20',
        address: 'TXYZabcdef1234567890PLACEHOLDER',
        label: 'Operations',
    };

    const sampleRows = Array.from({ length: 3 }).map((_, i) => ({
        id: i + 1,
        payment_id: `pay_${(i + 1).toString().padStart(5, '0')}abcdef`,
        payer_email: `user${i + 1}@example.com`,
        amount: 100 + i * 50,
        currency: 'USD',
        payment_method: ['USDT', 'BTC', 'ETH'][i],
        payment_status: ['pending', 'confirmed', 'failed'][i],
        created_at: new Date().toISOString(),
    }));

    const columns = [
        { key: 'payment_id', label: 'Payment ID' },
        { key: 'payer_email', label: 'Email', sortable: true },
        { key: 'amount', label: 'Amount' },
        { key: 'payment_method', label: 'Method' },
        { key: 'payment_status', label: 'Status' },
    ];

    return (
        <>
            <Head title="Component gallery" />
            <div className="ge-dev">
                <header className="ge-dev__header">
                    <div>
                        <h1 className="ge-dev__title">Gotham Express — component gallery</h1>
                        <p className="text-muted text-sm">Every Day-1 component with its states. Toggle themes to verify dark mode.</p>
                    </div>
                    <ThemeToggle />
                </header>

                <Section title="Colour tokens">
                    <div className="ge-dev__chips">
                        {TOKEN_COLORS.map(([name, v]) => (
                            <div key={v} className="ge-dev__chip">
                                <div className="ge-dev__chip-swatch" style={{ background: `var(${v})` }} />
                                <div><strong>{name}</strong></div>
                                <code className="text-subtle">{v}</code>
                            </div>
                        ))}
                    </div>
                </Section>

                <Section title="Buttons">
                    <Chip title="Primary · sm/md/lg">
                        <Button size="sm">Small</Button>
                        <Button>Default</Button>
                        <Button size="lg">Large</Button>
                    </Chip>
                    <Chip title="Variants">
                        <Button variant="primary">Primary</Button>
                        <Button variant="secondary">Secondary</Button>
                        <Button variant="outline">Outline</Button>
                        <Button variant="ghost">Ghost</Button>
                        <Button variant="danger">Danger</Button>
                        <Button variant="inverse">Inverse</Button>
                    </Chip>
                    <Chip title="States">
                        <Button loading>Loading</Button>
                        <Button disabled>Disabled</Button>
                    </Chip>
                </Section>

                <Section title="Form controls">
                    <Chip title="Text input">
                        <FormInput label="Email" type="email" placeholder="you@example.com" />
                    </Chip>
                    <Chip title="With error">
                        <FormInput label="Email" value="not-an-email" onChange={() => {}} error="Enter a valid email" />
                    </Chip>
                    <Chip title="Select">
                        <FormSelect
                            label="Shipping"
                            placeholder="Choose a method"
                            options={['Standard', 'Express', 'Overnight']}
                        />
                    </Chip>
                    <Chip title="Textarea">
                        <FormTextarea label="Notes" rows={3} placeholder="Anything to add?" />
                    </Chip>
                    <Chip title="Checkbox">
                        <FormCheckbox label="Email me about new features" defaultChecked />
                    </Chip>
                    <Chip title="6-digit code">
                        <CodeInput value={code} onChange={setCode} />
                    </Chip>
                    <Chip title="SearchBar">
                        <SearchBar value={search} onChange={setSearch} placeholder="Search packages…" />
                    </Chip>
                    <Chip title="DatePicker">
                        <DatePicker value={date} onChange={setDate} />
                    </Chip>
                    <Chip title="FileUpload" wide>
                        <FileUpload />
                    </Chip>
                </Section>

                <Section title="Badges & tags">
                    <Chip title="Status badges">
                        <StatusBadge status="processing" />
                        <StatusBadge status="in_transit" />
                        <StatusBadge status="delivered" />
                        <StatusBadge status="cancelled" />
                        <StatusBadge status="unpaid" />
                        <StatusBadge status="paid" />
                    </Chip>
                    <Chip title="Dot badges">
                        <Badge tone="success" dot>Live</Badge>
                        <Badge tone="error" dot>Down</Badge>
                        <Badge tone="warning" dot>Warn</Badge>
                        <Badge tone="info" dot>Info</Badge>
                    </Chip>
                    <Chip title="Tags">
                        <Tag>design</Tag>
                        <Tag onRemove={() => {}}>engineering</Tag>
                    </Chip>
                    <Chip title="Avatars">
                        <Avatar name="Bruce Wayne" size="xs" />
                        <Avatar name="Bruce Wayne" size="sm" />
                        <Avatar name="Bruce Wayne" size="md" />
                        <Avatar name="Bruce Wayne" size="lg" />
                    </Chip>
                </Section>

                <Section title="Feedback">
                    <Chip title="Alerts" wide>
                        <div className="stack-sm" style={{ width: '100%' }}>
                            <Alert tone="info" title="Info">Default advisory banner.</Alert>
                            <Alert tone="success" title="Success">Thing happened.</Alert>
                            <Alert tone="warning" title="Warning">Thing might happen.</Alert>
                            <Alert tone="error" title="Error" dismissible>Thing broke.</Alert>
                        </div>
                    </Chip>
                    <Chip title="Toasts">
                        <Button onClick={() => toast.success('Saved')}>Success</Button>
                        <Button variant="secondary" onClick={() => toast.error('Failed')}>Error</Button>
                        <Button variant="outline" onClick={() => toast.info('FYI')}>Info</Button>
                        <Button variant="ghost" onClick={() => toast.warning('Careful')}>Warning</Button>
                    </Chip>
                    <Chip title="Confirm">
                        <Button
                            onClick={async () => {
                                const ok = await confirm({
                                    title: 'Delete this record?',
                                    message: 'This can\'t be undone.',
                                    danger: true,
                                    confirmLabel: 'Delete',
                                });
                                toast.info(ok ? 'Confirmed' : 'Cancelled');
                            }}
                        >
                            Open confirm
                        </Button>
                    </Chip>
                    <Chip title="Modal">
                        <Button onClick={() => setModal(true)}>Open modal</Button>
                        <Modal open={modal} onClose={() => setModal(false)} title="A sample modal" size="md">
                            <Modal.Body>
                                <p>Modals centre on desktop and slide up from the bottom on mobile.</p>
                            </Modal.Body>
                            <Modal.Footer>
                                <Button variant="outline" onClick={() => setModal(false)}>Cancel</Button>
                                <Button onClick={() => setModal(false)}>OK</Button>
                            </Modal.Footer>
                        </Modal>
                    </Chip>
                    <Chip title="Progress">
                        <div style={{ width: 240 }}><Progress value={62} /></div>
                        <div style={{ width: 240 }}><Progress indeterminate /></div>
                    </Chip>
                    <Chip title="Loader">
                        <Loader mode="spinner" />
                        <Loader mode="skeleton" width={160} height={24} />
                    </Chip>
                    <Chip title="Tooltip">
                        <Tooltip label="A helpful tooltip">
                            <Button variant="outline">Hover me</Button>
                        </Tooltip>
                    </Chip>
                    <Chip title="Dropdown">
                        <Dropdown
                            trigger={({ toggle }) => (
                                <Button variant="outline" onClick={toggle}>Actions</Button>
                            )}
                        >
                            <Dropdown.Item icon={<GearSix weight="bold" size={14} />}>Edit</Dropdown.Item>
                            <Dropdown.Divider />
                            <Dropdown.Item danger>Delete</Dropdown.Item>
                        </Dropdown>
                    </Chip>
                    <Chip title="Copy">
                        <CopyButton value="GTX-7A3F9B2C" />
                    </Chip>
                </Section>

                <Section title="Data display">
                    <Chip title="StatCards" wide>
                        <div className="grid grid-4" style={{ width: '100%' }}>
                            <StatCard icon={Package} value="128" label="Packages" trend={{ value: '+12%', direction: 'up' }} />
                            <StatCard icon={Truck} value="54" label="In transit" />
                            <StatCard icon={CheckCircle} value="68" label="Delivered" />
                            <StatCard icon={Gear} value="6" label="Processing" />
                        </div>
                    </Chip>
                    <Chip title="Grid StatCards" wide>
                        <div className="grid grid-4" style={{ width: '100%', border: '1px solid var(--border)', borderRadius: 'var(--radius-lg)' }}>
                            <StatCard variant="grid" value="700M" label="Users" />
                            <StatCard variant="grid" value="100+" label="Clients" />
                            <StatCard variant="grid" value="30+" label="Markets" />
                            <StatCard variant="grid" value="24/7" label="Support" />
                        </div>
                    </Chip>
                    <Chip title="Status tracker" wide>
                        <div className="stack-sm" style={{ width: '100%' }}>
                            <StatusTracker status="processing" />
                            <StatusTracker status="in_transit" />
                            <StatusTracker status="delivered" />
                        </div>
                    </Chip>
                    <Chip title="Timeline">
                        <Timeline
                            items={[
                                { title: 'Order received', timestamp: 'Mon · 9:12 AM', state: 'completed' },
                                { title: 'Picked up by carrier', timestamp: 'Tue · 1:08 PM', state: 'completed' },
                                { title: 'In transit', timestamp: 'Wed · 3:45 PM', state: 'active', notes: 'Routed via Dallas' },
                                { title: 'Out for delivery', timestamp: '—', state: 'pending' },
                            ]}
                        />
                    </Chip>
                    <Chip title="PackageCard">
                        <PackageCard pkg={samplePackage} />
                    </Chip>
                    <Chip title="WalletAddressCard">
                        <WalletAddressCard wallet={sampleWallet} />
                    </Chip>
                    <Chip title="QRDisplay (Day-1 stub)">
                        <QRDisplay value="https://gotham.mgbah.dev/track/GTX-7A3F9B2C" />
                    </Chip>
                    <Chip title="AmountDisplay">
                        <AmountDisplay value={1250.75} currency="USD" />
                    </Chip>
                    <Chip title="DataTable" wide>
                        <div style={{ width: '100%' }}>
                            <DataTable columns={columns} rows={sampleRows} />
                        </div>
                    </Chip>
                    <Chip title="Pagination" wide>
                        <div style={{ width: '100%' }}>
                            <Pagination meta={{ current_page: 2, last_page: 7, per_page: 25, total: 170 }} />
                        </div>
                    </Chip>
                </Section>

                <Section title="Navigation">
                    <Chip title="Breadcrumb" wide>
                        <Breadcrumb items={[{ label: 'Admin', href: '/admin/dashboard' }, { label: 'Packages', href: '/admin/packages' }, { label: 'GTX-7A3F9B2C' }]} />
                    </Chip>
                    <Chip title="Tabs" wide>
                        <Tabs
                            value={tab}
                            onChange={setTab}
                            items={[
                                { key: 'one', label: 'Overview' },
                                { key: 'two', label: 'Activity' },
                                { key: 'three', label: 'Settings' },
                            ]}
                        />
                    </Chip>
                </Section>

                <Section title="Empty states">
                    <Chip title="Default" wide>
                        <div style={{ width: '100%' }}>
                            <EmptyState icon={Bell} title="No notifications" message="You're all caught up." />
                        </div>
                    </Chip>
                </Section>
            </div>
        </>
    );
}

function Section({ title, children }) {
    return (
        <section className="ge-dev__section">
            <div className="ge-dev__section-title">{title}</div>
            <div className="ge-dev__grid">{children}</div>
        </section>
    );
}

function Chip({ title, wide = false, children }) {
    return (
        <div className="ge-dev__card" style={wide ? { gridColumn: '1 / -1' } : undefined}>
            <div className="ge-dev__card-title">{title}</div>
            <div className="ge-dev__card-body">{children}</div>
        </div>
    );
}
