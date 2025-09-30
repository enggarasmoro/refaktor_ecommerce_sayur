import { useEffect, useState } from 'react';
import { useToast } from '../context/ToastContext';
import { getCategories } from '../api/client';

export function useCategories(){
  const [categories, setCategories] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const toast = useToast();

  useEffect(()=>{
    let active = true;
    (async () => {
      try {
        const data = await getCategories();
        if (!active) return;
        if (Array.isArray(data) && data.length) setCategories(data);
      } catch(e){
        if (!active) return;
        setError(e);
        toast && toast.error('Gagal memuat kategori');
        // fallback categories
        setCategories([
          { id: 1, name: 'Sayuran', icon: '🥗', color: '#96CEB4' },
          { id: 2, name: 'Buah', icon: '🍎', color: '#FF6B6B' },
          { id: 3, name: 'Daging', icon: '🥩', color: '#FF8E53' },
          { id: 4, name: 'Seafood', icon: '🐟', color: '#81ECEC' }
        ]);
      } finally { if (active) setLoading(false); }
    })();
    return () => { active = false; };
  }, []);

  return { categories, loading, error };
}
