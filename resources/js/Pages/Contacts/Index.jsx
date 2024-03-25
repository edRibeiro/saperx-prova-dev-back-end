import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, router, usePage } from '@inertiajs/react';

export default function Index() {
    const handleImageError = () => {
        document.getElementById('screenshot-container')?.classList.add('!hidden');
        document.getElementById('docs-card')?.classList.add('!row-span-1');
        document.getElementById('docs-card-content')?.classList.add('!flex-row');
        document.getElementById('background')?.classList.add('!hidden');
    };
    const { contacts } = usePage().props;

    if (!contacts || !Array.isArray(contacts)) {
        return <div>Loading...</div>;
    }

    function deleteContact(id) {
        router.delete(`/contacts/${id}`);
    }

    return (
        <GuestLayout>
            <Head title="Contatos" />
            <div>
                <h2 className="text-xl font-semibold text-black dark:text-white">
                    Contatos
                </h2>
                <table className="table-auto w-full">
                    <thead>
                        <tr>
                            <th className="px-4 py-2 bg-gray-200">Nome</th>
                            <th className="px-4 py-2 bg-gray-200">E-mail</th>
                            <th className="px-4 py-2 bg-gray-200">Telefones</th>
                            <th className="px-4 py-2 bg-gray-200">Data de nascimento</th>
                        </tr>
                    </thead>
                    <tbody>
                        {contacts.map(contact => (
                            <tr key={contact.id}>
                                <td className="border px-4 py-2">{contact.name}</td>
                                <td className="border px-4 py-2">{contact.email}</td>
                                <td className="border px-4 py-2">{contact.phones.join(', ')}</td>
                                <td className="border px-4 py-2">{new Date(contact.birth_date).toLocaleDateString()}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </GuestLayout>
    );
}
