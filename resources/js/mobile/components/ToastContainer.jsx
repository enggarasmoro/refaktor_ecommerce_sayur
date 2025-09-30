import React from 'react';
import { useToast } from '../context/ToastContext';

export const ToastContainer = () => {
  const { toasts, remove } = useToast();
  return (
    <div className="toast-container" aria-live="polite" aria-atomic="true">
      {toasts.map(t => (
        <div key={t.id} className={`toast-item toast-${t.type}`} role="status" onClick={()=>remove(t.id)}>
          <div className="toast-message">{t.message}</div>
          <button className="toast-close" aria-label="Tutup" onClick={(e)=>{ e.stopPropagation(); remove(t.id); }}>✕</button>
        </div>
      ))}
    </div>
  );
};
