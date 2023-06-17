import React, { useCallback, useState } from 'react';
import BaseModal from '@/Components/Modal/BaseModal';

export type ModalProps = () => [
  ModalWrapper: React.FC<{ children: React.ReactNode }>,
  open: () => void,
  close: () => void,
  isOpenModal: boolean
];

const useModal: ModalProps = () => {
  const [isOpenModal, setIsOpenModal] = useState<boolean>(false);
  const open = useCallback(() => {
    setIsOpenModal(true);
  }, [setIsOpenModal]);
  const close = useCallback(() => {
    setIsOpenModal(false);
  }, [setIsOpenModal]);
  const ModalWrapper = useCallback(
    // @ts-ignore
    ({ children }) => (
      <BaseModal isOpen={isOpenModal} onClose={close}>
        {children}
      </BaseModal>
    ),
    [isOpenModal, close]
  );
  return [ModalWrapper, open, close, isOpenModal];
};

export default useModal;
