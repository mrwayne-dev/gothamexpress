import { Head, Link, useForm } from '@inertiajs/react';
import { AuthLayout } from '@/Layouts/AuthLayout';
import { Button } from '@/Components/Primitives/Button';
import { FormInput } from '@/Components/Primitives/FormInput';
import { Alert } from '@/Components/Feedback/Alert';

export default function Login({ flash }) {
    const form = useForm({ email: '', password: '', remember: false });

    const submit = (e) => {
        e.preventDefault();
        form.post('/login');
    };

    return (
        <>
            <Head title="Log in" />
            <AuthLayout
                title="Welcome back"
                subtitle="Sign in to your Gotham Express account."
                altAction={<>No account? <Link href="/register">Create one</Link></>}
            >
                {flash?.info ? <Alert tone="info">{flash.info}</Alert> : null}
                {flash?.success ? <Alert tone="success">{flash.success}</Alert> : null}

                <form onSubmit={submit} className="stack-lg">
                    <FormInput
                        label="Email"
                        type="email"
                        name="email"
                        autoComplete="email"
                        required
                        value={form.data.email}
                        onChange={(e) => form.setData('email', e.target.value)}
                        error={form.errors.email}
                    />
                    <FormInput
                        label="Password"
                        type="password"
                        name="password"
                        autoComplete="current-password"
                        required
                        value={form.data.password}
                        onChange={(e) => form.setData('password', e.target.value)}
                        error={form.errors.password}
                    />
                    <div className="cluster-sm" style={{ justifyContent: 'space-between' }}>
                        <label className="ge-checkbox">
                            <input
                                type="checkbox"
                                checked={form.data.remember}
                                onChange={(e) => form.setData('remember', e.target.checked)}
                            />
                            <span className="text-sm">Remember me</span>
                        </label>
                        <Link href="/forgot-password" className="text-sm">Forgot password?</Link>
                    </div>
                    <Button type="submit" fullWidth size="lg" loading={form.processing}>Sign in</Button>
                </form>
            </AuthLayout>
        </>
    );
}
