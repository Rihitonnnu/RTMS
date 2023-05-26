import { Button, TextField } from '@mui/material';
import { useForm, SubmitHandler, Controller } from 'react-hook-form';
import { router } from '@inertiajs/react';

import type {
  TargetTimeInputs,
  TargetTimeEditProps
} from '@/types/TimeManagement/TimeManagementType';

function TargetTimeList({ targetTime, weeklyTime }: TargetTimeEditProps) {
  const { control, handleSubmit } = useForm<TargetTimeInputs>();
  const onTargetTimeSubmit: SubmitHandler<TargetTimeInputs> = (
    data: TargetTimeInputs
  ) => {
    router.post(route('targetTime.store', data));
  };

  return (
    <form onSubmit={handleSubmit(onTargetTimeSubmit)}>
      <div className="max-w-7xl w-2/3 mx-auto mt-10 sm:px-6 lg:px-8 flex justify-evenly items-center">
        {targetTime !== null && (
          <>
            <div className="text-center">
              <p>今週の目標時間</p>
              <h1 className="font-bold text-2xl">{`${targetTime?.time}時間`}</h1>
            </div>

            <div className="text-center">
              {targetTime.time < weeklyTime ? (
                <h1 className="font-bold text-2xl text-red-500">
                  目標達成！おめでとう！
                </h1>
              ) : (
                <>
                  <p>目標達成まであと</p>
                  <h1 className="font-bold text-2xl">
                    {`${targetTime.time - weeklyTime}時間`}
                  </h1>
                </>
              )}
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
          <div>
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
  );
}

export default TargetTimeList;
