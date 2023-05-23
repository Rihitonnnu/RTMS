import React, { useState, useEffect } from 'react';

function TimeDisplay() {
  const weekday = ['日', '月', '火', '水', '木', '金', '土'];
  const [date, setDate] = useState<string>('');
  const [time, setTime] = useState<string>('');
  useEffect(() => {
    setInterval(() => {
      const d = new Date();
      const year = d.getFullYear();
      const month = d.getMonth() + 1;
      const day = d.getDate();
      const dayofweek = d.getDay();
      setDate(`${year}年${month}月${day}日 [${weekday[dayofweek]}]`);

      const hour = d.getHours().toString().padStart(2, '0');
      const minute = d.getMinutes().toString().padStart(2, '0');
      const seconds = d.getSeconds().toString().padStart(2, '0');
      setTime(`${hour}:${minute}:${seconds}`);
    }, 1000);
  }, []);

  return (
    <div className="flex justify-center font-bold text-2xl">
      <h1>
        {date}
        {time}
      </h1>
    </div>
  );
}

export default TimeDisplay;
