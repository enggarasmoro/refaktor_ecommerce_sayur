import React, { useEffect, useRef } from 'react';
import { useProducts } from '../hooks/useProducts';
import { useCart } from '../context/CartContext';

export const ProductsGrid = ({ onOpenDetail }) => {
  const { products, hasMore, loading, initialLoading, loadNext } = useProducts(6);
  const { cart, increment, decrement } = useCart();
  const sentinelRef = useRef(null);

  useEffect(()=>{
    const sentinel = sentinelRef.current;
    if (!sentinel || !('IntersectionObserver' in window)) return;
    const io = new IntersectionObserver(entries => {
      entries.forEach(e => { if (e.isIntersecting && hasMore && !loading) loadNext(); });
    }, { rootMargin: '250px 0px 0px 0px' });
    io.observe(sentinel);
    return () => io.disconnect();
  }, [hasMore, loading, loadNext]);

  if (initialLoading) {
    return (
      <section className="products-section">
        <h3 className="products-title">Produk Pilihan</h3>
        <div className="products-grid">
          {Array.from({length:4}).map((_,i)=>(
            <div key={i} className="skeleton-card">
              <div className="skeleton-block skeleton-media" />
              <div className="skeleton-lines">
                <div className="skeleton-block skeleton-line" style={{width:'80%'}} />
                <div className="skeleton-block skeleton-line" style={{width:'60%'}} />
                <div className="skeleton-block skeleton-line" style={{width:'50%', marginTop:'10px'}} />
              </div>
            </div>
          ))}
        </div>
      </section>
    );
  }

  return (
    <section className="products-section">
      <h3 className="products-title">Produk Pilihan</h3>
      <div className="products-grid">
        {products.map(p => {
          const qty = cart[p.id]||0;
          const showDiscount = p.discount && p.old_price;
          const priceFmt = (val)=> 'Rp'+val.toLocaleString('id-ID');
          return (
            <div key={p.id} className="product-card">
              {showDiscount && <div className="discount-badge">{p.discount}%</div>}
              <div className="product-media" onClick={()=>onOpenDetail(p)}>
                {p.media_type==='video' ? (
                  <video src={p.media} muted playsInline loop preload="metadata" />
                ) : (
                  <img src={p.media} loading="lazy" alt={p.name} />
                )}
              </div>
              <div className="product-body">
                <h4 className="product-name">{p.name}</h4>
                <p className="product-sub">{p.subtitle}</p>
                <p className="product-size">{p.size}</p>
                <div className="price-row">
                  <span className="price-current">{priceFmt(p.price)}</span>
                  {p.old_price && <span className="price-old">{priceFmt(p.old_price)}</span>}
                </div>
              </div>
              {qty===0 ? (
                <button className="add-btn" onClick={()=>increment(p)}>+</button>
              ) : (
                <div className="qty-box">
                  <button className="qty-btn" onClick={()=>decrement(p)}>−</button>
                  <span>{qty}</span>
                  <button className="qty-btn" onClick={()=>increment(p)}>+</button>
                </div>
              )}
            </div>
          );
        })}
      </div>
      <div ref={sentinelRef} className="infinite-loader">
        {hasMore ? (loading ? 'Memuat...' : 'Gulir untuk muat lagi') : 'Semua produk sudah ditampilkan'}
      </div>
    </section>
  );
};
