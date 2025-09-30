import React, { useEffect, useRef } from 'react';
import { useBanners } from '../hooks/useBanners';

// Assumes Swiper is globally loaded (same as original inline implementation)
export const BannerSlider = () => {
  const { banners } = useBanners();
  const ref = useRef(null);

  useEffect(()=>{
    if (!banners.length) return;
    if (!window.Swiper) return;
    const el = ref.current;
    if (!el) return;
    if (el.__swiperInstance) { try { el.__swiperInstance.destroy(true,true); } catch(_){} }
    const instance = new Swiper(el, {
      loop: banners.length > 1,
      pagination: { el: el.querySelector('.swiper-pagination'), clickable: true },
      autoplay: banners.length > 1 ? { delay:5000, disableOnInteraction:false } : false,
      speed:550,
      effect:'slide',
      grabCursor:true
    });
    el.__swiperInstance = instance;
  }, [banners]);

  return (
    <section className="main-banner">
      <div className="swiper" ref={ref} id="bannerSwiper">
        <div className="swiper-wrapper">
          {banners.map(b => (
            <div key={b.id} className={`swiper-slide ${b.isDefault ? 'default-banner':''}`} style={!b.isDefault ? { background:'#000'} : {}}>
              {b.image && !b.isDefault && (
                <img src={b.image} loading="lazy" alt={b.name || 'Banner'} className="banner-img-tag" />
              )}
              <div className="banner-overlay" />
              <div className="banner-content" />
            </div>
          ))}
        </div>
        <div className="swiper-pagination" />
      </div>
    </section>
  );
};
