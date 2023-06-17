import React from 'react';
import Modal from 'react-modal';

type ModalProps = {
  isOpen: boolean;
  onClose: () => void;
  children: React.ReactNode;
};

if (import.meta.env.MODE !== 'test') Modal.setAppElement('#app');

// eslint-disable-next-line react/function-component-definition
function BaseModal({ isOpen, onClose, children }: ModalProps) {
  const modalStyles = {
    overlay: {
      postion: 'fixed',
      top: 0,
      left: 0,
      right: 0,
      bottom: 0,
      backgroundColor: 'rgba(0, 0, 0, 0.7)',
      transition: 'opacity 200ms ease-in-out',
      zIndex: 100
    },
    content: {
      top: '50%',
      left: '50%',
      right: 'auto',
      bottom: 'auto',
      marginRight: '-50%',
      transform: 'translate(-50%, -50%)',
      padding: '20px',
      // ウィンドウサイズに応じてモーダルのサイズを変える
      width: '900px',
      zIndex: 100
    }
  };

  return (
    <Modal isOpen={isOpen} style={modalStyles} onRequestClose={onClose}>
      {children}
    </Modal>
  );
}

export default BaseModal;
