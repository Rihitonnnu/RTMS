import Layout from '@/Layouts/Layout';
import type { MonthlyTimeListPageProps } from '@/types/MonthlyTime/MonthlyTimeType';
import MonthyTimeListTable from './MonthyTimeListTable';

function MonthlyTimeListPage({
  thisMonthInfos,
  thisMonthResearchTime
}: MonthlyTimeListPageProps) {
  return (
    <Layout>
      <div className="max-w-7xl w-5/6 mx-auto mt-10 sm:px-6 lg:px-8 justify-evenly items-center">
        <div className="flex items-center mb-3">
          <h1 className="font-bold text-2xl">今月の研究時間</h1>
          <h1 className="ml-3 font-bold text-2xl">{`${thisMonthResearchTime}時間`}</h1>
        </div>
        <MonthyTimeListTable thisMonthInfos={thisMonthInfos} />
      </div>
    </Layout>
  );
}

export default MonthlyTimeListPage;
