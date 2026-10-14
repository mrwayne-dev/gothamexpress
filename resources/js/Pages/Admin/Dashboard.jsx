import { Head } from '@inertiajs/react';
import { Package, Truck, CheckCircle, Hourglass } from '@phosphor-icons/react';
import { AdminLayout } from '@/Layouts/AdminLayout';
import { Card } from '@/Components/Data/Card';
import { StatCard } from '@/Components/Data/StatCard';
import { EmptyState } from '@/Components/Primitives/EmptyState';

export default function Dashboard() {
    return (
        <>
            <Head title="Admin dashboard" />
            <AdminLayout title="Dashboard" breadcrumb="Workspace">
                <div className="stack-lg">
                    <div className="grid grid-4">
                        <StatCard icon={Package} value="0" label="Total packages" />
                        <StatCard icon={Hourglass} value="0" label="Processing" />
                        <StatCard icon={Truck} value="0" label="In transit" />
                        <StatCard icon={CheckCircle} value="0" label="Delivered" />
                    </div>
                    <Card>
                        <Card.Header>Welcome to Gotham Express admin</Card.Header>
                        <Card.Body>
                            <EmptyState
                                title="Day 3 adds package CRUD here"
                                message="This is the Day-1 shell. Create / edit / confirm / audit features come online in Days 3–4."
                            />
                        </Card.Body>
                    </Card>
                </div>
            </AdminLayout>
        </>
    );
}
