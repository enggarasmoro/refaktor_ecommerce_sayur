import React, { useEffect, useRef } from 'react';
import { useCategories } from '../hooks/useCategories';
import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
import 'swiper/swiper-bundle.css';
Swiper.use([Navigation, Pagination]);

export const CategoriesSwiper = () => {
  const { categories } = useCategories();
  const ref = useRef(null);

  useEffect(()=>{
    if (!categories.length) return;
    const containerEl = ref.current;
    if (!containerEl) return;
    if (containerEl.__swiperInstance) { try { containerEl.__swiperInstance.destroy(true,true);} catch(_){} }
    const slidesCount = containerEl.querySelectorAll('.swiper-slide').length;
    const instance = new Swiper(containerEl, {
      pagination: { el: containerEl.querySelector('.swiper-pagination'), clickable:true },
      navigation: {
        nextEl: containerEl.querySelector('.swiper-button-next'),
        prevEl: containerEl.querySelector('.swiper-button-prev')
      },
      slidesPerView: 1,
      speed:420,
      spaceBetween:8,
      allowTouchMove:true,
      grabCursor:true,
      resistanceRatio:.65,
      touchStartPreventDefault:false,
      loop: slidesCount > 1,
      observer:true,
      observeParents:true
    });
    containerEl.__swiperInstance = instance;
    // Hide pagination if only one slide
    const pag = containerEl.querySelector('.swiper-pagination');
    if (pag) pag.style.display = slidesCount <= 1 ? 'none' : '';
    setTimeout(()=>{ try { instance.update(); } catch(_){} }, 60);
  }, [categories]);

  const useTwoRows = categories.length > 10;
  const perPage = useTwoRows ? 10 : 5;
  const slides = [];
  for (let i=0; i<categories.length; i+=perPage){
    const slice = categories.slice(i, i+perPage);
    slides.push(
      <div className={`swiper-slide ${useTwoRows ? 'two-rows' : 'one-row'}`} key={i}>
        {slice.map(category => (
          <div key={category.id} className="category-item" onClick={()=> window.location.href='/shop'}>
            <div className="category-icon" style={{ backgroundColor: category.image ? 'transparent' : category.color }}>
              {category.image ? (
                <img src={category.image} loading="lazy" alt={category.name} style={{width:'100%',height:'100%',objectFit:'cover'}} />
              ) : (
                <span>{category.icon}</span>
              )}
            </div>
            <span className="category-name">{category.name}</span>
          </div>
        ))}
      </div>
    );
  }

  return (
    <section className="categories-section">
      <h3 className="categories-title">Kategori</h3>
      <div className="categories-swiper">
        <div className="swiper" id="categoriesSwiper" ref={ref}>
          <div className="swiper-wrapper">{slides}</div>
          <div className="swiper-pagination" />
          <div className="swiper-button-prev" />
          <div className="swiper-button-next" />
        </div>
      </div>
    </section>
  );
};
