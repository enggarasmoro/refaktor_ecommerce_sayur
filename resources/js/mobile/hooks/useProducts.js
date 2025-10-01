import { useCallback, useEffect, useRef, useState } from 'react';
import { useToast } from '../context/ToastContext';
import { getProducts } from '../api/client';

export function useProducts(perPage = 6){
  const [products, setProducts] = useState([]);
  const [page, setPage] = useState(1);
  const [hasMore, setHasMore] = useState(true);
  const [loading, setLoading] = useState(false);
  const [initialLoading, setInitialLoading] = useState(true);
  const [error, setError] = useState(null);
  const toast = useToast();

  // Track last successfully loaded page to avoid double fetches (e.g., rapid IO triggers)
  const lastLoadedPageRef = useRef(0);
  const inFlightRef = useRef(false);

  const load = useCallback(async (targetPage = 1) => {
    if (inFlightRef.current) return;               // hard guard vs race
    if (loading || !hasMore) return;               // state guard
    if (targetPage <= lastLoadedPageRef.current) return; // already loaded / stale request
    inFlightRef.current = true;
    setLoading(true);
    try {
      const { items, hasMore: more } = await getProducts(targetPage, perPage);
      setProducts(prev => {
        if (!items || items.length === 0) return prev;
        const existingIds = new Set(prev.map(p => p.id));
        const unique = [];
        const duplicates = [];
        for (const it of items) {
          if (existingIds.has(it.id)) { duplicates.push(it.id); continue; }
          existingIds.add(it.id);
          unique.push(it);
        }
        if (duplicates.length) {
          // Temporary debug; can be removed after confirming backend pagination correctness
          if (process.env.NODE_ENV !== 'production') {
            // eslint-disable-next-line no-console
            console.warn('[useProducts] Duplicate product ids skipped:', duplicates.join(','));
          }
        }
        return [...prev, ...unique];
      });
      setHasMore(more);
      setPage(targetPage);
      lastLoadedPageRef.current = targetPage;
    } catch(e){
      setError(e);
      setHasMore(false);
      toast && toast.error('Gagal memuat produk');
    } finally {
      inFlightRef.current = false;
      setLoading(false);
      setInitialLoading(false);
    }
  }, [loading, hasMore, perPage, toast]);

  useEffect(()=>{ load(1); }, [load]);

  const reset = useCallback(async ()=>{
    setProducts([]);
    setPage(1);
    setHasMore(true);
    setInitialLoading(true);
    setError(null);
    lastLoadedPageRef.current = 0;
    await load(1);
  }, [load]);

  return { products, page, hasMore, loading, initialLoading, error, loadNext: ()=>load(page+1), reset };
}
