<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to LeafForce</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/images/logo_buket_1.webp') ?>">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nixie+One&display=swap');

        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Nixie One', sans-serif;
        }

        #splash {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #000;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            overflow: hidden;
        }

        #logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            opacity: 0;
            transform: scale(0.5);
            transition: all 1s ease-in-out;
        }

        #logo {
            max-width: 250px;
            max-height: 250px;
        }

        #brand-name {
            margin-top: 20px;
            font-size: 2.5em;
            font-weight: 700;
            color: #fff;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.8s ease-in-out 0.5s;
        }

        #home-content {
            display: none;
        }

        /* Tambahkan animasi fade out */
        .fade-out {
            opacity: 0 !important;
            transition: opacity 0.8s ease-in-out !important;
        }
    </style>
</head>

<body>
    <div id="splash">
        <div id="logo-container">
            <img src="<?= base_url('assets/images/logo_buket_1.webp') ?>" alt="LeafForce Logo" id="logo">
            <div id="brand-name">LeafForce</div>
        </div>
    </div>

    <div id="home-content">
        <!-- Konten home akan dimuat di sini -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoContainer = document.getElementById('logo-container');
            const brandName = document.getElementById('brand-name');
            const splash = document.getElementById('splash');
            const homeContent = document.getElementById('home-content');

            // Fungsi untuk memuat konten home
            function loadHomeContent() {
                fetch('<?= base_url('home/content') ?>')
                    .then(response => response.text())
                    .then(data => {
                        homeContent.innerHTML = data;
                        homeContent.style.display = 'block';

                        

                        // Inisialisasi background slider
                        const heroSection = document.querySelector('.hero');
                        if (heroSection) {
                            const backgroundImages = [
                                '<?= base_url('assets/images/bg-buket2.jpg') ?>',
                                '<?= base_url('assets/images/bg-buket3.jpg') ?>',
                                '<?= base_url('assets/images/bg-buket4.jpg') ?>'
                            ];

                            let currentIndex = 0;

                            function changeBackground() {
                                currentIndex = (currentIndex + 1) % backgroundImages.length;
                                heroSection.style.backgroundImage = `linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('${backgroundImages[currentIndex]}')`;
                            }

                            setInterval(changeBackground, 5000);
                            heroSection.style.backgroundImage = `linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('${backgroundImages[0]}')`;
                        }
                    })
                    .catch(error => {
                        console.error('Error loading home content:', error);
                        homeContent.innerHTML = '<p>Error loading content. Please refresh the page.</p>';
                        homeContent.style.display = 'block';
                    });
            }

            

            // Fungsi untuk menampilkan animasi landing
            function showLandingAnimation() {
                setTimeout(() => {
                    logoContainer.style.opacity = '1';
                    logoContainer.style.transform = 'scale(1)';

                    setTimeout(() => {
                        brandName.style.opacity = '1';
                        brandName.style.transform = 'translateY(0)';
                    }, 500);

                    setTimeout(() => {
                        splash.classList.add('fade-out');

                        setTimeout(() => {
                            splash.style.display = 'none';
                            document.body.style.overflow = 'auto';
                            loadHomeContent();

                            // Simpan status kunjungan dengan timestamp
                            const visitData = {
                                timestamp: Date.now(),
                                hasVisited: true
                            };
                            localStorage.setItem('leafforceVisitData', JSON.stringify(visitData));
                        }, 800);
                    }, 2500);
                }, 300);
            }

            // Cek apakah ini kunjungan pertama atau sudah lewat 24 jam
            const visitDataString = localStorage.getItem('leafforceVisitData');
            let shouldShowLanding = true;

            if (visitDataString) {
                const visitData = JSON.parse(visitDataString);
                const twentyFourHours = 24 * 60 * 60 * 1000; // 24 jam dalam milidetik
                const timeSinceLastVisit = Date.now() - visitData.timestamp;

                // Jika belum lewat 24 jam, skip landing
                if (timeSinceLastVisit < twentyFourHours) {
                    shouldShowLanding = false;
                }
            }

            if (shouldShowLanding) {
                // Tampilkan animasi landing
                showLandingAnimation();
            } else {
                // Langsung tampilkan konten
                splash.style.display = 'none';
                document.body.style.overflow = 'auto';
                loadHomeContent();
            }

            // Tambahkan error handling untuk gambar
            const logo = document.getElementById('logo');
            logo.onerror = function() {
                this.src = '<?= base_url('assets/images/default-logo.png') ?>'; // Ganti dengan gambar default
                console.error('Error loading logo image');
            };
        });

        // Fungsi untuk testing - hapus data kunjungan
        function resetLanding() {
            localStorage.removeItem('leafforceVisitData');
            location.reload();
        }

        
    </script>


</body>

</html>