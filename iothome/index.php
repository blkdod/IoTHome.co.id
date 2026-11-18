<?php
session_start();

// Nomor WhatsApp admin IoTHome
$whatsappNumber = "6289630069368"; // GANTI dengan nomor WhatsApp kamu

$whatsappMessage = "Halo IoTHome, saya ingin bertanya tentang produk Smart Home.";

$whatsappLink = "https://wa.me/" . $whatsappNumber .
                "?text=" . urlencode($whatsappMessage);

$products = [
    [
        "id" => 1,
        "name" => "Smart Lighting",
        "category" => "Kontrol Lampu",
        "description" => "Kontrol lampu rumah melalui smartphone kapan saja.",
        "image" => "assets/img/smart-lamp.jpg",
        "icon" => "💡"
    ],
    [
        "id" => 2,
        "name" => "Smart AC",
        "category" => "Kontrol Suhu",
        "description" => "Atur suhu ruangan agar tetap nyaman.",
        "image" => "assets/img/smart-ac.jpg",
        "icon" => "❄️"
    ],
    [
        "id" => 3,
        "name" => "Smart CCTV",
        "category" => "Keamanan Rumah",
        "description" => "Pantau kondisi rumah melalui smartphone.",
        "image" => "assets/img/smart-cctv.jpg",
        "icon" => "📹"
    ],
    [
        "id" => 4,
        "name" => "Smart Automation",
        "category" => "Otomatisasi",
        "description" => "Atur rutinitas perangkat rumah secara otomatis.",
        "image" => "assets/img/smart-hub.jpg",
        "icon" => "🏠"
    ]
];

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";

    if ($action === "add") {
        $id = (int)($_POST["product_id"] ?? 0);

        foreach ($products as $product) {
            if ($product["id"] === $id) {
                $_SESSION["cart"][$id] =
                    ($_SESSION["cart"][$id] ?? 0) + 1;
                break;
            }
        }
    }

    if ($action === "remove") {
        $id = (int)($_POST["product_id"] ?? 0);
        unset($_SESSION["cart"][$id]);
    }

    header("Location: index.php#produk");
    exit;
}

$cartCount = array_sum($_SESSION["cart"]);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>IoTHome - Your Smart Living Partner</title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<header class="navbar">
    <a href="#" class="brand">
        <span class="brand-icon">⌂</span>
        <span>IoTHome</span>
    </a>

    <button class="menu-toggle" id="menuToggle"
            aria-label="Buka menu" aria-expanded="false">
        ☰
    </button>

    <nav class="nav-links" id="navLinks">
        <a href="#beranda">Beranda</a>
        <a href="#produk">Produk</a>
        <a href="#keunggulan">Keunggulan</a>
        <a href="#video">Video</a>
        <a href="#faq">FAQ</a>
        <a href="#kontak" class="nav-cta">Konsultasi</a>
    </nav>

    <a href="#keranjang" class="cart-link">
        🛒 Keranjang
        <span><?= $cartCount ?></span>
    </a>
</header>

<main>

<section class="hero" id="beranda">
    <div class="hero-content">
        <span class="eyebrow">YOUR SMART LIVING PARTNER</span>

        <h1>
            Rumah Pintar,<br>
            Hidup Lebih <span>Praktis.</span>
        </h1>

        <p>
            Kendalikan lampu, AC, dan keamanan rumah
            melalui smartphone. Nikmati rumah yang lebih
            aman, nyaman, dan praktis bersama IoTHome.
        </p>

        <div class="hero-buttons">
            <a href="#produk" class="btn btn-primary">
                Jelajahi Produk
            </a>
            <a href="#keunggulan" class="btn btn-outline">
                Pelajari Manfaat
            </a>
        </div>

        <div class="hero-note">
            🏠 Smart Home untuk kehidupan yang lebih baik
        </div>
    </div>

    <div class="hero-image">
        <img src="assets/img/rumah-pintar.jpg"
             alt="Ilustrasi rumah pintar IoTHome">
    </div>
</section>

<section class="problem section" id="solusi">
    <div class="section-heading">
        <span class="eyebrow">MASALAH SEHARI-HARI</span>
        <h2>Rumah Lebih Mudah Dikendalikan</h2>
        <p>
            Tidak perlu khawatir lagi ketika lupa mematikan
            lampu atau mengatur AC saat meninggalkan rumah.
        </p>
    </div>

    <div class="problem-grid">
        <article class="problem-card">
            <span>💡</span>
            <h3>Lampu Tertinggal Menyala?</h3>
            <p>Kontrol lampu rumah melalui smartphone.</p>
        </article>

        <article class="problem-card">
            <span>❄️</span>
            <h3>AC Belum Dimatikan?</h3>
            <p>Atur perangkat AC sesuai kebutuhan.</p>
        </article>

        <article class="problem-card">
            <span>📹</span>
            <h3>Ingin Memantau Rumah?</h3>
            <p>Pantau kondisi rumah melalui Smart CCTV.</p>
        </article>
    </div>
</section>

<section class="products section" id="produk">
    <div class="section-heading">
        <span class="eyebrow">PRODUK IOTHOME</span>
        <h2>Solusi Smart Home untuk Rumahmu</h2>
        <p>Pilih perangkat yang sesuai dengan kebutuhan rumah.</p>
    </div>

    <div class="product-grid">
        <?php foreach ($products as $product): ?>
        <article class="product-card">
            <div class="product-image">
                <img src="<?= htmlspecialchars($product["image"]) ?>"
                     alt="<?= htmlspecialchars($product["name"]) ?>">
            </div>

            <div class="product-info">
                <span class="category">
                    <?= htmlspecialchars($product["category"]) ?>
                </span>

                <h3><?= htmlspecialchars($product["name"]) ?></h3>

                <p><?= htmlspecialchars($product["description"]) ?></p>

                <div class="product-bottom">
                    <span class="price">Hubungi Kami</span>

                    <form method="POST">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="product_id"
                               value="<?= $product["id"] ?>">
                        <button type="submit" class="btn-add">
                            + Keranjang
                        </button>
                    </form>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="automation section">
    <div class="automation-content">
        <span class="eyebrow">SMART AUTOMATION</span>
        <h2>Rumah Bekerja Mengikuti Rutinitasmu</h2>
        <p>
            Atur rutinitas seperti mode tidur, lampu mati,
            AC pada suhu yang diinginkan, dan kunci pintu aktif
            sesuai perangkat yang digunakan.
        </p>
        <a href="#kontak" class="btn btn-primary">
            Konsultasikan Kebutuhan
        </a>
    </div>

    <div class="automation-panel">
        <h3>🌙 Mode Tidur</h3>
        <div class="automation-item">✓ Lampu: Mati</div>
        <div class="automation-item">✓ AC: 26°C</div>
        <div class="automation-item">✓ Kunci pintu: Aktif</div>
    </div>
</section>

<section class="benefits section" id="keunggulan">
    <div class="section-heading">
        <span class="eyebrow">MENGAPA IOTHOME?</span>
        <h2>Lebih dari Sekadar Rumah Pintar</h2>
    </div>

    <div class="benefit-grid">
        <div class="benefit-item">
            <span>🌱</span>
            <h3>Lebih Hemat Energi</h3>
            <p>Bantu mengelola penggunaan perangkat rumah.</p>
        </div>

        <div class="benefit-item">
            <span>🛡️</span>
            <h3>Lebih Aman</h3>
            <p>Pantau kondisi rumah melalui CCTV.</p>
        </div>

        <div class="benefit-item">
            <span>🛋️</span>
            <h3>Lebih Nyaman</h3>
            <p>Atur perangkat sesuai kebutuhan.</p>
        </div>

        <div class="benefit-item">
            <span>⏱️</span>
            <h3>Lebih Praktis</h3>
            <p>Kontrol perangkat melalui smartphone.</p>
        </div>
    </div>
</section>

<section class="video-section section" id="video">
    <div class="section-heading">
        <span class="eyebrow">VIDEO PROMOSI</span>
        <h2>Lihat Cara Kerja IoTHome</h2>
        <p>
            Kenali solusi Smart Home IoTHome melalui video promosi kami.
        </p>
    </div>

    <div class="video-wrapper">
        <video controls preload="metadata"
               poster="assets/img/video-poster.jpg">
            <source src="assets/video/promo-iothome.mp4"
                    type="video/mp4">
            Browser Anda tidak mendukung pemutaran video.
        </video>
    </div>
</section>

<section class="cart-section section" id="keranjang">
    <div class="section-heading">
        <span class="eyebrow">PILIHANMU</span>
        <h2>Keranjang Produk</h2>
    </div>

    <div class="cart-box">
        <?php if (empty($_SESSION["cart"])): ?>
            <p>Keranjang masih kosong. Silakan pilih produk IoTHome.</p>
        <?php else: ?>
            <?php foreach ($_SESSION["cart"] as $id => $qty): ?>
                <?php foreach ($products as $product): ?>
                    <?php if ($product["id"] == $id): ?>
                        <div class="cart-row">
                            <div>
                                <strong><?= htmlspecialchars($product["name"]) ?></strong>
                                <p>Jumlah: <?= (int)$qty ?></p>
                            </div>

                            <form method="POST">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="product_id"
                                       value="<?= (int)$id ?>">
                                <button class="remove-btn" type="submit">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>

            <p class="cart-disclaimer">
                Harga dan ketersediaan produk dikonfirmasi oleh tim IoTHome.
            </p>
        <?php endif; ?>
    </div>
</section>

<section class="faq section" id="faq">
    <div class="section-heading">
        <span class="eyebrow">FAQ</span>
        <h2>Pertanyaan yang Sering Diajukan</h2>
    </div>

    <div class="faq-list">
        <details>
            <summary>Apa itu IoTHome?</summary>
            <p>IoTHome merupakan konsep solusi Smart Home untuk membantu
               mengontrol perangkat rumah secara lebih praktis.</p>
        </details>

        <details>
            <summary>Perangkat apa saja yang tersedia?</summary>
            <p>Produk yang ditampilkan meliputi Smart Lighting,
               Smart AC, Smart CCTV, dan perangkat otomatisasi.</p>
        </details>

        <details>
            <summary>Apakah perangkat dapat dikontrol melalui smartphone?</summary>
            <p>Kontrol smartphone tersedia sesuai jenis perangkat,
               kompatibilitas, dan konfigurasi yang digunakan.</p>
        </details>

        <details>
            <summary>Bagaimana cara mengetahui harga produk?</summary>
            <p>Silakan konsultasikan kebutuhan untuk memperoleh
               informasi harga dan ketersediaan resmi.</p>
        </details>
    </div>
</section>

<section class="contact section" id="kontak">
    <div>
        <span class="eyebrow">MULAI RUMAH PINTARMU</span>
        <h2>Wujudkan Smart Home Impianmu</h2>
        <p>
            Rumah canggih, aman, dan praktis kini bukan lagi mimpi.
            Wujudkan Smart Home impianmu dengan mudah bersama IoTHome.
        </p>
    </div>

  <a href="<?= htmlspecialchars($whatsappLink, ENT_QUOTES, 'UTF-8') ?>"
   class="whatsapp-float"
   target="_blank"
   rel="noopener noreferrer"
   aria-label="Hubungi IoTHome melalui WhatsApp">

    <svg viewBox="0 0 100 100" aria-hidden="true">
        <path fill="currentColor"
        d="M16 .8A15.1 15.1 0 0 0 3.1 23.8L1 31l7.4-1.9A15.1 15.1 0 1 0 16 .8zm0 27.5a12.3 12.3 0 0 1-6.3-1.7l-.5-.3-4.4 1.1 1.2-4.3-.3-.5A12.4 12.4 0 1 1 16 28.3zm6.8-9.3c-.4-.2-2.1-1-2.4-1.1-.3-.1-.6-.2-.8.2-.2.4-.9 1.1-1.1 1.3-.2.2-.4.3-.8.1-.4-.2-1.5-.6-2.8-1.8-1-.9-1.7-2-1.9-2.4-.2-.4 0-.6.2-.8l.5-.6c.2-.2.2-.4.3-.6.1-.2 0-.5 0-.6-.1-.2-.8-1.9-1.1-2.6-.3-.7-.6-.6-.8-.6h-.7c-.2 0-.6.1-.9.5-.3.4-1.2 1.2-1.2 2.9s1.2 3.3 1.4 3.5c.2.2 2.4 3.7 5.8 5.1.8.3 1.4.5 1.9.6.8.3 1.6.2 2.2.1.7-.1 2.1-.9 2.4-1.7.3-.8.3-1.5.2-1.7-.1-.1-.3-.2-.7-.4z"/>
    </svg>

    <span>Chat WhatsApp</span>
</a>
    <small>Ganti alamat email contoh dengan kontak resmi sebelum website dipublikasikan.</small>
</section>

</main>

<footer class="footer">
    <a href="#" class="brand">
        <span class="brand-icon">⌂</span>
        <span>IoTHome</span>
    </a>

    <p>Your Smart Living Partner</p>
    <p>Rumah pintar untuk hidup yang lebih baik.</p>
    <small>© <?= date("Y") ?> IoTHome. All rights reserved.</small>
</footer>
<!-- Tombol WhatsApp IoTHome -->
<a href="<?= htmlspecialchars($whatsappLink, ENT_QUOTES, 'UTF-8') ?>"
   class="whatsapp-float"
   target="_blank"
   rel="noopener noreferrer"
   aria-label="Hubungi IoTHome melalui WhatsApp">

    <svg viewBox="0 0 350 350" aria-hidden="true">
        <path fill="currentColor"
        d="M16 .8A15.1 15.1 0 0 0 3.1 23.8L1 31l7.4-1.9A15.1 15.1 0 1 0 16 .8zm0 27.5a12.3 12.3 0 0 1-6.3-1.7l-.5-.3-4.4 1.1 1.2-4.3-.3-.5A12.4 12.4 0 1 1 16 28.3zm6.8-9.3c-.4-.2-2.1-1-2.4-1.1-.3-.1-.6-.2-.8.2-.2.4-.9 1.1-1.1 1.3-.2.2-.4.3-.8.1-.4-.2-1.5-.6-2.8-1.8-1-.9-1.7-2-1.9-2.4-.2-.4 0-.6.2-.8l.5-.6c.2-.2.2-.4.3-.6.1-.2 0-.5 0-.6-.1-.2-.8-1.9-1.1-2.6-.3-.7-.6-.6-.8-.6h-.7c-.2 0-.6.1-.9.5-.3.4-1.2 1.2-1.2 2.9s1.2 3.3 1.4 3.5c.2.2 2.4 3.7 5.8 5.1.8.3 1.4.5 1.9.6.8.3 1.6.2 2.2.1.7-.1 2.1-.9 2.4-1.7.3-.8.3-1.5.2-1.7-.1-.1-.3-.2-.7-.4z"/>
    </svg>

    <span>Chat WhatsApp</span>
</a>
<script src="assets/js/script.js"></script>


</body>
</html>
