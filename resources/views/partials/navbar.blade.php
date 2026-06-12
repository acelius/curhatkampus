<header class="header-bar font-poppins">
    <nav class="navbar">
        <a href="{{ route('login') }}" class="logo-container">
            <img src="{{ asset('images/logo.png') }}" alt="Logo CurhatKampus">
            <span class="logo-text"><b>Curhat</b>Kampus</span>
        </a>

        <div class="nav-right">
            <ul class="nav-links">
                <li>
                    <a
                        href="{{ route('login') }}"
                        data-nav="beranda"
                        class="{{ request()->routeIs('login') ? 'active' : '' }}"
                    >
                        Beranda
                    </a>
                </li>

                <li>
                    <a
                        href="{{ route('login') }}#cara-curhat"
                        data-nav="cara-curhat"
                    >
                        Cara Curhat
                    </a>
                </li>

                <li>
                    <a
                        href="{{ route('curhat.cek') }}"
                        data-nav="cek-curhatan"
                        class="{{ request()->routeIs('curhat.cek') ? 'active' : '' }}"
                    >
                        Cek Curhatan
                    </a>
                </li>
            </ul>

            @auth
                <form action="{{ route('logout') }}" method="POST" class="nav-logout-form">
                    @csrf
                    <button type="submit" class="btn-nav-kirim nav-logout-btn">
                        Logout
                    </button>
                </form>
            @else
                <a
                    href="{{ route('login') }}?login_required=1#login-card"
                    class="btn-nav-kirim"
                    data-require-login="true"
                >
                    <img src="{{ asset('images/pesawat.png') }}" alt="Icon Pesawat">
                    Kirim Curhatan
                </a>
            @endauth
        </div>
    </nav>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navLinks = document.querySelectorAll('.nav-links a');

        function clearActiveNav() {
            navLinks.forEach(function (link) {
                link.classList.remove('active');
            });
        }

        function setActiveNav() {
            const currentPath = window.location.pathname;
            const currentHash = window.location.hash;

            clearActiveNav();

            if (currentHash === '#cara-curhat') {
                const caraLink = document.querySelector('[data-nav="cara-curhat"]');
                if (caraLink) caraLink.classList.add('active');
                return;
            }

            if (currentPath.includes('/cek-curhatan')) {
                const cekLink = document.querySelector('[data-nav="cek-curhatan"]');
                if (cekLink) cekLink.classList.add('active');
                return;
            }

            const berandaLink = document.querySelector('[data-nav="beranda"]');
            if (berandaLink) berandaLink.classList.add('active');
        }

        setActiveNav();
        window.addEventListener('hashchange', setActiveNav);
    });
</script>