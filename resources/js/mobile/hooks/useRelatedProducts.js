import { useEffect, useState } from 'react';
import { getRelatedProducts } from '../api/client';
import { useToast } from '../context/ToastContext';

export function useRelatedProducts(detail){
  const [items, setItems] = useState([]);
  const [loading, setLoading] = useState(false);
  const toast = useToast();

  useEffect(()=>{
    if (!detail?.id) { setItems([]); return; }
    setLoading(true);
    getRelatedProducts(detail.id).then(d=>{
      setItems(Array.isArray(d) ? d : []);
    }).catch(()=>{ toast && toast.error('Gagal memuat produk terkait'); })
      .finally(()=> setLoading(false));
  }, [detail?.id]);

  return { items, loading };
}
