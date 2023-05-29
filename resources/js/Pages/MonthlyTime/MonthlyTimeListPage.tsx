import Layout from '@/Layouts/Layout';
import type { MonthlyTimeListPageProps } from '@/types/MonthlyTime/MonthlyTimeType';
import MonthyTimeListTable from './MonthyTimeListTable';

function MonthlyTimeListPage({ thisMonthInfos }: MonthlyTimeListPageProps) {
  return (
    <Layout>
      <div className="max-w-7xl w-5/6 mx-auto mt-10 sm:px-6 lg:px-8 flex justify-evenly items-center">
        <MonthyTimeListTable thisMonthInfos={thisMonthInfos} />
      </div>
    </Layout>
  );
}

export default MonthlyTimeListPage;
