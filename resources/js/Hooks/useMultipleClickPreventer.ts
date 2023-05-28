import { useRef } from 'react';

function useMultipleClickPreventer(handleSubmit: (e: {} | string) => void) {
  const processing = useRef(false);

  const multipleClickPreventer = (e: {}) => {
    if (processing.current) return;
    processing.current = true;
    handleSubmit(e);
    setTimeout(() => {
      processing.current = false;
    }, 2000);
  };
  return multipleClickPreventer;
}

export default useMultipleClickPreventer;
