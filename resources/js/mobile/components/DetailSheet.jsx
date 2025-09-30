import React, { useEffect, useRef, useState } from 'react';
import { useCart } from '../context/CartContext';

export const DetailSheet = ({ controller }) => {
  const { open, detail, loading, closeDetail } = controller;
  const { cart, increment, decrement, totalItems } = useCart();
  const mediaRef = useRef(null);
  const swiperInstanceRef = useRef(null);
  const scrollRef = useRef(null);
  const produkSectionRef = useRef(null);
  const specSectionRef = useRef(null);
  const [activeTab, setActiveTab] = useState('produk');

  // Body scroll lock
  useEffect(()=>{
    if (open) document.body.classList.add('no-scroll'); else document.body.classList.remove('no-scroll');
  }, [open]);

  // Initialize media swiper
  useEffect(()=>{
    if (!open || !detail) return;
    if (!window.Swiper) return;
    const container = mediaRef.current;
    if (!container) return;
    if (swiperInstanceRef.current) { try { swiperInstanceRef.current.destroy(true,true);} catch(_){} }
    const inst = new Swiper(container, {
      pagination: { el: container.querySelector('.swiper-pagination'), clickable:true },
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
      try { const active = container.querySelector('.swiper-slide-active video'); if (active) active.play(); } catch(_){}
    }, 80);
  }, [open, detail]);

  // Scroll spy
  useEffect(()=>{
    if (!open) return; const sc = scrollRef.current; if (!sc) return;
    const onScroll = () => {
      const prodRect = produkSectionRef.current?.getBoundingClientRect();
      const specRect = specSectionRef.current?.getBoundingClientRect();
      const containerTop = sc.getBoundingClientRect().top;
      if (prodRect && specRect){
        const distProd = Math.abs(prodRect.top - containerTop);
        const distSpec = Math.abs(specRect.top - containerTop);
        setActiveTab(distProd <= distSpec ? 'produk' : 'spec');
      }
    };
    sc.addEventListener('scroll', onScroll, { passive:true });
    return ()=> sc.removeEventListener('scroll', onScroll);
  }, [open]);

  const scrollTo = (tab) => {
    if (!open) return; const sc = scrollRef.current; if (!sc) return;
    if (tab === 'produk') sc.scrollTo({ top:0, behavior:'smooth' }); else {
      const target = specSectionRef.current; if (!target) return;
      sc.scrollTo({ top: target.offsetTop - 2, behavior:'smooth' });
    }
    setActiveTab(tab);
  };

  if (!open) return null;

  const qty = detail ? (cart[detail.id]||0) : 0;

  return (
    <div className={`detail-overlay ${open ? 'open':''}`} onClick={e=>{ if (e.target.classList.contains('detail-overlay')) closeDetail(); }}>
      <div className="detail-sheet" role="dialog" aria-modal="true" onClick={e=>e.stopPropagation()}>
        <div className="detail-utility-bar" data-fallback-bar>
          <button className="util-btn" onClick={closeDetail}>✕ <span>Tutup</span></button>
          <div className="util-spacer" />
          <button className="util-btn" onClick={()=>{ try { navigator.share && detail && navigator.share({ title: detail.name, url: window.location.href }); } catch(_){} }}>🔗 <span>Share</span></button>
        </div>
        <div className="detail-media-wrapper">
          <div className="swiper detail-media-swiper" ref={mediaRef}>
            <div className="swiper-wrapper">
              {(detail?.media_list || []).map((m,i)=>(
                <div className="swiper-slide" key={i}>
                  {m.type==='video' ? (
                    <video src={m.url} muted playsInline loop preload="metadata" />
                  ) : (
                    <img src={m.url} loading="lazy" alt={detail?.name||'Media'} />
                  )}
                </div>
              ))}
            </div>
            <div className="swiper-pagination" />
          </div>
          <button className="detail-share-btn" style={{right:'54px'}} onClick={()=>{ try { navigator.share && navigator.share({ title: detail?.name, url: window.location.href }); } catch(_){} }}>⤴</button>
          <button className="detail-close-btn right" onClick={closeDetail}>✕</button>
        </div>
        <div className="detail-content-scroll" ref={scrollRef}>
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
          <div className="detail-divider" />
          <div ref={specSectionRef} className="detail-section" id="detail-spec-section">
            <h4 style={{marginTop:0}}>Deskripsi</h4>
            <p className="detail-desc">{detail?.description}</p>
            <h4 style={{marginTop:'18px'}}>Produk Terkait</h4>
            {/* Placeholder: related products slice logic should be passed in or computed higher */}
            <h4 style={{marginTop:'18px'}}>Spesifikasi</h4>
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
            {detail?.brochure_image && (
              <div className="detail-brochure-wrapper">
                <div className="detail-brochure-title">Brochure</div>
                <img src={detail.brochure_image} alt="Brochure" onError={(e)=>{ e.target.onerror=null; e.target.src='/placeholder/brochure-placeholder.png'; }} />
              </div>
            )}
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
    </div>
  );
};
