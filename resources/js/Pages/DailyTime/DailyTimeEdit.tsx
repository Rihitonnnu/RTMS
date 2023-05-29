import { useForm, SubmitHandler, Controller } from 'react-hook-form';
import { Button, TextField } from '@mui/material';
import { router } from '@inertiajs/react';
import * as yup from 'yup';
import { yupResolver } from '@hookform/resolvers/yup';

import Layout from '@/Layouts/Layout';

type DailyTimeEditInputs = {
  research_time: number;
  rest_time: number;
};

type DailyTimeEditProps = {
  dailyTime: any;
};

function DailyTimeEdit({ dailyTime }: DailyTimeEditProps) {
  const schema = yup.object({
    research_time: yup
      .number()
      .required('研究時間を入力してください')
      .typeError('数字を入力してください'),
    rest_time: yup
      .number()
      .required('休憩時間を入力してください')
      .typeError('数字を入力してください')
  });
  const {
    register,
    control,
    handleSubmit,
    formState: { errors }
  } = useForm<DailyTimeEditInputs>({
    resolver: yupResolver(schema)
  });

  const onSubmit: SubmitHandler<DailyTimeEditInputs> = (
    data: DailyTimeEditInputs
  ) => {
    router.put(route('dailyTime.update', dailyTime.id), data);
  };
  return (
    <Layout>
      <form onSubmit={handleSubmit(onSubmit)}>
        <div className="flex items-center w-fit mt-4 mx-auto">
          <Controller
            name="research_time"
            control={control}
            render={({ field }) => (
              <TextField
                // eslint-disable-next-line react/jsx-props-no-spreading
                {...field}
                defaultValue={dailyTime.research_time}
                id="outlined-number"
                label="週間研究時間（時間）"
                type="number"
                // eslint-disable-next-line react/jsx-props-no-spreading
                {...register('research_time')}
                error={'research_time' in errors}
                helperText={errors.research_time?.message}
              />
            )}
          />
          <Controller
            name="rest_time"
            control={control}
            render={({ field }) => (
              <TextField
                // eslint-disable-next-line react/jsx-props-no-spreading
                {...field}
                defaultValue={dailyTime.rest_time}
                id="outlined-number"
                label="週間休憩時間（時間）"
                type="number"
                // eslint-disable-next-line react/jsx-props-no-spreading
                {...register('rest_time')}
                error={'rest_time' in errors}
                helperText={errors.rest_time?.message}
              />
            )}
          />
          <div className="ml-3">
            <Button type="submit" variant="contained" color="primary">
              更新する
            </Button>
          </div>
          <div className="ml-3">
            <Button
              variant="contained"
              color="secondary"
              href={route('monthlyTime.index')}
            >
              戻る
            </Button>
          </div>
        </div>
      </form>
    </Layout>
  );
}

export default DailyTimeEdit;
