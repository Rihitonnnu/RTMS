import { router } from '@inertiajs/react';

type TimeDeleteModalProps = {
  id: number;
  modalIsOpen: boolean;
  // eslint-disable-next-line react/require-default-props
  setModalIsOpen?: (modalIsOpen: boolean) => void;
};

function TimeDeleteModal({
  id,
  modalIsOpen,
  setModalIsOpen = () => {}
}: TimeDeleteModalProps) {
  const handleSubmit = () => {
    setModalIsOpen(!modalIsOpen);
    const method = { _method: 'DELETE' };
    router.post(route('dailyTime.destroy', id), method);
  };
  return (
    <div className="w-full px-3">
      <div>
        <h4 className="text-2xl font-bold">確認</h4>
        <p className="mt-2">
          削除して問題ありませんか？
          <br />
        </p>
      </div>
      <div className="mt-3 text-right">
        <form onSubmit={handleSubmit}>
          <button className="bg-pink-500 px-6 py-2 text-white" type="submit">
            削除
          </button>
        </form>
      </div>
    </div>
  );
}

export default TimeDeleteModal;
