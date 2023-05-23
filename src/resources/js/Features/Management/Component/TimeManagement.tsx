import { Button } from '@mui/material';
import { useState } from 'react';
import { router } from '@inertiajs/react';

import TimeDisplay from './TimeDisplay';
import Flash from '@/Layouts/Flash';

function TimeManagement() {
  const [open, setOpen] = useState<boolean>(false);
  const onResearchStartSubmit = () => {
    // ここの処理共通化させたい
    setOpen(true);
    setTimeout(() => {
      setOpen(false);
    }, 2000);
    router.post(route('times.research.storeStartTime'));
  };

  const onResearchEndSubmit = () => {
    setOpen(true);
    setTimeout(() => {
      setOpen(false);
    }, 2000);
    const method = { _method: 'PUT' };
    router.post(route('times.research.storeEndTime'), { ...method });
  };

  const onRestStartSubmit = () => {
    setOpen(true);
    setTimeout(() => {
      setOpen(false);
    }, 2000);
    router.post(route('times.rest.storeStartTime'));
  };

  const onRestEndSubmit = () => {
    setOpen(true);
    setTimeout(() => {
      setOpen(false);
    }, 2000);
    router.post(route('times.rest.storeEndTime'));
  };
  return (
    <div className="py-12">
      <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <Flash open={open} />

        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
          <TimeDisplay />

          <div className="mx-auto mt-3 w-1/3 grid grid-cols-4">
            <div>
              <Button variant="contained" onClick={onResearchStartSubmit}>
                研究開始
              </Button>
            </div>
            <div>
              <Button
                variant="contained"
                color="error"
                onClick={onResearchEndSubmit}
              >
                研究終了
              </Button>
            </div>
            <div>
              <Button
                variant="contained"
                color="secondary"
                onClick={onRestStartSubmit}
              >
                休憩開始
              </Button>
            </div>
            <div>
              <Button
                variant="contained"
                color="secondary"
                onClick={onRestEndSubmit}
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
