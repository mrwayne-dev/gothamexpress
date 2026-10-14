import { Head, useForm } from '@inertiajs/react';
import { AuthLayout } from '@/Layouts/AuthLayout';
import { Button } from '@/Components/Primitives/Button';
import { FormInput } from '@/Components/Primitives/FormInput';
import { Alert } from '@/Components/Feedback/Alert';

export default function ResetPassword({ email, flash }) {
    const form = useForm({ password: '', password_confirmation: '' });

    const submit = (e) => {
        e.preventDefault();
        form.post('/reset-password');
    };

    return (
        <>
            <Head title="Reset password" />
            <AuthLayout
                title="Set a new password"
                subtitle={email ? `For ${email}.` : null}
            >
                {flash?.error ? <Alert tone="error">{flash.error}</Alert> : null}
                <form onSubmit={submit} className="stack-lg">
                    <FormInput
                        label="New password"
                        type="password"
                        autoComplete="new-password"
                        required
                        value={form.data.password}
                        onChange={(e) => form.setData('password', e.target.value)}
                        error={form.errors.password}
                        help="At least 8 characters."
                    />
                    <FormInput
                        label="Confirm new password"
                        type="password"
                        autoComplete="new-password"
                        required
                        value={form.data.password_confirmation}
                        onChange={(e) => form.setData('password_confirmation', e.target.value)}
                    />
                    <Button type="submit" fullWidth size="lg" loading={form.processing}>Update password</Button>
                </form>
            </AuthLayout>
        </>
    );
}
