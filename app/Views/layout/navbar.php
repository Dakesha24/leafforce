<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a href="<?= base_url('/') ?>" class="navbar-brand">
      <img src="<?= base_url('assets/images/icon-leafforce.png') ?>" alt="" height="38">
    </a>

    <!-- Gunakan checkbox untuk toggle menu mobile -->
    <input type="checkbox" id="nav-toggle" class="nav-toggle">
    <label for="nav-toggle" class="nav-toggle-label">
      <span></span>
      <span></span>
      <span></span>
    </label>

    <div class="nav-menu">
      <ul class="nav-list">
        <li><a href="<?= base_url('/#home') ?>" class="nav-link">Home</a></li>
        <li><a href="<?= base_url('/#products') ?>" class="nav-link">Produk</a></li>
        <li><a href="<?= base_url('/#faq') ?>" class="nav-link">FAQ</a></li>

        <li>
          <a href="https://wa.me/6289530573112" class="btn-wa">
            <i class="fab fa-whatsapp me-2"></i>Request Via WhatsApp
          </a>
        </li>
      </ul>
    </div>
    <div class="blur-backdrop"></div>
  </div>
</nav>

<style>
  .navbar {
    background: linear-gradient(120deg, rgba(255, 255, 255, 0.95), rgba(248, 249, 250, 0.95));
    padding: 8px 0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  }

  .blur-backdrop {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    z-index: 1;
    pointer-events: auto;
  }

  #nav-toggle:checked~.blur-backdrop {
    display: block;
  }

  .navbar-brand {
    z-index: 2;
  }

  .nav-toggle {
    display: none;
  }

  .nav-toggle-label {
    display: none;
  }

  .nav-list {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    align-items: center;
  }

  .nav-link {
    color: #333;
    text-decoration: none;
    padding: 8px 16px;
    transition: color 0.3s;
    font-weight: 500;
    position: relative;
  }

  .nav-link:hover {
    color: #3498db;
  }

  .nav-link::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: 0;
    left: 50%;
    background-color: #3498db;
    transition: all 0.3s ease;
    transform: translateX(-50%);
  }

  .nav-link:hover::after {
    width: calc(100% - 32px);
  }

  .btn-wa {
    background: linear-gradient(45deg, #25D366, #128C7E);
    color: white;
    text-decoration: none;
    padding: 8px 20px;
    border-radius: 25px;
    margin-left: 8px;
    transition: all 0.3s;
    display: inline-block;
  }



  .btn-wa:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.2);
    color: white;
  }

  @media (max-width: 991px) {
    .nav-toggle-label {
      display: block;
      cursor: pointer;
      padding: 10px;
      position: fixed;
      right: 15px;
      top: 15px;
      z-index: 3;
      background: transparent;
    }


    .nav-toggle-label span {
      display: block;
      width: 25px;
      height: 2px;
      background: #333;
      margin: 5px 0;
      transition: 0.4s;
    }

    .nav-menu {
      position: fixed;
      top: 0;
      right: -100%;
      background: white;
      height: 100vh;
      width: 80%;
      max-width: 300px;
      padding: 80px 20px 20px;
      transition: 0.4s;
      box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
      z-index: 2;
    }

    .nav-list {
      flex-direction: column;
      align-items: flex-start;
    }

    .nav-list li {
      width: 100%;
      margin: 8px 0;
    }

    .btn-wa {
      margin: 10px 0;
      width: 100%;
      text-align: center;
    }

    /* Toggle menu ketika checkbox dicentang */
    #nav-toggle:checked~.nav-menu {
      right: 0;
    }

    #nav-toggle:checked~.nav-toggle-label span:nth-child(1) {
      transform: rotate(45deg) translate(5px, 5px);
    }

    #nav-toggle:checked~.nav-toggle-label span:nth-child(2) {
      opacity: 0;
    }

    #nav-toggle:checked~.nav-toggle-label span:nth-child(3) {
      transform: rotate(-45deg) translate(7px, -7px);
    }
  }
</style>