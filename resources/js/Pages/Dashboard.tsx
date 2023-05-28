import { Head } from '@inertiajs/react';
// import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
// import { PageProps } from '@/types';

import Layout from '@/Layouts/Layout';
import TimeManagement from './TimeManagement/TimeManagement';

type DashboardPropsType = {
  targetTime: any;
  weeklyTime: number;
};

export default function Dashboard({
  targetTime,
  weeklyTime
}: DashboardPropsType) {
  // const { auth } = pageprops;
  return (
    <Layout>
      <Head title="Dashboard" />
      <TimeManagement targetTime={targetTime} weeklyTime={weeklyTime} />
    </Layout>
  );
}
