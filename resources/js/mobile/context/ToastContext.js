import React, { createContext, useContext, useCallback, useState } from 'react';

const ToastContext = createContext(null);
let idCounter = 0;

export const ToastProvider = ({ children }) => {
  const [toasts, setToasts] = useState([]); // {id,type,message}

  const remove = useCallback((id) => {
    setToasts(prev => prev.filter(t => t.id !== id));
  }, []);

  const push = useCallback((message, opts={}) => {
    const id = ++idCounter;
    const toast = { id, type: opts.type || 'info', message, duration: opts.duration || 3800 };
    setToasts(prev => [...prev, toast]);
    if (toast.duration > 0) {
      setTimeout(()=> remove(id), toast.duration + 50);
    }
    return id;
  }, [remove]);

  const api = {
    push,
    info: (m,o)=>push(m,{...o,type:'info'}),
    success: (m,o)=>push(m,{...o,type:'success'}),
    error: (m,o)=>push(m,{...o,type:'error', duration: (o && o.duration) || 5200}),
    warning: (m,o)=>push(m,{...o,type:'warning'}),
    remove,
    toasts
  };

  return (
    <ToastContext.Provider value={api}>{children}</ToastContext.Provider>
  );
};

export const useToast = () => useContext(ToastContext);
