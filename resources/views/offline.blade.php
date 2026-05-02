<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>You're Offline - Fornoria Pizza</title>
    <meta name="theme-color" content="#C41E3A">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap');


        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #2C2C2C;
            --secondary: #CC7357;
            --accent: #C41E3A;
            --light: #FFF9F0;
            --title-border: #F5C842;
            --border: #BFBAB2;
            --success: #4A7C59;
            --font-heading: "Cinzel", serif;
            --font-body: "Raleway", sans-serif;
        }

        html, body {
            height: 100%;
            background: var(--primary);
            color: var(--light);
            font-family: var(--font-heading);
            font-weight: 300;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100dvh;
            padding: 2rem;
            text-align: center;
            overflow: hidden;
            position: relative;
        }

        /* ── Background texture ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 50% 0%,   rgba(196, 30, 58, 0.25) 0%, transparent 70%),
                radial-gradient(ellipse 50% 40% at 80% 100%, rgba(204, 115, 87, 0.15) 0%, transparent 70%);
            pointer-events: none;
        }

        /* ── Pizza SVG ── */
        .pizza-wrap {
            position: relative;
            width: 160px;
            height: 160px;
            margin-bottom: 2.5rem;
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0)    rotate(-2deg); }
            50%       { transform: translateY(-14px) rotate(2deg); }
        }

        .pizza-wrap svg { width: 100%; height: 100%; }

        /* Steam lines */
        .steam { opacity: 0; animation: steam 2.5s ease-in-out infinite; }
        .steam:nth-child(1) { animation-delay: 0s; }
        .steam:nth-child(2) { animation-delay: .4s; }
        .steam:nth-child(3) { animation-delay: .8s; }

        @keyframes steam {
            0%   { opacity: 0; transform: translateY(0)   scaleX(1); }
            40%  { opacity: .7; }
            100% { opacity: 0; transform: translateY(-28px) scaleX(1.4); }
        }

        /* ── Text ── */
        h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 8vw, 3.5rem);
            font-weight: 900;
            line-height: 1.1;
            letter-spacing: -.5px;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--light) 40%, var(--title-border));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .subtitle {
            font-size: 1.1rem;
            color: var(--border);
            max-width: 340px;
            line-height: 1.7;
            margin-bottom: 2.5rem;
            font-family: var(--font-body);
        }

        .subtitle strong { color: var(--light); font-weight: 400; }

        /* ── Retry button ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: .6rem;
            padding: .85rem 2.2rem;
            background: var(--accent);
            color: #fff;
            font-family: var(--font-body);
            font-size: .95rem;
            font-weight: 400;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background .2s, transform .15s;
            margin-bottom: 1.2rem;
        }
        .btn:hover  { background: #a01830; transform: translateY(-2px); }
        .btn:active { transform: translateY(0); }

        /* ── Available offline notice ── */
        .offline-notice {
            font-size: .8rem;
            letter-spacing: .5px;
            color: var(--border);
            text-transform: uppercase;
            margin-top: 3rem;
            font-family: var(--font-body);
        }
        .offline-notice span { color: var(--title-border); }

        /* ── Connection status dot ── */
        .status-dot {
            display: inline-block;
            width: 8px; height: 8px;
            border-radius: 50%;
            background: var(--accent);
            margin-right: 6px;
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50%       { opacity: .3; }
        }
        .status-dot.online { background: var(--success); animation: none; }

        /* ── Divider ── */
        .divider {
            width: 40px; height: 2px;
            background: var(--accent);
            margin: 1.5rem auto;
            opacity: .5;
        }
    </style>
</head>
<body>

    <!-- Pizza SVG with steam -->
    <div class="pizza-wrap" aria-hidden="true">
        <svg viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Steam -->
            <g transform="translate(58,0)">
                <path class="steam" d="M8 24 Q4 18 8 12 Q12 6 8 0" stroke="#e8d5b0" stroke-width="2.5" stroke-linecap="round" fill="none"/>
                <path class="steam" d="M20 24 Q16 16 20 10 Q24 4 20 0" stroke="#e8d5b0" stroke-width="2" stroke-linecap="round" fill="none" style="animation-delay:.4s"/>
                <path class="steam" d="M32 24 Q28 18 32 12 Q36 6 32 0" stroke="#e8d5b0" stroke-width="2.5" stroke-linecap="round" fill="none" style="animation-delay:.8s"/>
            </g>
            <!-- Pizza base (crust) -->
            <circle cx="80" cy="100" r="56" fill="#c0854a"/>
            <!-- Inner pizza -->
            <circle cx="80" cy="100" r="50" fill="#e8a44a"/>
            <!-- Sauce layer -->
            <circle cx="80" cy="100" r="44" fill="#C41E3A" opacity=".85"/>
            <!-- Cheese blobs -->
            <ellipse cx="74" cy="94"  rx="12" ry="9"  fill="#F5C842" opacity=".9"/>
            <ellipse cx="93" cy="106" rx="10" ry="8"  fill="#F5C842" opacity=".85"/>
            <ellipse cx="68" cy="112" rx="9"  ry="7"  fill="#F5C842" opacity=".88"/>
            <ellipse cx="88" cy="88"  rx="8"  ry="6"  fill="#F5C842" opacity=".9"/>
            <!-- Pepperoni -->
            <circle cx="78" cy="96"  r="7" fill="#8b1a1a"/>
            <circle cx="78" cy="96"  r="5" fill="#CC7357"/>
            <circle cx="94" cy="108" r="6" fill="#8b1a1a"/>
            <circle cx="94" cy="108" r="4" fill="#CC7357"/>
            <circle cx="66" cy="110" r="5" fill="#8b1a1a"/>
            <circle cx="66" cy="110" r="3.5" fill="#CC7357"/>
            <circle cx="88" cy="90"  r="5" fill="#8b1a1a"/>
            <circle cx="88" cy="90"  r="3.5" fill="#CC7357"/>
            <!-- Basil leaves -->
            <ellipse cx="82" cy="116" rx="5" ry="3" fill="#4A7C59" transform="rotate(-20 82 116)"/>
            <ellipse cx="70" cy="98"  rx="4" ry="2.5" fill="#4A7C59" transform="rotate(15 70 98)"/>
            <!-- Crust highlight -->
            <path d="M 32 105 A 50 50 0 0 1 130 105" stroke="#d4956a" stroke-width="3" fill="none" opacity=".4"/>
        </svg>
    </div>

    <h1>Oops!<br>No Connection</h1>
    <div class="divider"></div>
    <p class="subtitle">
        Looks like you've gone <strong>offline</strong>. Our kitchen is still hot —
        reconnect and your cart will be right where you left it.
    </p>

    <button class="btn" onclick="retryConnection()">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
        </svg>
        Try Again
    </button>

    <p id="status-line" class="offline-notice">
        <span class="status-dot" id="dot"></span>
        Status: <span id="status-text">Offline</span>
    </p>

    <p class="offline-notice" style="margin-top:.8rem">
        Some pages may be available <span>from cache</span>
    </p>

    <script>
        function retryConnection() {
            window.location.reload();
        }

        function updateStatus() {
            const dot  = document.getElementById('dot');
            const text = document.getElementById('status-text');
            if (navigator.onLine) {
                dot.classList.add('online');
                text.textContent = 'Back online – reloading…';
                setTimeout(() => window.location.replace('/'), 800);
            } else {
                dot.classList.remove('online');
                text.textContent = 'Offline';
            }
        }

        window.addEventListener('online',  updateStatus);
        window.addEventListener('offline', updateStatus);
        updateStatus();
    </script>
</body>
</html>
