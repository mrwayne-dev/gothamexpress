import { Head, Link, useForm } from '@inertiajs/react';
import { AuthLayout } from '@/Layouts/AuthLayout';
import { Button } from '@/Components/Primitives/Button';
import { FormInput } from '@/Components/Primitives/FormInput';

export default function AdminRegister() {
    const form = useForm({
        name: '',
        email: '',
        phone: '',
        location: '',
        password: '',
        password_confirmation: '',
        invite_code: '',
    });

    const submit = (e) => {
        e.preventDefault();
        form.post('/admin/register');
    };

    return (
        <>
            <Head title="Admin registration" />
            <AuthLayout
                title="Admin registration"
                subtitle="Create an admin account using the invite code you were given."
                altAction={<Link href="/login">Back to log in</Link>}
            >
                <form onSubmit={submit} className="stack-lg">
                    <FormInput
                        label="Invite code"
                        required
                        value={form.data.invite_code}
                        onChange={(e) => form.setData('invite_code', e.target.value.toUpperCase())}
                        error={form.errors.invite_code}
                        help="Codes are alphanumeric and single-use. They expire 6 hours after generation."
                    />
                    <FormInput
                        label="Full name"
                        required
                        value={form.data.name}
                        onChange={(e) => form.setData('name', e.target.value)}
                        error={form.errors.name}
                    />
                    <FormInput
                        label="Email"
                        type="email"
                        required
                        value={form.data.email}
                        onChange={(e) => form.setData('email', e.target.value)}
                        error={form.errors.email}
                    />
                    <div className="ge-form-row">
                        <FormInput
                            label="Phone"
                            type="tel"
                            required
                            value={form.data.phone}
                            onChange={(e) => form.setData('phone', e.target.value)}
                            error={form.errors.phone}
                        />
                        <FormInput
                            label="Location"
                            required
                            value={form.data.location}
                            onChange={(e) => form.setData('location', e.target.value)}
                            error={form.errors.location}
                        />
                    </div>
                    <FormInput
                        label="Password"
                        type="password"
                        required
                        value={form.data.password}
                        onChange={(e) => form.setData('password', e.target.value)}
                        error={form.errors.password}
                    />
                    <FormInput
                        label="Confirm password"
                        type="password"
                        required
                        value={form.data.password_confirmation}
                        onChange={(e) => form.setData('password_confirmation', e.target.value)}
                    />
                    <Button type="submit" fullWidth size="lg" loading={form.processing}>Create admin account</Button>
                </form>
            </AuthLayout>
        </>
    );
}
