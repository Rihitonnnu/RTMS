import { useForm, SubmitHandler, Controller } from 'react-hook-form';
import { Button, TextField } from '@mui/material';
import { router } from '@inertiajs/react';
import * as yup from 'yup';
import { yupResolver } from '@hookform/resolvers/yup';

import type {
  TargetTimeEditProps,
  TargetTimeInputs
} from '@/types/TimeManagement/TimeManagementType';
import Layout from '@/Layouts/Layout';

function TargetTimeEdit({ targetTime }: TargetTimeEditProps) {
  const schema = yup.object({
    time: yup
      .number()
      .required('目標時間を入力してください')
      .typeError('数字を入力してください')
  });
  const {
    register,
    control,
    handleSubmit,
    formState: { errors }
  } = useForm<TargetTimeInputs>({
    resolver: yupResolver(schema)
  });

  const onSubmit: SubmitHandler<TargetTimeInputs> = (
    data: TargetTimeInputs
  ) => {
    router.put(route('targetTime.update', targetTime.id), data);
  };
  return (
    <Layout>
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
                // eslint-disable-next-line react/jsx-props-no-spreading
                {...register('time')}
                error={'time' in errors}
                helperText={errors.time?.message}
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
    </Layout>
  );
}

export default TargetTimeEdit;
