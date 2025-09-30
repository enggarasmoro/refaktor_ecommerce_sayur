import React, { useRef, useState, useEffect, Suspense, lazy } from 'react';
import { BannerSlider } from './components/BannerSlider';
import { CategoriesSwiper } from './components/CategoriesSwiper';
import { ProductsGrid } from './components/ProductsGrid';
// Lazy load DetailSheet to reduce initial bundle
const DetailSheet = lazy(()=> import('./components/DetailSheet').then(m=>({ default: m.DetailSheet })));
import { BottomNavigation } from './components/BottomNavigation';
import { useProductDetail } from './hooks/useProductDetail';
import { CartProvider } from './context/CartContext';
import { ToastProvider } from './context/ToastContext';
import { ToastContainer } from './components/ToastContainer';

export const MobileApp = () => {
  const [searchQuery, setSearchQuery] = useState('');
  const [activeTab, setActiveTab] = useState('home');
  const scrollTopBtnRef = useRef(null);
  const detailController = useProductDetail();

  // Sticky search effect (based on scroll)
  useEffect(()=>{
    const handleScroll = () => {
      const searchSection = document.querySelector('.search-section');
      const scrollPosition = window.scrollY;
      if (scrollPosition > 150) searchSection?.classList.add('search-sticky'); else searchSection?.classList.remove('search-sticky');
    };
    window.addEventListener('scroll', handleScroll);
    return ()=> window.removeEventListener('scroll', handleScroll);
  }, []);

  // Scroll top button logic
  useEffect(()=>{
    const btn = scrollTopBtnRef.current; if (!btn) return; let timer=null;
    const onScroll = () => {
      const doc = document.documentElement; const y = window.scrollY || doc.scrollTop; const viewport = window.innerHeight; const full = doc.scrollHeight; const distanceToBottom = full - (y + viewport);
      if (timer) clearTimeout(timer);
      if (distanceToBottom < 600 && y > 500){
        btn.classList.add('visible'); if (y>1400) btn.classList.add('deep'); else btn.classList.remove('deep'); return;
      }
      btn.classList.remove('visible'); btn.classList.remove('deep');
      let baseDelay = 220; if (y>1200) baseDelay=140; if (y>1800) baseDelay=90;
      timer = setTimeout(()=>{ if (y>600){ btn.classList.add('visible'); if (y>1500) btn.classList.add('deep'); } }, baseDelay);
    };
    window.addEventListener('scroll', onScroll, { passive:true });
    return ()=> { window.removeEventListener('scroll', onScroll); if (timer) clearTimeout(timer); };
  }, []);

  // Prefetch DetailSheet on idle (after 2s) and first pointer move over product list
  useEffect(()=>{
    let prefetched = false;
    const doPrefetch = () => {
      if (prefetched) return; prefetched = true;
      import('./components/DetailSheet');
    };
    const idleTimer = setTimeout(doPrefetch, 2000);
    const onPointerMove = (e) => {
      const el = e.target.closest && e.target.closest('.products-grid');
      if (el) { doPrefetch(); window.removeEventListener('pointermove', onPointerMove); }
    };
    window.addEventListener('pointermove', onPointerMove, { passive:true });
    return () => { clearTimeout(idleTimer); window.removeEventListener('pointermove', onPointerMove); };
  }, []);

  return (
    <ToastProvider>
      <CartProvider>
      <div className="mobile-homepage">
        <BannerSlider />
        <header className="app-header">
          <div className="search-section">
            <div className="search-container">
              <span className="search-icon">🔍</span>
              <input type="text" placeholder="Cari beragam kebutuhan harian" value={searchQuery} onChange={e=>setSearchQuery(e.target.value)} className="search-input" />
            </div>
          </div>
        </header>
        <CategoriesSwiper />
        <ProductsGrid onOpenDetail={detailController.openDetail} />
        <BottomNavigation activeTab={activeTab} setActiveTab={setActiveTab} />
        <button ref={scrollTopBtnRef} className="scroll-top-btn" aria-label="Kembali ke atas" onClick={()=>window.scrollTo({top:0, behavior:'smooth'})}>
          <svg viewBox="0 0 24 24"><path d="M12 19V5"/><path d="M6 11l6-6 6 6"/></svg>
        </button>
        <Suspense fallback={null}>
          <DetailSheet controller={detailController} />
        </Suspense>
        <ToastContainer />
      </div>
      </CartProvider>
    </ToastProvider>
  );
};

export default MobileApp;
