// Central API client with version prefix & envelope normalization
const API_PREFIX = '/api/v1';

const extract = (json) => {
  if (!json) return { data: [], meta: {} };
  if (Array.isArray(json)) return { data: json, meta: {} };
  const { data, meta, ...rest } = json;
  if (Array.isArray(data)) return { data, meta: meta || {}, rest };
  return { data: [], meta: meta || {}, rest };
};

export async function apiGet(path, params = {}) {
  const url = new URL(API_PREFIX + path, window.location.origin);
  Object.entries(params).forEach(([k,v]) => { if (v !== undefined && v !== null) url.searchParams.append(k, v); });
  const res = await fetch(url.toString(), { headers: { 'Accept': 'application/json' } });
  if (!res.ok) throw new Error('HTTP '+res.status);
  const json = await res.json().catch(() => ({}));
  return extract(json);
}

export async function getBanners(){
  const { data } = await apiGet('/banners');
  return data.map(b => ({ ...b, image: b.image || b.url || b.path || null }));
}

export async function getCategories(){
  const { data } = await apiGet('/categories');
  return data;
}

export async function getProducts(page=1, per_page=6){
  const { data, meta, rest } = await apiGet('/products', { page, per_page });
  // Accept either meta.has_more or rest.next_page lexical hint
  const hasMore = typeof meta.has_more !== 'undefined' ? !!meta.has_more : (rest.next_page !== false && data.length > 0);
  return { items: data, hasMore };
}

export async function getProductDetail(id){
  try {
    const url = `/api/v1/products/${id}`;
    const res = await fetch(url, { headers:{ 'Accept':'application/json' } });
    if (!res.ok) throw new Error('HTTP '+res.status);
    const json = await res.json();
    if (json && json.data) return json.data; return json;
  } catch (e) { return null; }
}
