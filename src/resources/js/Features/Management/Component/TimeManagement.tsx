import { Button } from '@mui/material';
import { useState } from 'react';
import { router } from '@inertiajs/react';

import TimeDisplay from './TimeDisplay';
import Flash from '@/Layouts/Flash';
import useMultipleClickPreventer from '@/Hooks/useMultipleClickPreventer';

function TimeManagement() {
  const [open, setOpen] = useState<boolean>(false);
  // ダブルクリック防止
  const onSubmit = useMultipleClickPreventer((link) => {
    if (typeof link === 'string') {
      setOpen(true);
      setTimeout(() => {
        setOpen(false);
      }, 2000);
      router.post(route(link));
    }
  });

  return (
    <div className="py-12">
      <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <Flash open={open} />

        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
          <TimeDisplay />
          <div className="mx-auto mt-3 w-1/3 grid grid-cols-4">
            <div>
              <Button
                variant="contained"
                onClick={() => onSubmit('research.storeStartTime')}
              >
                研究開始
              </Button>
            </div>
            <div>
              <Button
                variant="contained"
                color="error"
                onClick={() => onSubmit('research.storeEndTime')}
              >
                研究終了
              </Button>
            </div>
            <div>
              <Button
                variant="contained"
                color="secondary"
                onClick={() => onSubmit('rest.storeStartTime')}
              >
                休憩開始
              </Button>
            </div>
            <div>
              <Button
                variant="contained"
                color="secondary"
                onClick={() => onSubmit('rest.storeEndTime')}
              >
                休憩終了
              </Button>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default TimeManagement;
