import { format } from 'date-fns';
import { Button } from '@mui/material';

import useModal from '@/Hooks/useModal';
import type { MonthyTimeListTableProps } from '@/types/MonthlyTime/MonthlyTimeType';
import TimeDeleteModal from '@/Components/Modal/TimeDeleteModal';

function MonthyTimeListTable({ thisMonthInfos }: MonthyTimeListTableProps) {
  const [Modal, open, close, isOpen] = useModal();

  return (
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
              {thisMonthInfo.rest_time === null ? '-' : thisMonthInfo.rest_time}
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
              <Button
                type="button"
                onClick={open}
                disabled={
                  thisMonthInfo.research_time === null &&
                  thisMonthInfo.rest_time == null
                }
                variant="contained"
                color="error"
              >
                削除
              </Button>
              <Modal>
                <TimeDeleteModal
                  id={thisMonthInfo.id}
                  modalIsOpen={isOpen}
                  setModalIsOpen={close}
                />
              </Modal>
            </td>
          </tr>
        ))}
      </tbody>
    </table>
  );
}

export default MonthyTimeListTable;
