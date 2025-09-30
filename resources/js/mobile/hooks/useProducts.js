import { useCallback, useEffect, useRef, useState } from 'react';
import { getProducts } from '../api/client';

export function useProducts(perPage = 6){
  const [products, setProducts] = useState([]);
  const [page, setPage] = useState(1);
  const [hasMore, setHasMore] = useState(true);
  const [loading, setLoading] = useState(false);
  const [initialLoading, setInitialLoading] = useState(true);
  const [error, setError] = useState(null);

  const load = useCallback(async (targetPage = 1) => {
    if (loading || !hasMore) return;
    setLoading(true);
    try {
      const { items, hasMore: more } = await getProducts(targetPage, perPage);
      setProducts(prev => [...prev, ...items]);
      setHasMore(more);
      setPage(targetPage);
    } catch(e){
      setError(e);
      setHasMore(false);
    } finally {
      setLoading(false);
      setInitialLoading(false);
    }
  }, [loading, hasMore, perPage]);

  useEffect(()=>{ load(1); }, [load]);

  return { products, page, hasMore, loading, initialLoading, error, loadNext: ()=>load(page+1) };
}
