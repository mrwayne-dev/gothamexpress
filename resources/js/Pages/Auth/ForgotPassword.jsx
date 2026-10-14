import { Head, Link, useForm } from '@inertiajs/react';
import { AuthLayout } from '@/Layouts/AuthLayout';
import { Button } from '@/Components/Primitives/Button';
import { FormInput } from '@/Components/Primitives/FormInput';
import { Alert } from '@/Components/Feedback/Alert';

export default function ForgotPassword({ flash }) {
    const form = useForm({ email: '' });

    const submit = (e) => {
        e.preventDefault();
        form.post('/forgot-password');
    };

    return (
        <>
            <Head title="Forgot password" />
            <AuthLayout
                title="Reset your password"
                subtitle="Enter your email and we'll send you a 6-digit code."
                altAction={<Link href="/login">Back to log in</Link>}
            >
                {flash?.info ? <Alert tone="info">{flash.info}</Alert> : null}
                <form onSubmit={submit} className="stack-lg">
                    <FormInput
                        label="Email"
                        type="email"
                        required
                        value={form.data.email}
                        onChange={(e) => form.setData('email', e.target.value)}
                        error={form.errors.email}
                    />
                    <Button type="submit" fullWidth size="lg" loading={form.processing}>Send reset code</Button>
                </form>
            </AuthLayout>
        </>
    );
}
