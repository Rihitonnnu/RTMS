import { Head } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { PageProps } from '@/types';
import TimeManagement from '@/Features/Management/Component/TimeManagement';

export default function Dashboard({ auth }: PageProps) {
  return (
    <AuthenticatedLayout user={auth.user}>
      <Head title="Dashboard" />
      <TimeManagement />
    </AuthenticatedLayout>
  );
}
