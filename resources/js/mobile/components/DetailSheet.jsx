import React, { useEffect, useRef, useState } from 'react';
import Swiper from 'swiper';
import 'swiper/swiper-bundle.css';
import { useCart } from '../context/CartContext';

export const DetailSheet = ({ controller }) => {
  const { open, detail, loading, closeDetail } = controller;
  const { cart, increment, decrement, totalItems } = useCart();
  const mediaRef = useRef(null);
  const swiperInstanceRef = useRef(null);
  const scrollRef = useRef(null); // back on inner scroll
  const produkSectionRef = useRef(null);
  const specSectionRef = useRef(null);
  const [activeTab, setActiveTab] = useState('produk');
  const [descExpanded, setDescExpanded] = useState(false);
  const [fitMode, setFitMode] = useState(false); // global toggle for contain

  // Debug marker (must stay BEFORE any conditional early return to keep hook order stable)
  useEffect(()=>{ if (open) console.debug('[DetailSheet] version 2025-10-01-c loaded'); }, [open]);

  // Body scroll lock
  useEffect(()=>{
    if (open) document.body.classList.add('no-scroll'); else document.body.classList.remove('no-scroll');
  }, [open]);

  // Initialize media swiper
  useEffect(()=>{
    if (!open || !detail) return;
    const container = mediaRef.current;
    if (!container) return;
    if (swiperInstanceRef.current) { try { swiperInstanceRef.current.destroy(true,true);} catch(_){} }
    const inst = new Swiper(container, {
      pagination: { el: container.querySelector('.swiper-pagination'), clickable:true },
      navigation: { nextEl: container.querySelector('.swiper-button-next'), prevEl: container.querySelector('.swiper-button-prev') },
      loop: detail.media_list.length > 1,
      speed:450,
      on: {
        slideChange: function(){
          const slides = container.querySelectorAll('.swiper-slide');
          slides.forEach((sl,i)=>{
            const vid = sl.querySelector('video');
            if (vid){
              if (i===this.realIndex) { try { vid.play(); } catch(_){} }
              else { try { vid.pause(); } catch(_){} }
            }
          });
        }
      }
    });
    swiperInstanceRef.current = inst;
    setTimeout(()=>{
      try { const active = container.querySelector('.swiper-slide-active video'); if (active) active.play(); } catch(_){}}
    , 80);
  }, [open, detail]);

  // Scroll spy
  useEffect(()=>{
    if (!open) return; const sc = scrollRef.current; if (!sc) return;
    const tabsEl = sc.querySelector('.detail-tabs');
    const onScroll = () => {
      const tabsH = tabsEl ? tabsEl.getBoundingClientRect().height : 0;
      const specTop = specSectionRef.current?.offsetTop || 0;
      const scrollY = sc.scrollTop;
      const threshold = specTop - tabsH - 8;
      const newTab = scrollY < threshold ? 'produk' : 'spec';
      if (newTab !== activeTab) setActiveTab(newTab);
    };
    sc.addEventListener('scroll', onScroll, { passive:true });
    onScroll();
    return ()=> sc.removeEventListener('scroll', onScroll);
  }, [open, activeTab]);

  const scrollTo = (tab) => {
    if (!open) return; const sc = scrollRef.current; if (!sc) return;
    const tabsEl = sc.querySelector('.detail-tabs');
    const tabsH = tabsEl ? tabsEl.getBoundingClientRect().height : 0;
    if (tab === 'produk') sc.scrollTo({ top:0, behavior:'smooth' }); else {
      const y = (specSectionRef.current?.offsetTop || 0) - tabsH - 4;
      sc.scrollTo({ top: y < 0 ? 0 : y, behavior:'smooth' });
    }
    setActiveTab(tab);
  };

  const handleImageLoad = (e) => {
    const img = e.target;
    if (!img) return;
    const { naturalWidth:w, naturalHeight:h } = img;
    if (h > w * 1.15) {
      img.classList.add('portrait');
    }
  };
  const toggleFit = () => setFitMode(m=>!m);

  if (!open) return null; // early return placed AFTER all hooks

  const qty = detail ? (cart[detail.id]||0) : 0;

  return (
    <div className={`detail-overlay ${open ? 'open':''}`} onClick={e=>{ if (e.target.classList.contains('detail-overlay')) closeDetail(); }}>
      <div className="detail-sheet" role="dialog" aria-modal="true" onClick={e=>e.stopPropagation()}>
        <div className="detail-content-scroll" ref={scrollRef}>
          <div className="detail-media-wrapper">
            <div className="swiper detail-media-swiper" ref={mediaRef}>
              <div className="swiper-wrapper">
                {(detail?.media_list || []).map((m,i)=>(
                  <div className="swiper-slide" key={i}>
                    {m.type==='video' ? (
                      <video src={m.url} muted playsInline loop preload="metadata" />
                    ) : (
                      <img onLoad={handleImageLoad} onClick={toggleFit} className={fitMode? 'fit-mode':''} src={m.url} loading="lazy" alt={detail?.name||'Media'} />
                    )}
                  </div>
                ))}
              </div>
              <div className="swiper-pagination" />
              <div className="swiper-button-prev media-nav" />
              <div className="swiper-button-next media-nav" />
            </div>
            <button className="detail-close-btn right" onClick={closeDetail}>✕</button>
          </div>
          <div className="detail-tabs">
            <div className={`detail-tab ${activeTab==='produk'?'active':''}`} onClick={()=>scrollTo('produk')}>Produk</div>
            <div className={`detail-tab ${activeTab==='spec'?'active':''}`} onClick={()=>scrollTo('spec')}>Spesifikasi</div>
          </div>
          <div ref={produkSectionRef} className="detail-section" id="detail-produk-section">
            <div className="detail-price-row">
              <span className="detail-price-current">{detail && ('Rp'+detail.price?.toLocaleString('id-ID'))}</span>
              {detail?.old_price && <span className="detail-price-old">{'Rp'+detail.old_price.toLocaleString('id-ID')}</span>}
              {detail?.discount && <span className="detail-discount-badge">{detail.discount}%</span>}
            </div>
            <h3 className="detail-title">{detail?.name}</h3>
            {detail?.subtitle && <p className="detail-sub">{detail.subtitle}</p>}
          </div>
          <div className="detail-soft-divider" />
          <div ref={specSectionRef} className="detail-section" id="detail-spec-section">
            <h4 style={{marginTop:0}}>Deskripsi</h4>
            <div className={`detail-desc-wrapper ${descExpanded?'expanded':''}`}>
              <p className="detail-desc">{detail?.description}</p>
            </div>
            {detail?.description && detail.description.length > 160 && (
              <button className="detail-readmore" onClick={()=>setDescExpanded(v=>!v)}>
                {descExpanded ? 'Sembunyikan' : 'Baca Selengkapnya'}
              </button>
            )}
            <div className="detail-soft-divider" />
            <h4 style={{marginTop:'0'}}>Produk Terkait</h4>
            {/* Placeholder related products */}
            <div className="detail-soft-divider" />
            <h4 style={{marginTop:'0'}}>Spesifikasi</h4>
            <div className="detail-spec-wrapper expanded">
              {detail?.spec_html ? (
                <div className="detail-spec-html" style={{fontSize:'12px', lineHeight:'1.5'}} dangerouslySetInnerHTML={{__html: detail.spec_html}} />
              ) : (
                <div className="spec-grid">
                  {(detail?.specs||[]).map((s,i)=>(
                    <div key={i} className="spec-item">
                      <div className="spec-label">{s.label}</div>
                      <div className="spec-value">{s.value}</div>
                    </div>
                  ))}
                </div>
              )}
            </div>
            {detail?.brochure_image && (
              <div className="detail-brochure-wrapper">
                <img src={detail.brochure_image} alt="Brochure" onError={(e)=>{ e.target.onerror=null; e.target.src='/placeholder/brochure-placeholder.png'; }} />
              </div>
            )}
          </div>
        </div>
        <div className="detail-bottom-bar">
          <div className="action-left">
            <button className="detail-icon-btn" aria-label="Wishlist" onClick={()=>alert('Wishlist placeholder')}>♡</button>
            <button className="detail-icon-btn" aria-label="Keranjang" onClick={()=>window.location.href='/mycart'}>
              🛒{totalItems>0 && <span className="badge">{totalItems}</span>}
            </button>
          </div>
          <div className="detail-bottom-flex">
            {detail && (qty===0 ? (
              <button className="detail-cart-btn" onClick={()=>increment(detail)}>Tambah ke Keranjang</button>
            ) : (
              <div className="detail-qty-inline" style={{marginLeft:'auto', display:'flex',alignItems:'center',gap:'10px'}}>
                <button className="detail-inline-btn" onClick={()=>decrement(detail)}>−</button>
                <span style={{fontWeight:600,minWidth:'24px',textAlign:'center'}}>{qty}</span>
                <button className="detail-inline-btn" onClick={()=>increment(detail)}>+</button>
              </div>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
};
