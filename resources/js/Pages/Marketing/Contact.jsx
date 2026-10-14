import { Head, useForm } from '@inertiajs/react';
import { Clock, EnvelopeSimple, MapPin, PaperPlaneTilt, Phone } from '@phosphor-icons/react';
import { PublicLayout } from '@/Layouts/PublicLayout';
import { Button } from '@/Components/Primitives/Button';
import { FormInput } from '@/Components/Primitives/FormInput';
import { FormSelect } from '@/Components/Primitives/FormSelect';
import { FormTextarea } from '@/Components/Primitives/FormTextarea';
import { Alert } from '@/Components/Feedback/Alert';
import { useToast } from '@/Hooks/useToast';

export default function Contact({ flash }) {
    const toast = useToast();
    const form = useForm({ firstname: '', email: '', inquiry: '', message: '' });

    const submit = (e) => {
        e.preventDefault();
        form.post('/contact', {
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
                toast.success('Message sent');
            },
        });
    };

    return (
        <>
            <Head title="Contact us" />
            <PublicLayout>
                <section className="ge-page-hero">
                    <div className="container">
                        <span className="ge-page-hero__eyebrow">Get in touch</span>
                        <h1 className="ge-page-hero__title">We'd love to hear from you.</h1>
                        <p className="ge-page-hero__sub">
                            Questions about shipping, partnerships, invoicing or an existing package — our team responds within 24–48 hours.
                        </p>
                    </div>
                </section>

                <div className="container">
                    <div className="ge-contact">
                        <div className="ge-contact__info">
                            <ContactItem icon={EnvelopeSimple} title="Email">support@gotham.mgbah.dev</ContactItem>
                            <ContactItem icon={Phone} title="Phone">+1 (800) 555-0199</ContactItem>
                            <ContactItem icon={MapPin} title="Office">2400 Industrial Blvd, Dallas, TX 75207</ContactItem>
                            <ContactItem icon={Clock} title="Hours">Mon–Fri · 8:00 AM – 6:00 PM CST</ContactItem>
                        </div>

                        <form className="ge-contact__form" onSubmit={submit}>
                            {flash?.success ? <Alert tone="success">{flash.success}</Alert> : null}
                            <FormInput
                                label="First name"
                                required
                                value={form.data.firstname}
                                onChange={(e) => form.setData('firstname', e.target.value)}
                                error={form.errors.firstname}
                            />
                            <FormInput
                                label="Email"
                                type="email"
                                required
                                value={form.data.email}
                                onChange={(e) => form.setData('email', e.target.value)}
                                error={form.errors.email}
                            />
                            <FormSelect
                                label="Inquiry type"
                                required
                                placeholder="Pick a topic"
                                value={form.data.inquiry}
                                onChange={(e) => form.setData('inquiry', e.target.value)}
                                error={form.errors.inquiry}
                                options={[
                                    { value: 'general', label: 'General inquiry' },
                                    { value: 'tracking', label: 'Package tracking' },
                                    { value: 'shipping', label: 'Shipping rates' },
                                    { value: 'partnership', label: 'Partnership' },
                                    { value: 'complaint', label: 'Complaint' },
                                ]}
                            />
                            <FormTextarea
                                label="Message"
                                required
                                rows={5}
                                showCount
                                maxLength={5000}
                                value={form.data.message}
                                onChange={(e) => form.setData('message', e.target.value)}
                                error={form.errors.message}
                            />
                            <Button type="submit" fullWidth size="lg" loading={form.processing} icon={<PaperPlaneTilt weight="bold" />}>
                                Send message
                            </Button>
                        </form>
                    </div>
                </div>
            </PublicLayout>
        </>
    );
}

function ContactItem({ icon: Icon, title, children }) {
    return (
        <div className="ge-contact__item">
            <span className="ge-contact__item-icon"><Icon weight="bold" /></span>
            <div>
                <h5>{title}</h5>
                <p>{children}</p>
            </div>
        </div>
    );
}
