import { Head } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { PageProps } from '@/types';
import ManagementButtonList from '@/Features/Management/Component/ManagementButtonList';

export default function Dashboard({ auth }: PageProps) {
  return (
    <AuthenticatedLayout user={auth.user}>
      <Head title="Dashboard" />
      <ManagementButtonList />
    </AuthenticatedLayout>
  );
}
