import { Head, router, useForm } from '@inertiajs/react';
import { AuthLayout } from '@/Layouts/AuthLayout';
import { Button } from '@/Components/Primitives/Button';
import { CodeInput } from '@/Components/Primitives/CodeInput';
import { Alert } from '@/Components/Feedback/Alert';

export default function VerifyEmail({ email, flash }) {
    const form = useForm({ code: '' });

    const submit = (e) => {
        e.preventDefault();
        form.post('/verify-email');
    };

    const resend = () => router.post('/verify-email/resend');

    return (
        <>
            <Head title="Verify email" />
            <AuthLayout
                title="Verify your email"
                subtitle={email ? `We sent a 6-digit code to ${email}.` : 'Enter the 6-digit code sent to your inbox.'}
                altAction={<button type="button" className="ge-btn ge-btn--ghost ge-btn--sm" onClick={resend}>Resend code</button>}
            >
                {flash?.success ? <Alert tone="success">{flash.success}</Alert> : null}
                {flash?.info ? <Alert tone="info">{flash.info}</Alert> : null}
                <form onSubmit={submit} className="stack-lg">
                    <CodeInput
                        autoFocus
                        value={form.data.code}
                        onChange={(v) => form.setData('code', v)}
                        onComplete={(v) => {
                            form.setData('code', v);
                            form.post('/verify-email', { data: { code: v } });
                        }}
                        error={!!form.errors.code}
                    />
                    {form.errors.code ? <div className="ge-field__error">{form.errors.code}</div> : null}
                    <Button type="submit" fullWidth size="lg" loading={form.processing}>Verify</Button>
                </form>
            </AuthLayout>
        </>
    );
}
