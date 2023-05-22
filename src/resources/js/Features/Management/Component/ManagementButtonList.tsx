import { Alert, Button, Collapse } from '@mui/material';
import { useState } from 'react';
import { router } from '@inertiajs/react';

import TimeDisplay from './TimeDisplay';
import Flash from '@/Layouts/Flash';

function ManagementButtonList() {
  const [open, setOpen] = useState<boolean>(false);
  const onResearchStartSubmit = () => {
    setOpen(true);
    setInterval(() => {
      setOpen(false);
    }, 2000);
    router.post(route('times.storeStartTime'));
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
              <Button variant="contained" color="error">
                休憩開始
              </Button>
            </div>
            <div>
              <Button variant="contained" color="error">
                休憩終了
              </Button>
            </div>
            <div>
              <Button variant="contained" color="error">
                研究終了
              </Button>
            </div>
          </div>
          <p>今日の研究時間</p>
        </div>
      </div>
    </div>
  );
}

export default ManagementButtonList;
