import React, { createContext, useContext, useEffect, useState, useCallback } from 'react';

const CartContext = createContext(null);

export const CartProvider = ({ children }) => {
  const [cart, setCart] = useState(()=>{
    try { const raw = localStorage.getItem('pk_cart'); if (raw) return JSON.parse(raw); } catch(_){}
    return {}; // {id: qty}
  });

  useEffect(()=>{ try { localStorage.setItem('pk_cart', JSON.stringify(cart)); } catch(_){} }, [cart]);

  const increment = useCallback((p) => {
    setCart(prev => ({ ...prev, [p.id]: (prev[p.id]||0)+1 }));
  }, []);
  const decrement = useCallback((p) => {
    setCart(prev => {
      const current = prev[p.id]||0; if (current <= 1){ const n={...prev}; delete n[p.id]; return n; }
      return { ...prev, [p.id]: current-1 };
    });
  }, []);

  const clearCart = useCallback(()=>{ setCart({}); }, []);

  const totalItems = Object.values(cart).reduce((a,b)=>a+b,0);

  return (
    <CartContext.Provider value={{ cart, increment, decrement, clearCart, totalItems }}>
      {children}
    </CartContext.Provider>
  );
};

export const useCart = () => useContext(CartContext);
