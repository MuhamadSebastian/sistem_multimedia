<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= base_url('ACT2/index.css') ?>">
  <title>Gacha Buah</title>
</head>
<body>

  <div class="container">

    <div class="profile-inside">
      <img src="<?= base_url('images/yamada.jpg') ?>" alt="Foto Profil" class="profile-image-inside">
      <span class="profile-name-inside">Muhamad Sebastian Nugraha - 50421881</span>
    </div>

    <h1>🎰 Gacha Buah</h1>
    <div class="saldo">Coin: <span id="saldo">0</span> 🟡</div>

    <div class="topup-container">
      <input type="number" id="topupAmount" placeholder="Jumlah 🟡" min="1">
      <button id="topupBtn">Top Up 💰</button>
    </div>

    <button id="spinBtn">Spin (100 🟡)</button>

    <div class="buah-wrapper" id="buahWrapper">
      <div class="buah">?</div>
      <div class="buah">?</div>
      <div class="buah">?</div>
      <div class="buah">?</div>
    </div>

    <div class="result" id="result"></div>

  </div>

  <div id="popupVideo" class="popup-overlay" style="display:none;">
    <div class="popup-content">
      <video id="winVideo" autoplay muted>
        <source src="<?= base_url('video/vwin.mp4') ?>" type="video/mp4">
        Browser Anda tidak mendukung video.
      </video>
    </div>
  </div>


  <audio id="winSound">
    <source src="<?= base_url('audio/awin.mp3') ?>" type="audio/mpeg">
    Browser Anda tidak mendukung tag audio.
  </audio>

  <audio id="bgMusic" autoplay loop>
    <source src="<?= base_url('audio/dumb-ways-to-day-149817.mp3') ?>" type="audio/mpeg">
    Browser Anda tidak mendukung tag audio.
  </audio>

  <!-- Tombol kontrol backsound -->
  <button id="musicToggle" class="music-toggle" title="Toggle Music">
  🔇
  </button>





  <script>
    // Ambil elemen-elemen dari DOM
    const saldoElem = document.getElementById("saldo");
    const resultElem = document.getElementById("result");
    const buahWrapper = document.getElementById("buahWrapper");
    const spinBtn = document.getElementById("spinBtn");
    const topupBtn = document.getElementById("topupBtn");
    const topupAmount = document.getElementById("topupAmount");
    const winSound = document.getElementById("winSound");
    const popup = document.getElementById("popupVideo");
    const video = document.getElementById("winVideo");
    const bgMusic = document.getElementById("bgMusic");
    const musicToggle = document.getElementById("musicToggle");

    // Status awal
    let isMuted = true;
    bgMusic.muted = true;

    // Toggle saat tombol diklik
    musicToggle.addEventListener("click", () => {
    isMuted = !isMuted;
    bgMusic.muted = isMuted;
    musicToggle.textContent = isMuted ? "🔇" : "🔊";
    if (bgMusic.paused && !isMuted) {
      bgMusic.play();
    }
    });

    // Daftar buah untuk Gacha
    const buahList = ["🍎", "🍌", "🍇", "🍉", "🍍"];

    // Fungsi untuk mengupdate saldo di UI
    function updateSaldoUI() {
      saldoElem.textContent = localStorage.getItem("saldo");
    }

    // Fungsi untuk inisialisasi saldo jika belum ada
    function initSaldo() {
      if (localStorage.getItem("saldo") === null) {
        localStorage.setItem("saldo", "10000");
      }
      updateSaldoUI();
    }

    // Fungsi untuk memproses spin gacha
    function spinGacha() {
      let saldo = parseInt(localStorage.getItem("saldo"));
      if (saldo < 100) {
        resultElem.textContent = "Coin tidak cukup!";
        return;
      }

      saldo -= 100;
      localStorage.setItem("saldo", saldo);
      updateSaldoUI();

      // Ambil 4 buah secara acak
      let hasil = [];
      for (let i = 0; i < 4; i++) {
        const buah = buahList[Math.floor(Math.random() * buahList.length)];
        hasil.push(buah);
      }

      // Tampilkan hasil di UI
      const buahDivs = buahWrapper.querySelectorAll(".buah");
      hasil.forEach((buah, index) => {
        buahDivs[index].textContent = buah;
      });

      // Cek kemenangan
      if (hasil.every(b => b === hasil[0])) {
        resultElem.textContent = "🎉 Selamat! Kamu menang 10000 🟡!";
        saldo += 10000;
        localStorage.setItem("saldo", saldo);
        updateSaldoUI();
        // Pause backsound
        bgMusic.pause();

        // Putar suara jika menang
        winSound.currentTime = 0; // reset audio ke awal
        winSound.play();

        // Hentikan audio setelah 5 detik
        setTimeout(() => {
          winSound.pause();
        }, 5000);

        // Tampilkan popup video dan putar
        popup.style.display = "flex";
        video.currentTime = 0;
        video.play();

        // Menutup popup setelah 5 detik
        setTimeout(() => {
          popup.style.display = "none";
          video.pause();
          // Resume backsound
          bgMusic.play();
        }, 5000);
      } else {
        resultElem.textContent = "Coba lagi!";
      }
    }

    // Fungsi untuk melakukan top up saldo
    topupBtn.addEventListener("click", () => {
      const tambah = parseInt(topupAmount.value);
      if (isNaN(tambah) || tambah <= 0) {
        resultElem.textContent = "Masukkan jumlah yang valid untuk top up.";
        return;
      }

      let saldo = parseInt(localStorage.getItem("saldo") || "0");
      saldo += tambah;
      localStorage.setItem("saldo", saldo);
      updateSaldoUI();
      resultElem.textContent = `Saldo bertambah ${tambah} coins!`;
      topupAmount.value = ""; // Kosongkan input setelah top up
    });

    // Inisialisasi saldo saat halaman dimuat
    initSaldo();

    // Event listener untuk tombol spin
    spinBtn.addEventListener("click", spinGacha);
  </script>

</body>
</html>







<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= base_url('ACT2/index.css') ?>">
</head>
<body>
    <h1>Praktikum Sistem Multimedia</h1>
    <marquee class="marquee" behavior="scroll" direction="left">Muhamad Sebastian Nugraha - 50421881</marquee>
    <h2>Tema: Teks pada website</h2>

    <p>Dalam sistem multimedia, <span class="highlight">teks</span> berperan penting sebagai sarana penyampaian informasi
       . Teks bisa digunakan untuk judul, deskripsi, maupun penjelasan tambahan.</p>

       <p>Contoh teks dengan <span class="italic">gaya italic</span>, <strong>tebal</strong>, dan <u>garis bawah</u>.</p>
    
    <h2>Elemen Multimedia - Gambar</h2>
    
    <div class="image-card">
        <img src="<?= base_url('images/meme.jpg') ?>" alt="Sistem Multimedia" class="card-image">
        <div class="card-content">
            <h3>Contoh Gambar</h3>
        </div>
    </div>

    <section class="audiplay">
        <h2>Penerapan Audio Dalam Website</h2>

        <audio controls>
            <source src="audio/dumb-ways-to-day-149817.mp3" type="audio/mpeg">
            Browser Anda tidak mendukung tag audio.
        </audio>
    </section>

    <div class="banner">
    <iframe 
        width="100%" 
        height="400" 
        src="https://www.youtube.com/embed/Z54FdjHqPgM?autoplay=1&mute=1&loop=1&playlist=Z54FdjHqPgM&controls=0&modestbranding=1&showinfo=0&rel=0" 
        title="YouTube video player" 
        frameborder="0" 
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
        allowfullscreen 
        class="banner-image">
    </iframe>
    <div class="banner-overlay">
        <h3>Video</h3>
        <p>Video ditampilkan</p>
    </div>
</div>
</div>
    

</body>
</html> -->