import { Head, Link, useForm } from '@inertiajs/react';
import { AuthLayout } from '@/Layouts/AuthLayout';
import { Button } from '@/Components/Primitives/Button';
import { CodeInput } from '@/Components/Primitives/CodeInput';
import { Alert } from '@/Components/Feedback/Alert';

export default function VerifyResetCode({ email, flash }) {
    const form = useForm({ email: email || '', code: '' });

    const submit = (e) => {
        e.preventDefault();
        form.post('/verify-reset-code');
    };

    return (
        <>
            <Head title="Verify reset code" />
            <AuthLayout
                title="Enter your reset code"
                subtitle={email ? `We sent a 6-digit code to ${email}.` : 'Enter the 6-digit code we sent.'}
                altAction={<Link href="/forgot-password">Didn't get it? Try again</Link>}
            >
                {flash?.info ? <Alert tone="info">{flash.info}</Alert> : null}
                <form onSubmit={submit} className="stack-lg">
                    <CodeInput
                        autoFocus
                        value={form.data.code}
                        onChange={(v) => form.setData('code', v)}
                        onComplete={(v) => {
                            form.setData('code', v);
                            form.post('/verify-reset-code', { data: { email: form.data.email, code: v } });
                        }}
                        error={!!form.errors.code}
                    />
                    {form.errors.code ? <div className="ge-field__error">{form.errors.code}</div> : null}
                    <Button type="submit" fullWidth size="lg" loading={form.processing}>Verify code</Button>
                </form>
            </AuthLayout>
        </>
    );
}
