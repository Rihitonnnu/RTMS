type TargetTimeType = {
  targetTime: {
    id: number;
    user_id: number;
    time: number;
    created_at: Date;
    updated_at: Date;
  };
};
export type TimeManagementProps = TargetTimeType;

export type TargetTimeEditProps = TargetTimeType;

export type TargetTimeInputs = {
  time: number;
};
