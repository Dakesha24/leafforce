<?= $this->extend('layout/master') ?>

<?= $this->section('content') ?>

<style>
    :root {
        --primary-color: #4169E1;
        /* Royal Blue */
        --secondary-color: #1E90FF;
        /* Dodger Blue */
        --accent-color: #87CEEB;
        /* Sky Blue */
        --background-color: #F0F8FF;
        /* Alice Blue */
        --text-color: #2C3E50;
        /* Dark Blue Gray */
    }

    body {
        font-family: 'Poppins', sans-serif;
        color: var(--text-color);
        background-color: var(--background-color);
    }

    .hero {
        background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('<?= base_url('assets/images/bg-buket2.jpg') ?>') no-repeat center 10%;
        background-size: cover;
        height: 90vh;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
        position: relative;
        transition: background-image 1s ease-in-out;
    }

    /* Added decorative flowers to hero section */
    .hero::before,
    .hero::after {
        content: '❀';
        /* Changed to a simpler flower symbol */
        position: absolute;
        font-size: 4rem;
        animation: float 6s infinite ease-in-out;
        color: var(--accent-color);
    }

    .hero::before {
        left: 5%;
        top: 20%;
    }

    .hero::after {
        right: 5%;
        bottom: 20%;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-20px);
        }
    }

    .hero h1 {
        font-size: 4rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .hero p {
        font-size: 1.8rem;
        margin-bottom: 2rem;
    }

    .btn-custom {
        background-color: var(--primary-color);
        border: none;
        color: white;
        padding: 15px 35px;
        font-size: 1.2rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border-radius: 30px;
    }

    .btn-custom:hover {
        background-color: var(--secondary-color);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(65, 105, 225, 0.3);
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 3rem;
        text-align: center;
        position: relative;
    }

    .section-title::before,
    .section-title::after {
        content: '❀';
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 2rem;
        color: var(--accent-color);
    }

    .section-title::before {
        left: 20%;
    }

    .section-title::after {
        right: 20%;
    }

    .product-card {
        border: none;
        border-radius: 3px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        background: white;
        margin-bottom: 2rem;
        cursor: pointer;
        text-decoration: none;
        display: block;
        color: inherit;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(65, 105, 225, 0.2);
        text-decoration: none;
        color: inherit;
    }

    .product-card img {
        transition: all 0.3s ease;
        height: 250px;
        object-fit: cover;
    }

    .product-card:hover img {
        transform: scale(1.1);
    }

    .product-card .card-body {
        padding: 1rem;
        /* Mengurangi padding */
        text-align: center;
        min-height: 110px;
        /* Menetapkan tinggi minimum untuk mencegah kekosongan */
    }

    .product-card .card-title {
        font-weight: 600;
        margin-bottom: 0.3rem;
        /* Mengurangi jarak antara judul dan harga */
        font-size: 1.3rem;
        /* Ukuran font judul */
    }

    .product-card .card-text {
        color: var(--text-color);
        font-weight: 700;
        font-size: 1rem;
        /* Ukuran font harga */
        margin-bottom: 0;
        /* Menghapus margin bawah */
    }


    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .hero h1 {
            font-size: 2.5rem;
        }

        .hero p {
            font-size: 1.2rem;
        }

        .col-md-6 {
            width: 50%;
            /* Show 2 products per row on mobile */
        }

        .product-card img {
            height: 180px;
        }

        .product-card .card-body {
            padding: 1rem;
        }

        .product-card .card-title {
            font-size: 1rem;
        }

        .product-card .card-text {
            font-size: 1rem;
        }

        .section-title::before,
        .section-title::after {
            display: none;
        }
    }

    .faq-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .faq-item {
        background: white;
        border-radius: 8px;
        margin-bottom: 16px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .faq-question {
        width: 100%;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        list-style: none;
        font-weight: 600;
        color: var(--text-color);
        font-size: 1.1rem;
    }

    .faq-question::-webkit-details-marker {
        display: none;
    }

    .faq-question i {
        color: var(--primary-color);
        transition: transform 0.3s ease;
    }

    details[open] .faq-question i {
        transform: rotate(180deg);
    }

    .faq-answer {
        padding: 0 20px 20px;
        color: var(--text-color);
        line-height: 1.6;
    }

    .faq-answer p {
        margin: 0;
    }

    .faq-question:hover {
        background-color: rgba(65, 105, 225, 0.05);
    }

    .faq-answer {
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .faq-container {
            padding: 0 20px;
        }

        .faq-question {
            font-size: 1rem;
            padding: 15px;
        }
    }
</style>

<!-- Hero Section -->
<section class="hero" id="home" data-bg-index="0">
    <div class="container">
        <h1 class="mb-4">LeafForce Bouquet</h1>
        <p class="lead mb-5">Koleksi bunga kami</p>
        <a href="#products" class="btn btn-custom btn-lg">Lihat Semua Koleksi Kami</a>
    </div>
</section>

<!-- Products Section -->
<section id="products" class="py-5">
    <div class="container">
        <h2 class="section-title">Semua Koleksi Kami</h2>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-lg-3 col-md-6 mb-4 px-1">
                    <a href="<?= base_url('product/' . urlencode($product['name'])) ?>" class="product-card h-100">
                        <div class="overflow-hidden">
                            <img src="<?= base_url('uploads/products/' . $product['image_m']) ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= $product['name'] ?></h5>
                            <p class="text-muted mb-2"><?= $product['category_name'] ?></p>
                            <p class="card-text mt-auto">
                                <?php if ($product['min_price'] == $product['max_price']): ?>
                                    Rp.<?= number_format($product['min_price'], 0, ',', '.') ?>
                                <?php else: ?>
                                    Rp.<?= number_format($product['min_price'], 0, ',', '.') ?> -
                                    Rp.<?= number_format($product['max_price'], 0, ',', '.') ?>
                                <?php endif; ?>
                            </p>
                            <p class="text-muted">Stok: <?= $product['total_stock'] ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section py-5" style="background-color: var(--background-color);" id="faq">
    <div class="container">
        <h2 class="section-title">Frequently Asked Questions</h2>

        <div class="faq-container">
            <details class="faq-item">
                <summary class="faq-question">
                    Dimana lokasi LeafForce?
                    <i class="fas fa-chevron-down"></i>
                </summary>
                <div class="faq-answer">
                    <p>Kami berlokasi di Jalan Geger Arum, dekat Universitas Pendidikan Indonesia (UPI), Bandung.</p>
                </div>
            </details>

            <details class="faq-item">
                <summary class="faq-question">
                    Apa saja jam operasional toko?
                    <i class="fas fa-chevron-down"></i>
                </summary>
                <div class="faq-answer">
                    <p>Kami buka setiap hari Senin-Minggu dari pukul 08.00-21.00 WIB. Untuk hari libur nasional, jam operasional mungkin berbeda.</p>
                </div>
            </details>

            <details class="faq-item">
                <summary class="faq-question">
                    Apakah menyediakan layanan pengiriman?
                    <i class="fas fa-chevron-down"></i>
                </summary>
                <div class="faq-answer">
                    <p>Saat ini kami tidak menyediakan layanan pengiriman, namun kami menyarankan untuk melakukan COD di daerah UPI.</p>
                </div>
            </details>

            <details class="faq-item">
                <summary class="faq-question">
                    Metode pembayaran apa saja yang diterima?
                    <i class="fas fa-chevron-down"></i>
                </summary>
                <div class="faq-answer">
                    <p>Kami menerima pembayaran tunai, transfer bank, QRIS, dan berbagai e-wallet popular seperti OVO, GoPay, dan DANA.</p>
                </div>
            </details>

            <details class="faq-item">
                <summary class="faq-question">
                    Apakah bisa melakukan custom order?
                    <i class="fas fa-chevron-down"></i>
                </summary>
                <div class="faq-answer">
                    <p>Ya, kami menerima pesanan khusus sesuai keinginan Anda. Silakan hubungi kami minimal 3 hari sebelum tanggal pengiriman yang diinginkan.</p>
                </div>
            </details>

            <details class="faq-item">
                <summary class="faq-question">
                    Bagaimana cara merawat bunga artificial?
                    <i class="fas fa-chevron-down"></i>
                </summary>
                <div class="faq-answer">
                    <p>Bersihkan secara berkala dengan lap kering atau kuas lembut. Hindari terkena air dan sinar matahari langsung. Simpan di tempat yang sejuk dan kering.</p>
                </div>
            </details>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const heroSection = document.querySelector('.hero');

        if (!heroSection) {
            console.error('Element .hero tidak ditemukan!');
            return;
        }

        const backgroundImages = [
            '<?= base_url('assets/images/bg-buket2.jpg') ?>',
            '<?= base_url('assets/images/bg-buket3.jpg') ?>',
            '<?= base_url('assets/images/bg-buket4.jpg') ?>'
        ];

        let currentIndex = 0;

        function changeBackground() {
            console.log('Current Index:', currentIndex);
            console.log('Changing Background to:', backgroundImages[currentIndex]);

            currentIndex = (currentIndex + 1) % backgroundImages.length;
            heroSection.style.backgroundImage = `linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('${backgroundImages[currentIndex]}')`;

            console.log('New Background Image:', heroSection.style.backgroundImage);
        }

        setInterval(changeBackground, 5000);
        heroSection.style.backgroundImage = `linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('${backgroundImages[0]}')`;
    });
</script>

<?= $this->endSection() ?>