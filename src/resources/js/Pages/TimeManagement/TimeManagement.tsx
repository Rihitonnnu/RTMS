import { Button, TextField } from '@mui/material';
import { useEffect, useState } from 'react';
import { router } from '@inertiajs/react';
import { useForm, SubmitHandler, Controller } from 'react-hook-form';

import TimeDisplay from './TimeDisplay';
import Flash from '@/Layouts/Flash';
import useMultipleClickPreventer from '@/Hooks/useMultipleClickPreventer';
import {
  TargetTimeInputs,
  TimeManagementProps
} from '@/types/TimeManagement/TimeManagementType';

function TimeManagement({ targetTime }: TimeManagementProps) {
  const { control, handleSubmit } = useForm<TargetTimeInputs>();
  const [open, setOpen] = useState<boolean>(false);

  useEffect(() => {
    setOpen(true);
    setTimeout(() => {
      setOpen(false);
    }, 2000);
  }, [targetTime?.time]);

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

  const onTargetTimeSubmit: SubmitHandler<TargetTimeInputs> = (
    data: TargetTimeInputs
  ) => {
    router.post(route('targetTime.store', data));
  };

  return (
    <div className="py-12">
      <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <Flash open={open} />

        {/* ここうまくコンポーネント化したい */}
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

          <form onSubmit={handleSubmit(onTargetTimeSubmit)}>
            <div className="max-w-7xl w-2/3 mx-auto mt-10 sm:px-6 lg:px-8 flex justify-evenly items-center">
              {targetTime !== null && (
                <>
                  <p>{`今週の目標時間   ${targetTime?.time}時間`}</p>
                  <div>
                    <p>目標時間達成まであと　時間</p>
                  </div>
                </>
              )}

              {targetTime === null ? (
                <div className="flex items-center">
                  <Controller
                    name="time"
                    control={control}
                    render={({ field }) => (
                      <TextField
                        // eslint-disable-next-line react/jsx-props-no-spreading
                        {...field}
                        id="outlined-number"
                        label="週間目標時間（時間）"
                        type="number"
                      />
                    )}
                  />
                  <div className="ml-3">
                    <Button type="submit" variant="contained" color="primary">
                      設定する
                    </Button>
                  </div>
                </div>
              ) : (
                <div className="ml-3">
                  <Button
                    variant="contained"
                    onClick={() =>
                      router.get(route('targetTime.edit', targetTime.id))
                    }
                  >
                    目標時間を編集する
                  </Button>
                </div>
              )}
            </div>
          </form>
        </div>
      </div>
    </div>
  );
}

export default TimeManagement;
