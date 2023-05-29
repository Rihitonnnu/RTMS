import ja, { format } from 'date-fns';
import { Button } from '@mui/material';
import { router } from '@inertiajs/react';

import Layout from '@/Layouts/Layout';
import type { MonthlyTimeListPageProps } from '@/types/MonthlyTime/MonthlyTimeType';

function MonthlyTimeListPage({ thisMonthInfos }: MonthlyTimeListPageProps) {
  const handleSubmit = (id: number) => {
    const method = { _method: 'DELETE' };
    router.post(route('dailyTime.destroy', id), method);
  };
  return (
    <Layout>
      <div className="max-w-7xl w-5/6 mx-auto mt-10 sm:px-6 lg:px-8 flex justify-evenly items-center">
        {/* 今月の研究時間の合計を表示するようにしたい */}
        <table className="w-full table-border table-fixed">
          <thead className="bg-blue-200">
            <tr>
              <th className="py-2 table-border">日付</th>
              <th className="table-border">研究時間(H)</th>
              <th className="table-border">休憩時間(H)</th>
              <th className="table-border">合計研究時間(H)</th>
              <th className="table-border"> </th>
              <th className="table-border"> </th>
            </tr>
          </thead>
          <tbody>
            {thisMonthInfos.map((thisMonthInfo) => (
              <tr key={thisMonthInfo.id} className="text-center">
                <td className="py-2 border border-gray-300">
                  {format(new Date(thisMonthInfo.date), 'MM/dd')}
                </td>
                <td className="table-border border border-gray-300">
                  {thisMonthInfo.research_time === null
                    ? '-'
                    : thisMonthInfo.research_time}
                </td>
                <td className="table-border border border-gray-300">
                  {thisMonthInfo.rest_time === null
                    ? '-'
                    : thisMonthInfo.rest_time}
                </td>
                <td className="table-border border border-gray-300">
                  {thisMonthInfo.research_time === null ||
                  thisMonthInfo.rest_time === null
                    ? '-'
                    : thisMonthInfo.research_time - thisMonthInfo.rest_time}
                </td>
                <td className="py-1 table-border border border-gray-300">
                  <Button
                    variant="contained"
                    color="primary"
                    href={route('dailyTime.edit', thisMonthInfo.id)}
                  >
                    編集
                  </Button>
                </td>
                <td className="py-1 table-border border border-gray-300">
                  <form onSubmit={() => handleSubmit(thisMonthInfo.id)}>
                    <Button
                      type="submit"
                      disabled={
                        thisMonthInfo.research_time === null &&
                        thisMonthInfo.rest_time == null
                      }
                      variant="contained"
                      color="error"
                    >
                      削除
                    </Button>
                  </form>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </Layout>
  );
}

export default MonthlyTimeListPage;
