import { useForm, SubmitHandler, Controller } from 'react-hook-form';
import { Button, TextField } from '@mui/material';
import { router } from '@inertiajs/react';

import type {
  TargetTimeEditProps,
  TargetTimeInputs
} from '@/types/TimeManagement/TimeManagementType';

function TargetTimeEdit({ targetTime }: TargetTimeEditProps) {
  const { control, handleSubmit } = useForm<TargetTimeInputs>();

  const onSubmit: SubmitHandler<TargetTimeInputs> = (
    data: TargetTimeInputs
  ) => {
    router.put(route('targetTime.update', targetTime.id), data);
  };
  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <div className="flex items-center w-fit mt-4 mx-auto">
        <Controller
          name="time"
          control={control}
          render={({ field }) => (
            <TextField
              // eslint-disable-next-line react/jsx-props-no-spreading
              {...field}
              defaultValue={targetTime.time}
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
        <div className="ml-3">
          <Button
            variant="contained"
            color="secondary"
            onClick={() => router.get(route('dashboard'))}
          >
            戻る
          </Button>
        </div>
      </div>
    </form>
  );
}

export default TargetTimeEdit;
