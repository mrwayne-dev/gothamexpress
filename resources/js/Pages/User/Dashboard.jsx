import { Head } from '@inertiajs/react';
import { Package } from '@phosphor-icons/react';
import { UserLayout } from '@/Layouts/UserLayout';
import { Card } from '@/Components/Data/Card';
import { EmptyState } from '@/Components/Primitives/EmptyState';

export default function Dashboard() {
    return (
        <>
            <Head title="Dashboard" />
            <UserLayout title="Dashboard" breadcrumb="Account">
                <Card>
                    <Card.Header>Welcome to Gotham Express</Card.Header>
                    <Card.Body>
                        <EmptyState
                            icon={Package}
                            title="Your tracking view opens on Day 5"
                            message="The live world-map tracker, package list, and payments arrive with Day 5. For now, your account is ready."
                        />
                    </Card.Body>
                </Card>
            </UserLayout>
        </>
    );
}
