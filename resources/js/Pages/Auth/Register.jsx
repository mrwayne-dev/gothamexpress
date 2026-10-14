import { Head, Link, useForm } from '@inertiajs/react';
import { AuthLayout } from '@/Layouts/AuthLayout';
import { Button } from '@/Components/Primitives/Button';
import { FormInput } from '@/Components/Primitives/FormInput';

export default function Register() {
    const form = useForm({
        name: '',
        email: '',
        phone: '',
        location: '',
        password: '',
        password_confirmation: '',
    });

    const submit = (e) => {
        e.preventDefault();
        form.post('/register');
    };

    return (
        <>
            <Head title="Create account" />
            <AuthLayout
                title="Create your account"
                subtitle="A 6-digit code will be sent to your email to confirm it's you."
                altAction={<>Already have an account? <Link href="/login">Log in</Link></>}
            >
                <form onSubmit={submit} className="stack-lg">
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
                        autoComplete="email"
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
                            placeholder="City, Country"
                            value={form.data.location}
                            onChange={(e) => form.setData('location', e.target.value)}
                            error={form.errors.location}
                        />
                    </div>
                    <FormInput
                        label="Password"
                        type="password"
                        autoComplete="new-password"
                        required
                        value={form.data.password}
                        onChange={(e) => form.setData('password', e.target.value)}
                        error={form.errors.password}
                        help="At least 8 characters."
                    />
                    <FormInput
                        label="Confirm password"
                        type="password"
                        autoComplete="new-password"
                        required
                        value={form.data.password_confirmation}
                        onChange={(e) => form.setData('password_confirmation', e.target.value)}
                    />
                    <Button type="submit" fullWidth size="lg" loading={form.processing}>Create account</Button>
                </form>
            </AuthLayout>
        </>
    );
}
