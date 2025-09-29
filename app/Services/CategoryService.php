<?php

namespace App\Services;

use App\Repositories\CategoryRepositoryInterface;

class CategoryService
{
    public function __construct(private CategoryRepositoryInterface $categories) {}

    public function mobileList(): array
    {
        $raw = $this->categories->allActiveForMobile();
        $fallbackColors = [
            '#FF6B6B', '#4ECDC4', '#FF8E53', '#96CEB4',
            '#FFEAA7', '#DDA0DD', '#FF7675', '#74B9FF',
            '#FDCB6E', '#81ECEC', '#A29BFE', '#FD79A8'
        ];
        $fallbackEmojis = [
            '🛒', '🥩', '🥛', '🍞',
            '🐟', '🍖', '🥗', '🍲',
            '🧀', '🥤', '🍇', '🥨'
        ];
        $result = [];
        foreach ($raw as $index=>$kategori) {
            $imageUrl = null;
            if ($kategori->gambar) {
                $imageUrl = (strpos($kategori->gambar, 'http') === 0)
                    ? $kategori->gambar
                    : asset('frontend/images/categories/' . $kategori->gambar);
            }
            $result[] = [
                'id' => $kategori->id,
                'name' => $kategori->nama,
                'image' => $imageUrl,
                'icon' => $kategori->icon_emoji ?: $fallbackEmojis[$index % count($fallbackEmojis)],
                'color' => $kategori->warna ?: $fallbackColors[$index % count($fallbackColors)]
            ];
        }
        return $result;
    }
}
