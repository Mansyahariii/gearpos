<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GearPos - Sistem Manajemen Sparepart Motor Modern</title>
    <meta name="description" content="Kelola stok sparepart motor, penjualan, dan inventaris dengan mudah bersama GearPos.">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: #F8F9FA;
        }
        
        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 80px;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0px 1px 2px -1px rgba(0, 0, 0, 0.10);
            border-bottom: 1.5px solid rgba(0, 0, 0, 0.10);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 120px;
            z-index: 1000;
        }
        
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .nav-logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(180deg, #10B981 0%, #3B82F6 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            font-weight: 400;
        }
        
        .nav-logo-text {
            color: #1A1A1A;
            font-size: 24px;
            font-weight: 400;
            line-height: 32px;
        }
        
        .nav-links {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        .nav-link {
            padding: 8px 16px;
            border-radius: 12px;
            color: #6B7280;
            font-size: 16px;
            font-weight: 400;
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .nav-link:hover {
            background: rgba(16, 185, 129, 0.1);
            color: #10B981;
        }
        
        .nav-link.active {
            background: rgba(16, 185, 129, 0.1);
            color: #10B981;
        }
        
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .btn {
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .btn-outline {
            background: #F8F9FA;
            border: 1.5px solid rgba(0, 0, 0, 0.10);
            color: #1A1A1A;
        }
        
        .btn-primary {
            background: #10B981;
            border: none;
            color: white;
        }
        
        .btn-primary:hover {
            background: #059669;
        }
        
        .btn-white {
            background: white;
            border: none;
            color: #10B981;
        }
        
        .btn-ghost {
            background: transparent;
            border: 1.5px solid white;
            color: white;
        }
        
        /* Hero Section */
        .hero {
            padding: 176px 120px 96px;
            background: linear-gradient(135deg, #F9FAFB 0%, #F3F4F6 100%);
            display: flex;
            align-items: center;
            gap: 48px;
        }
        
        .hero-content {
            flex: 1;
            max-width: 700px;
        }
        
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(16, 185, 129, 0.10);
            border-radius: 9999px;
            margin-bottom: 24px;
        }
        
        .hero-badge i {
            color: #10B981;
            font-size: 16px;
        }
        
        .hero-badge span {
            color: #10B981;
            font-size: 14px;
            font-weight: 400;
        }
        
        .hero-title {
            color: #1A1A1A;
            font-size: 60px;
            font-weight: 400;
            line-height: 60px;
            margin-bottom: 24px;
        }
        
        .hero-description {
            color: #6B7280;
            font-size: 20px;
            font-weight: 400;
            line-height: 28px;
            margin-bottom: 32px;
            max-width: 695px;
        }
        
        .hero-buttons {
            display: flex;
            gap: 16px;
            margin-bottom: 48px;
        }
        
        .btn-lg {
            padding: 10px 24px;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .hero-stats {
            display: flex;
            gap: 32px;
        }
        
        .stat-item {
            display: flex;
            flex-direction: column;
        }
        
        .stat-value {
            color: #1A1A1A;
            font-size: 30px;
            font-weight: 400;
            line-height: 36px;
        }
        
        .stat-label {
            color: #6B7280;
            font-size: 14px;
            font-weight: 400;
            line-height: 20px;
        }
        
        .hero-image {
            flex: 1;
            max-width: 732px;
            position: relative;
        }
        
        .hero-image::before {
            content: '';
            position: absolute;
            inset: -10px;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.20) 0%, rgba(59, 130, 246, 0.20) 100%);
            border-radius: 16px;
            z-index: 0;
        }
        
        .hero-image img {
            position: relative;
            width: 100%;
            height: auto;
            border-radius: 16px;
            box-shadow: 0px 25px 50px -12px rgba(0, 0, 0, 0.25);
            z-index: 1;
        }
        
        /* Features Section */
        .features {
            padding: 96px 120px;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 48px;
        }
        
        .section-title {
            color: #1A1A1A;
            font-size: 36px;
            font-weight: 400;
            line-height: 40px;
            margin-bottom: 16px;
        }
        
        .section-subtitle {
            color: #6B7280;
            font-size: 20px;
            font-weight: 400;
            line-height: 28px;
            max-width: 672px;
            margin: 0 auto;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
        }
        
        .feature-card {
            background: white;
            border-radius: 16px;
            border: 1.5px solid rgba(0, 0, 0, 0.10);
            padding: 24px;
        }
        
        .feature-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(180deg, #10B981 0%, #3B82F6 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }
        
        .feature-icon i {
            color: white;
            font-size: 28px;
        }
        
        .feature-title {
            color: #1A1A1A;
            font-size: 20px;
            font-weight: 400;
            line-height: 28px;
            margin-bottom: 8px;
        }
        
        .feature-description {
            color: #6B7280;
            font-size: 16px;
            font-weight: 400;
            line-height: 24px;
        }
        
        /* Testimonials Section */
        .testimonials {
            padding: 96px 120px;
            background: #F9FAFB;
        }
        
        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
        }
        
        .testimonial-card {
            background: white;
            border-radius: 16px;
            border: 1.5px solid rgba(0, 0, 0, 0.10);
            padding: 24px;
        }
        
        .testimonial-stars {
            display: flex;
            gap: 4px;
            margin-bottom: 16px;
        }
        
        .testimonial-stars i {
            color: #F59E0B;
            font-size: 18px;
        }
        
        .testimonial-text {
            color: #6B7280;
            font-size: 16px;
            font-style: italic;
            font-weight: 400;
            line-height: 24px;
            margin-bottom: 16px;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .testimonial-avatar {
            width: 48px;
            height: 48px;
            border-radius: 9999px;
            background: linear-gradient(135deg, #10B981 0%, #3B82F6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            font-weight: 500;
        }
        
        .testimonial-info h4 {
            color: #1A1A1A;
            font-size: 16px;
            font-weight: 400;
            line-height: 24px;
        }
        
        .testimonial-info p {
            color: #6B7280;
            font-size: 14px;
            font-weight: 400;
            line-height: 20px;
        }
        
        /* CTA Section */
        .cta {
            padding: 96px 120px;
            background: linear-gradient(180deg, #10B981 0%, #3B82F6 100%);
            text-align: center;
        }
        
        .cta-title {
            color: white;
            font-size: 36px;
            font-weight: 400;
            line-height: 40px;
            margin-bottom: 16px;
        }
        
        .cta-description {
            color: rgba(255, 255, 255, 0.90);
            font-size: 20px;
            font-weight: 400;
            line-height: 28px;
            max-width: 667px;
            margin: 0 auto 32px;
        }
        
        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 16px;
        }
        
        /* Footer */
        .footer {
            padding: 48px 120px;
            background: #101828;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 32px;
            margin-bottom: 32px;
        }
        
        .footer-brand .nav-logo {
            margin-bottom: 16px;
        }
        
        .footer-brand .nav-logo-text {
            color: white;
        }
        
        .footer-brand p {
            color: #D1D5DC;
            font-size: 14px;
            font-weight: 400;
            line-height: 20px;
            margin-bottom: 16px;
            max-width: 300px;
        }
        
        .footer-social {
            display: flex;
            gap: 12px;
        }
        
        .footer-social a {
            width: 36px;
            height: 36px;
            background: #1E2939;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #D1D5DC;
            font-size: 18px;
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .footer-social a:hover {
            background: #10B981;
            color: white;
        }
        
        .footer-column h3 {
            color: white;
            font-size: 18px;
            font-weight: 500;
            line-height: 27px;
            margin-bottom: 16px;
        }
        
        .footer-column ul {
            list-style: none;
        }
        
        .footer-column ul li {
            margin-bottom: 8px;
        }
        
        .footer-column ul li a {
            color: #D1D5DC;
            font-size: 16px;
            font-weight: 400;
            line-height: 24px;
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .footer-column ul li a:hover {
            color: #10B981;
        }
        
        .footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-bottom: 12px;
        }
        
        .footer-contact-item i {
            color: #D1D5DC;
            font-size: 18px;
            margin-top: 2px;
        }
        
        .footer-contact-item span {
            color: #D1D5DC;
            font-size: 14px;
            font-weight: 400;
            line-height: 20px;
        }
        
        .footer-bottom {
            padding-top: 32px;
            border-top: 1.5px solid #1E2939;
            text-align: center;
        }
        
        .footer-bottom p {
            color: #D1D5DC;
            font-size: 14px;
            font-weight: 400;
            line-height: 20px;
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .navbar, .hero, .features, .testimonials, .cta, .footer {
                padding-left: 40px;
                padding-right: 40px;
            }
        }
        
        @media (max-width: 1024px) {
            .hero {
                flex-direction: column;
                text-align: center;
            }
            
            .hero-content {
                max-width: 100%;
            }
            
            .hero-buttons, .hero-stats {
                justify-content: center;
            }
            
            .hero-image {
                max-width: 100%;
            }
            
            .features-grid, .testimonials-grid {
                grid-template-columns: 1fr;
            }
            
            .footer-content {
                grid-template-columns: 1fr 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .navbar {
                padding: 0 20px;
            }
            
            .nav-links {
                display: none;
            }
            
            .hero-title {
                font-size: 36px;
                line-height: 40px;
            }
            
            .hero-description {
                font-size: 16px;
                line-height: 24px;
            }
            
            .hero-stats {
                flex-direction: column;
                gap: 16px;
                align-items: center;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-logo">
            <div class="nav-logo-icon">GP</div>
            <span class="nav-logo-text">GearPos</span>
        </div>
        
        <div class="nav-links">
            <a href="#" class="nav-link active">Home</a>
            <a href="#features" class="nav-link">Features</a>
            <a href="#contact" class="nav-link">Contact</a>
        </div>
        
        <div class="nav-actions">
            <a href="#contact" class="btn btn-outline">Hubungi Kami</a>
            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-badge">
                <i class="bi bi-lightning-fill"></i>
                <span>Trusted by 10,000+ businesses</span>
            </div>
            
            <h1 class="hero-title">Sistem Manajemen Sparepart Motor Modern</h1>
            
            <p class="hero-description">
                Kelola stok sparepart motor, penjualan, dan inventaris dengan mudah bersama GearPos. 
                Tingkatkan efisiensi toko sparepart motor Anda dengan teknologi terkini.
            </p>
            
            <div class="hero-buttons">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                    Mulai Sekarang
                    <i class="bi bi-arrow-right"></i>
                </a>
                <a href="#features" class="btn btn-outline btn-lg">Lihat Demo</a>
            </div>
            
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-value">10K+</span>
                    <span class="stat-label">Pengguna Aktif</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">99.9%</span>
                    <span class="stat-label">Uptime</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">24/7</span>
                    <span class="stat-label">Support</span>
                </div>
            </div>
        </div>
        
        <div class="hero-image">
            <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=732&h=437&fit=crop" 
                 alt="Dashboard GearPos">
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="features" id="features">
        <div class="section-header">
            <h2 class="section-title">Mengapa Memilih GearPos?</h2>
            <p class="section-subtitle">
                Platform manajemen sparepart motor yang dirancang untuk meningkatkan produktivitas dan efisiensi toko Anda
            </p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-check2-square"></i>
                </div>
                <h3 class="feature-title">Mudah Digunakan</h3>
                <p class="feature-description">
                    Interface yang intuitif dan mudah dipelajari untuk semua pengguna
                </p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <h3 class="feature-title">Laporan Real-time</h3>
                <p class="feature-description">
                    Dapatkan insight bisnis dengan laporan dan analitik secara real-time
                </p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-phone"></i>
                </div>
                <h3 class="feature-title">Integrasi Multi-perangkat</h3>
                <p class="feature-description">
                    Sinkronisasi otomatis di semua perangkat: desktop, tablet, dan mobile
                </p>
            </div>
        </div>
    </section>
    
    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="section-header">
            <h2 class="section-title">Apa Kata Mereka?</h2>
            <p class="section-subtitle">
                Ribuan toko sparepart motor telah mempercayai GearPos untuk mengelola inventaris mereka
            </p>
        </div>
        
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-stars">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                </div>
                <p class="testimonial-text">
                    "GearPos mengubah cara kami mengelola stok sparepart motor. Sekarang tidak ada lagi sparepart yang terlewat dan laporan stok selalu akurat!"
                </p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">BS</div>
                    <div class="testimonial-info">
                        <h4>Budi Santoso</h4>
                        <p>Owner, Bengkel Motor Jaya</p>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-stars">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                </div>
                <p class="testimonial-text">
                    "Sistem yang sangat membantu untuk mengelola ribuan item sparepart motor. Pencarian cepat dan akurat. Highly recommended!"
                </p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">SN</div>
                    <div class="testimonial-info">
                        <h4>Siti Nurhaliza</h4>
                        <p>Manager, Toko Sparepart Motor Nusantara</p>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-stars">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                </div>
                <p class="testimonial-text">
                    "Integrasi antar cabang kami berjalan sempurna. GearPos adalah investasi terbaik untuk bisnis sparepart motor kami."
                </p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">AW</div>
                    <div class="testimonial-info">
                        <h4>Ahmad Wijaya</h4>
                        <p>CEO, Moto Parts Indonesia</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="cta">
        <h2 class="cta-title">Siap Meningkatkan Bisnis Anda?</h2>
        <p class="cta-description">
            Bergabunglah dengan ribuan toko sparepart motor yang telah berkembang bersama GearPos. 
            Dapatkan trial gratis 30 hari tanpa kartu kredit.
        </p>
        <div class="cta-buttons">
            <a href="{{ route('login') }}" class="btn btn-white btn-lg">
                Mulai Trial Gratis
                <i class="bi bi-arrow-right"></i>
            </a>
            <a href="#contact" class="btn btn-ghost btn-lg">Request Demo</a>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="footer-content">
            <div class="footer-brand">
                <div class="nav-logo">
                    <div class="nav-logo-icon">GP</div>
                    <span class="nav-logo-text">GearPos</span>
                </div>
                <p>Sistem manajemen modern untuk toko sparepart motor Anda.</p>
                <div class="footer-social">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-twitter"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
            
            <div class="footer-column">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Layanan</h3>
                <ul>
                    <li><a href="#">Sparepart Motor Honda</a></li>
                    <li><a href="#">Sparepart Motor Yamaha</a></li>
                    <li><a href="#">Aksesoris Motor</a></li>
                    <li><a href="#">Support 24/7</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Kontak</h3>
                <div class="footer-contact-item">
                    <i class="bi bi-geo-alt"></i>
                    <span>Jl. Sudirman No. 123, Jakarta Selatan, Indonesia</span>
                </div>
                <div class="footer-contact-item">
                    <i class="bi bi-telephone"></i>
                    <span>+62 21 1234 5678</span>
                </div>
                <div class="footer-contact-item">
                    <i class="bi bi-envelope"></i>
                    <span>info@gearpos.com</span>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2025 GearPos. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
