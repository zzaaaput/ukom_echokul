<!-- Footer Modern -->
<footer class="position-relative overflow-hidden text-light" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #1a1a2e 100%);">
    <style>
        footer {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .footer-bg-pattern {
            position: absolute;
            inset: 0;
            opacity: 0.05;
            pointer-events: none;
        }
        .footer-blur-1 {
            position: absolute;
            top: 0;
            left: 0;
            width: 384px;
            height: 384px;
            background: #3b82f6;
            border-radius: 50%;
            filter: blur(80px);
        }
        .footer-blur-2 {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 384px;
            height: 384px;
            background: #a855f7;
            border-radius: 50%;
            filter: blur(80px);
        }
        .footer-icon-box {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .footer-icon-box-sm {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .footer-gradient-blue {
            background: linear-gradient(135deg, #3b82f6 0%, #9333ea 100%);
        }
        .footer-gradient-green {
            background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%);
        }
        .footer-gradient-orange {
            background: linear-gradient(135deg, #f97316 0%, #dc2626 100%);
        }
        .footer-gradient-pink {
            background: linear-gradient(135deg, #ec4899 0%, #9333ea 100%);
        }
        .footer-social-link {
            width: 40px;
            height: 40px;
            background: #374151;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #fff;
        }
        .footer-social-link:hover {
            transform: scale(1.1);
            color: #fff;
        }
        .footer-social-link.facebook:hover {
            background: #3b82f6;
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.5);
        }
        .footer-social-link.instagram:hover {
            background: #ec4899;
            box-shadow: 0 10px 25px rgba(236, 72, 153, 0.5);
        }
        .footer-social-link.twitter:hover {
            background: #60a5fa;
            box-shadow: 0 10px 25px rgba(96, 165, 250, 0.5);
        }
        .footer-social-link.youtube:hover {
            background: #dc2626;
            box-shadow: 0 10px 25px rgba(220, 38, 38, 0.5);
        }
        .footer-contact-box {
            width: 40px;
            height: 40px;
            background: #374151;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }
        .footer-contact-item:hover .footer-contact-box {
            background: #10b981;
        }
        .footer-contact-item:hover .footer-contact-box.email {
            background: #3b82f6;
        }
        .footer-contact-item:hover .footer-contact-box.phone {
            background: #9333ea;
        }
        .footer-link {
            color: #9ca3af;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .footer-link:hover {
            color: #fff;
            transform: translateX(8px);
        }
        .footer-link-dot {
            width: 8px;
            height: 8px;
            background: #f97316;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        .footer-link:hover .footer-link-dot {
            width: 12px;
            height: 12px;
        }
        .footer-newsletter-input {
            background: #374151;
            border: 1px solid #4b5563;
            color: #fff;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .footer-newsletter-input:focus {
            outline: none;
            border-color: #9333ea;
            box-shadow: 0 0 0 3px rgba(147, 51, 234, 0.2);
        }
        .footer-newsletter-btn {
            background: linear-gradient(to right, #9333ea 0%, #ec4899 100%);
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .footer-newsletter-btn:hover {
            background: linear-gradient(to right, #7c3aed 0%, #db2777 100%);
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(147, 51, 234, 0.5);
        }
        .footer-stat-box {
            background: rgba(55, 65, 81, 0.5);
            border-radius: 8px;
            padding: 12px;
            text-align: center;
        }
        .footer-back-to-top {
            position: fixed;
            bottom: 32px;
            right: 32px;
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #9333ea 0%, #ec4899 100%);
            color: #fff;
            border: none;
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 1050;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .footer-back-to-top:hover {
            transform: scale(1.1);
            box-shadow: 0 10px 25px rgba(147, 51, 234, 0.5);
        }
        .footer-logo-box {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #3b82f6 0%, #9333ea 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: bold;
            font-size: 1.125rem;
        }
    </style>
    <!-- Background Pattern -->
    <div class="footer-bg-pattern">
        <div class="footer-blur-1"></div>
        <div class="footer-blur-2"></div>
    </div>

    <!-- Main Footer Content -->
    <div class="container px-4 px-md-5 py-5 position-relative" style="z-index: 10;">
        <div class="row g-4 mb-4">
            
            <!-- About Section -->
            <div class="col-lg-3 col-md-6">
                <div class="mb-4">
                    <h3 class="h5 fw-bold text-white mb-3 d-flex align-items-center gap-2">
                        <span class="footer-icon-box footer-gradient-blue">
                            <svg class="text-white" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </span>
                        <span>Tentang Kami</span>
                    </h3>
                    <p class="text-muted small lh-base">
                        Website komunikasi antar ekstrakurikuler di sekolah sebagai wadah informasi, diskusi, dan kolaborasi siswa.
                    </p>
                </div>
                
                <!-- Social Media -->
                <div>
                    <h6 class="text-white fw-semibold mb-3 small">Ikuti Kami</h6>
                    <div class="d-flex gap-2">
                        <a href="#" class="footer-social-link facebook">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="footer-social-link instagram">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="footer-social-link twitter">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="#" class="footer-social-link youtube">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Section -->
            <div class="col-lg-3 col-md-6">
                <h3 class="h6 fw-bold text-white mb-4 d-flex align-items-center gap-2">
                    <span class="footer-icon-box-sm footer-gradient-green">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </span>
                    <span>Alamat</span>
                </h3>
                <div class="d-flex flex-column gap-3">
                    <div class="footer-contact-item d-flex align-items-start gap-3">
                        <div class="footer-contact-box">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <p class="text-muted small mb-0 lh-base">
                            Jl. Pendidikan No. 12,<br>Kota Pelajar, Indonesia
                        </p>
                    </div>
                    
                    <div class="footer-contact-item d-flex align-items-start gap-3">
                        <div class="footer-contact-box email">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white fw-semibold mb-1 small">Email</p>
                            <a href="mailto:info@echokul.sch.id" class="text-muted text-decoration-none small">info@echokul.sch.id</a>
                        </div>
                    </div>
                    
                    <div class="footer-contact-item d-flex align-items-start gap-3">
                        <div class="footer-contact-box phone">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white fw-semibold mb-1 small">Telepon</p>
                            <a href="tel:+62123456789" class="text-muted text-decoration-none small">+62 123 456 789</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-3 col-md-6">
                <h3 class="h6 fw-bold text-white mb-4 d-flex align-items-center gap-2">
                    <span class="footer-icon-box-sm footer-gradient-orange">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </span>
                    <span>Link Terkait</span>
                </h3>
                <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                    <li>
                        <a href="#" class="footer-link">
                            <span class="footer-link-dot"></span>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="#" class="footer-link">
                            <span class="footer-link-dot"></span>
                            Kegiatan
                        </a>
                    </li>
                    <li>
                        <a href="#" class="footer-link">
                            <span class="footer-link-dot"></span>
                            Materi
                        </a>
                    </li>
                    <li>
                        <a href="#" class="footer-link">
                            <span class="footer-link-dot"></span>
                            Ekstrakurikuler
                        </a>
                    </li>
                    <li>
                        <a href="#" class="footer-link">
                            <span class="footer-link-dot"></span>
                            Forum Diskusi
                        </a>
                    </li>
                    <li>
                        <a href="#" class="footer-link">
                            <span class="footer-link-dot"></span>
                            Kontak
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-lg-3 col-md-6">
                <h3 class="h6 fw-bold text-white mb-4 d-flex align-items-center gap-2">
                    <span class="footer-icon-box-sm footer-gradient-pink">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </span>
                    <span>Newsletter</span>
                </h3>
                <p class="text-muted small mb-3">
                    Dapatkan update terbaru tentang kegiatan dan informasi ekstrakurikuler
                </p>
                <div class="mb-3">
                    <input 
                        type="email" 
                        placeholder="Email Anda" 
                        class="form-control footer-newsletter-input mb-2"
                    >
                    <button class="btn w-100 footer-newsletter-btn">
                        Berlangganan
                    </button>
                </div>
                
                <!-- Stats -->
                <div class="row g-2 pt-3" style="border-top: 1px solid #4b5563;">
                    <div class="col-6">
                        <div class="footer-stat-box">
                            <p class="h4 text-white fw-bold mb-0">25+</p>
                            <p class="text-muted mb-0" style="font-size: 0.75rem;">Ekstrakurikuler</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="footer-stat-box">
                            <p class="h4 text-white fw-bold mb-0">500+</p>
                            <p class="text-muted mb-0" style="font-size: 0.75rem;">Anggota Aktif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <hr class="border-secondary my-4">

        <!-- Bottom Footer -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-2">
                <div class="footer-logo-box">
                    <span>E</span>
                </div>
                <div>
                    <p class="text-white fw-bold mb-0">Echokul</p>
                </div>
            </div>
            
            <div class="text-center text-md-start">
                <p class="text-muted mb-1">
                    © 2025 <span class="text-white fw-semibold">Echokul</span> | 
                    <span style="color: #a855f7;">XII RPL-A</span>
                </p>
                <p class="text-muted mb-0 small">
                    Made with <span style="color: #dc2626;">❤</span> by Anisa, Ratna, Zahra
                </p>
            </div>
            
            <div class="d-flex gap-3 small">
                <a href="#" class="text-muted text-decoration-none">Privacy Policy</a>
                <span class="text-secondary">|</span>
                <a href="#" class="text-muted text-decoration-none">Terms of Service</a>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="footer-back-to-top" title="Kembali ke Atas">
        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>
</footer>