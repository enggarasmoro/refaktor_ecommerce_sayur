import { useEffect, useState } from 'react';
import { useToast } from '../context/ToastContext';
import { getProductDetail } from '../api/client';

// Manage detail modal state & enrichment
export function useProductDetail(){
  const [open, setOpen] = useState(false);
  const [detail, setDetail] = useState(null);
  const [loading, setLoading] = useState(false);
  const toast = useToast();

  const openDetail = (product, { target } = {}) => {
    // Base object from list
    const base = { ...product };
    base.media_list = [];
    if (product.media) {
      const normalizeUrl = (u)=> u && !u.startsWith('http') && !u.startsWith('/') ? ('/frontend/'+u.replace(/^frontend\//,'')) : u;
      base.media_list.push({ type: product.media_type || (product.media.match(/\.mp4($|\?)/) ? 'video':'image'), url: normalizeUrl(product.media) });
    }
    base.specs = [
      { label: 'Berat', value: product.size || '–' },
      { label: 'Kategori', value: product.category_name || 'Umum' },
      { label: 'Stok', value: (product.stock ?? 'Tersedia') },
      { label: 'Asal', value: product.origin || 'Lokal' },
    ];
    base.description = product.description || 'Produk segar berkualitas. Deskripsi lengkap akan tampil di sini.';
    base.brochure_image = null;

    setDetail(base);
    setOpen(true);
    setLoading(true);

    getProductDetail(product.id).then(d => {
      if (!d) { toast && toast.error('Gagal memuat detail produk'); return; }
      const enriched = { ...base };
      if (Array.isArray(d.media_list) && d.media_list.length) {
        const norm = (u)=> u && !u.startsWith('http') && !u.startsWith('/') ? ('/frontend/'+u.replace(/^frontend\//,'')) : u;
        enriched.media_list = d.media_list.map(m => ({ type: m.type || 'image', url: norm(m.url || m.path || m) }));
      }
      if (d.description) enriched.description = d.description;
      if (Array.isArray(d.specs) && d.specs.length) enriched.specs = d.specs;
      if (d.brochure_image) {
        const n = d.brochure_image;
        const norm = (u)=> u && !u.startsWith('http') && !u.startsWith('/') ? ('/frontend/'+u.replace(/^frontend\//,'')) : u;
        enriched.brochure_image = norm(n);
      }
      if (d.spec_html) { enriched.spec_html = d.spec_html; enriched.specs = []; }
      setDetail(enriched);
    }).catch(()=>{ toast && toast.error('Gagal memuat detail produk'); }).finally(()=> setLoading(false));
  };

  const closeDetail = () => { setOpen(false); setTimeout(()=> setDetail(null), 300); };

  return { open, detail, loading, openDetail, closeDetail };
}
