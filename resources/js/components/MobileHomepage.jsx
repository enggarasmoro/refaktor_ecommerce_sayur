import React, { useState } from 'react';
import './MobileHomepage.css';

const MobileHomepage = () => {
    const [selectedLocation, setSelectedLocation] = useState('Dikirim ke Cirendeu');
    const [searchQuery, setSearchQuery] = useState('');
    const [activeTab, setActiveTab] = useState('home');

    const categories = [
        { id: 1, name: 'Pesta Gajian', icon: '🎉', color: '#FF6B6B' },
        { id: 2, name: 'Kolaborasi', icon: '🤝', color: '#4ECDC4' },
        { id: 3, name: 'Daging', icon: '🥩', color: '#FF8E53' },
        { id: 4, name: 'Protein', icon: '🍖', color: '#96CEB4' },
        { id: 5, name: 'Susu & Dairy', icon: '🥛', color: '#FFEAA7' },
        { id: 6, name: 'Tuku di Separi', icon: '🛒', color: '#DDA0DD' },
        { id: 7, name: 'Steak', icon: '🥩', color: '#FF7675' },
        { id: 8, name: 'Segari\'s Kitchen', icon: '👨‍🍳', color: '#74B9FF' },
        { id: 9, name: 'Unggas', icon: '🐔', color: '#FDCB6E' },
        { id: 10, name: 'Seafood', icon: '🐟', color: '#81ECEC' },
        { id: 11, name: 'Produk Beku', icon: '❄️', color: '#A29BFE' },
        { id: 12, name: 'Bakery & Seragam', icon: '🍞', color: '#FD79A8' },
        { id: 13, name: 'Hotpot', icon: '🍲', color: '#FDCB6E' },
        { id: 14, name: 'Japanese BBQ', icon: '🍖', color: '#E84393' }
    ];

    const promoCards = [
        {
            id: 1,
            title: 'PESTA GAJIAN',
            subtitle: 'Diskon hingga 50%',
            color: 'linear-gradient(135deg, #00b894, #00a085)',
            image: '/api/placeholder/120/80'
        },
        {
            id: 2,
            title: 'BEST DEAL DAGING PREMIUM',
            subtitle: 'Mulai dari 19k',
            color: 'linear-gradient(135deg, #e17055, #d63031)',
            image: '/api/placeholder/120/80'
        },
        {
            id: 3,
            title: 'FLASH SALE',
            subtitle: 'Extreme Discount 50%',
            color: 'linear-gradient(135deg, #fd79a8, #e84393)',
            image: '/api/placeholder/120/80'
        },
        {
            id: 4,
            title: 'WEEKEND MOMENT NGEBIT MAKIN HAPPY!',
            subtitle: 'Diskon 22%',
            color: 'linear-gradient(135deg, #74b9ff, #0984e3)',
            image: '/api/placeholder/120/80'
        }
    ];

    return (
        <div className="mobile-homepage">
            {/* Header */}
            <header className="app-header">
                <div className="header-top">
                    <div className="location-section">
                        <i className="location-icon">📍</i>
                        <div className="location-text">
                            <span className="location-label">{selectedLocation}</span>
                            <span className="delivery-time">Hari ini | 1 jam sampai</span>
                        </div>
                        <i className="dropdown-icon">▼</i>
                    </div>
                    <div className="header-actions">
                        <i className="favorite-icon">🤍</i>
                    </div>
                </div>

                <div className="search-section">
                    <div className="search-container">
                        <i className="search-icon">🔍</i>
                        <input
                            type="text"
                            placeholder="Cari beragam kebutuhan harian"
                            value={searchQuery}
                            onChange={(e) => setSearchQuery(e.target.value)}
                            className="search-input"
                        />
                    </div>
                </div>
            </header>

            {/* Main Banner */}
            <section className="main-banner">
                <div className="banner-content">
                    <div className="banner-text">
                        <div className="promo-badge">KHUSUS PENGGUNA BARU!</div>
                        <h2 className="banner-title">DISKON HINGGA</h2>
                        <h1 className="discount-amount">75RB</h1>
                        <div className="promo-code">
                            <span>Code: FRESHNEW75</span>
                        </div>
                        <button className="cta-button">Klik di sini</button>
                    </div>
                    <div className="banner-image">
                        <img src="/api/placeholder/200/150" alt="Happy woman with groceries" />
                    </div>
                </div>
                <div className="banner-dots">
                    <span className="dot active"></span>
                    <span className="dot"></span>
                    <span className="dot"></span>
                    <span className="dot"></span>
                </div>
            </section>

            {/* Categories Grid */}
            <section className="categories-section">
                <div className="categories-grid">
                    {categories.slice(0, 8).map((category) => (
                        <div key={category.id} className="category-item">
                            <div
                                className="category-icon"
                                style={{ backgroundColor: category.color }}
                            >
                                <span>{category.icon}</span>
                            </div>
                            <span className="category-name">{category.name}</span>
                        </div>
                    ))}
                </div>

                {/* Second row of categories */}
                <div className="categories-grid">
                    {categories.slice(8, 14).map((category) => (
                        <div key={category.id} className="category-item">
                            <div
                                className="category-icon"
                                style={{ backgroundColor: category.color }}
                            >
                                <span>{category.icon}</span>
                            </div>
                            <span className="category-name">{category.name}</span>
                        </div>
                    ))}
                </div>
            </section>

            {/* Promo Cards Grid */}
            <section className="promo-section">
                <div className="promo-grid">
                    {promoCards.map((card) => (
                        <div
                            key={card.id}
                            className="promo-card"
                            style={{ background: card.color }}
                        >
                            <div className="promo-text">
                                <h3>{card.title}</h3>
                                <p>{card.subtitle}</p>
                            </div>
                            <div className="promo-image">
                                <img src={card.image} alt={card.title} />
                            </div>
                        </div>
                    ))}
                </div>
            </section>

            {/* Discount Banner */}
            <section className="discount-banner">
                <div className="discount-content">
                    <i className="discount-icon">💰</i>
                    <span className="discount-text">
                        Diskon 15% hingga 75RB berjang 48 Seli untuk voucher nya
                    </span>
                </div>
            </section>

            {/* Bottom Navigation */}
            <nav className="bottom-navigation">
                <div
                    className={`nav-item ${activeTab === 'home' ? 'active' : ''}`}
                    onClick={() => setActiveTab('home')}
                >
                    <i className="nav-icon">🏠</i>
                    <span className="nav-label">Home</span>
                </div>

                <div
                    className={`nav-item ${activeTab === 'category' ? 'active' : ''}`}
                    onClick={() => setActiveTab('category')}
                >
                    <i className="nav-icon">📱</i>
                    <span className="nav-label">Kategori</span>
                </div>

                <div
                    className={`nav-item ${activeTab === 'chat' ? 'active' : ''}`}
                    onClick={() => setActiveTab('chat')}
                >
                    <i className="nav-icon">🎧</i>
                    <span className="nav-label">Chat CS</span>
                </div>

                <div
                    className={`nav-item ${activeTab === 'cart' ? 'active' : ''}`}
                    onClick={() => setActiveTab('cart')}
                >
                    <i className="nav-icon">🛒</i>
                    <span className="nav-label">Keranjang</span>
                    <span className="cart-badge">1</span>
                </div>

                <div
                    className={`nav-item ${activeTab === 'profile' ? 'active' : ''}`}
                    onClick={() => setActiveTab('profile')}
                >
                    <i className="nav-icon">👤</i>
                    <span className="nav-label">Akun</span>
                </div>
            </nav>
        </div>
    );
};

export default MobileHomepage;
