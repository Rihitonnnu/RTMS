import { Head } from '@inertiajs/react';
// import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
// import { PageProps } from '@/types';

import TimeManagement from './TimeManagement/TimeManagement';

type DashboardPropsType = {
  targetTime: any;
  weeklyTime: number;
};

export default function Dashboard(
  // pageprops: PageProps,
  { targetTime, weeklyTime }: DashboardPropsType
) {
  // const { auth } = pageprops;
  return (
    <>
      {/* <AuthenticatedLayout user={auth.user}> */}
      <Head title="Dashboard" />
      <TimeManagement targetTime={targetTime} weeklyTime={weeklyTime} />
      {/* </AuthenticatedLayout> */}
    </>
  );
}
