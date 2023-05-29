export type MonthlyTimeListPageProps = {
  thisMonthInfos: {
    id: number;
    user_id: number;
    date: string;
    research_time: number | null;
    rest_time: number | null;
    created_at: Date;
    updated_at: Date;
  }[];
};
