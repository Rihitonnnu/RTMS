import { usePage } from '@inertiajs/react';
import { Alert, Collapse } from '@mui/material';
import { useEffect, useState } from 'react';

type FlashPropsType = {
  open: boolean;
};

function Flash({ open }: FlashPropsType) {
  const [isDisplay, setIsDisplay] = useState<boolean>(open);
  const { flashMessage, flashErrorMessage } = usePage().props;
  const sucsessMessage = flashMessage as string;
  const errorMessage = flashErrorMessage as string;
  useEffect(() => {
    setIsDisplay(open);
  }, [open]);

  return (
    <div>
      <Collapse in={isDisplay}>
        {sucsessMessage && (
          <div className="mb-4">
            <Alert
              variant="filled"
              severity="success"
              className="w-2/3 mx-auto"
            >
              {sucsessMessage}
            </Alert>
          </div>
        )}
        {errorMessage && (
          <div className="mb-4">
            <Alert variant="filled" severity="error" className="w-2/3 mx-auto">
              {errorMessage}
            </Alert>
          </div>
        )}
      </Collapse>
    </div>
  );
}

export default Flash;
