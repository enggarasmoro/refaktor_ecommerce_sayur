import React, { useEffect, useRef } from 'react';
import { useBanners } from '../hooks/useBanners';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import 'swiper/swiper-bundle.css';
Swiper.use([Navigation, Pagination, Autoplay]);

// Now using module Swiper import instead of global window.Swiper
export const BannerSlider = () => {
  const { banners } = useBanners();
  const ref = useRef(null);

  useEffect(()=>{
    const el = ref.current;
    if (!el) return;
    if (!banners.length) {
      if (process.env.NODE_ENV !== 'production') {
        // eslint-disable-next-line no-console
        console.log('[BannerSlider] No banners to init swiper');
      }
      if (el.__swiperInstance) { try { el.__swiperInstance.destroy(true,true); } catch(_){} }
      return;
    }
    const shouldLoop = banners.length > 1; // Swiper warns if loop with < 2
    if (el.__swiperInstance) {
      // Re-init only if loop mode changes or count differs
      const prev = el.__swiperInstance;
      const prevLoop = prev.params.loop;
      const countChanged = prev.slides && prev.slides.length !== banners.length;
      if (!countChanged && prevLoop === shouldLoop) {
        return; // no rebuild necessary
      }
      try { prev.destroy(true,true); } catch(_){}
    }
    const instance = new Swiper(el, {
      loop: shouldLoop,
      pagination: { el: el.querySelector('.swiper-pagination'), clickable: true },
      navigation: {
        nextEl: el.querySelector('.swiper-button-next'),
        prevEl: el.querySelector('.swiper-button-prev')
      },
      autoplay: shouldLoop ? { delay:5000, disableOnInteraction:false } : false,
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
        <div className="swiper-button-prev" />
        <div className="swiper-button-next" />
      </div>
    </section>
  );
};
