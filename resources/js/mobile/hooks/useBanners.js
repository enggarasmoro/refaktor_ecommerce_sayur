import { useEffect, useState } from 'react';
import { getBanners } from '../api/client';

export function useBanners(){
  const [banners, setBanners] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(()=>{
    let active = true;
    (async () => {
      try {
        const data = await getBanners();
        if (!active) return;
        if (data.length) setBanners(data); else setBanners([{ id:'default', name:'DISKON HINGGA 75RB', image:null, isDefault:true }]);
      } catch(e){
        if (!active) return;
        setError(e);
        setBanners([{ id:'default', name:'DISKON HINGGA 75RB', image:null, isDefault:true }]);
      } finally { if (active) setLoading(false); }
    })();
    return () => { active = false; };
  }, []);

  return { banners, loading, error };
}
