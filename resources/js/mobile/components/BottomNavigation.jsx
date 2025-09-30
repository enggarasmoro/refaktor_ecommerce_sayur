import React from 'react';
import { useCart } from '../context/CartContext';

export const BottomNavigation = ({ activeTab, setActiveTab }) => {
  const { totalItems } = useCart();
  return (
    <nav className="bottom-navigation">
      <div className={`nav-item ${activeTab==='home'?'active':''}`} onClick={()=>setActiveTab('home')}>
        <span className="nav-icon">🏠</span>
        <span className="nav-label">Home</span>
      </div>
      <div className={`nav-item ${activeTab==='category'?'active':''}`} onClick={()=>window.location.href='/shop'}>
        <span className="nav-icon">📱</span>
        <span className="nav-label">Kategori</span>
      </div>
      <div className={`nav-item ${activeTab==='chat'?'active':''}`} onClick={()=>window.open('https://wa.me/6281241938647','_blank')}>
        <span className="nav-icon">🎧</span>
        <span className="nav-label">Chat CS</span>
      </div>
      <div className={`nav-item ${activeTab==='cart'?'active':''}`} onClick={()=>window.location.href='/mycart'}>
        <span className="nav-icon">🛒</span>
        <span className="nav-label">Keranjang</span>
        {totalItems>0 && <span className="cart-badge">{totalItems}</span>}
      </div>
      <div className={`nav-item ${activeTab==='profile'?'active':''}`} onClick={()=>window.location.href='/login'}>
        <span className="nav-icon">👤</span>
        <span className="nav-label">Akun</span>
      </div>
    </nav>
  );
};
