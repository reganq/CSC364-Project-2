<?php
session_start();
function current_user() { return $_SESSION['user'] ?? null; }
function require_login() { if (!current_user()) { header('Location: login.php'); exit; } }
function site_header($title='VulnApp') { ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?> · VulnApp</title>
  <style>
    :root {
      --bg-gradient: linear-gradient(160deg, #0f172a 0%, #1e293b 50%, #312e81 100%);
      --surface: #ffffff;
      --surface-soft: rgba(255, 255, 255, 0.84);
      --accent: #6366f1;
      --accent-strong: #4f46e5;
      --danger: #ef4444;
      --muted: #64748b;
      --border: rgba(15, 23, 42, 0.08);
      --text: #0f172a;
      --text-light: #e2e8f0;
      font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
    }

    * { box-sizing: border-box; }

    body {
      margin: 0;
      min-height: 100vh;
      color: var(--text);
      background: var(--bg-gradient);
      background-attachment: fixed;
      display: flex;
      flex-direction: column;
    }

    a { color: inherit; text-decoration: none; }
    a:hover { text-decoration: underline; }

    .app-shell {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .app-header {
      backdrop-filter: blur(14px);
      background: rgba(15, 23, 42, 0.76);
      color: var(--text-light);
      padding: 18px clamp(18px, 6vw, 48px);
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 24px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
      box-shadow: 0 18px 32px rgba(15, 23, 42, 0.4);
      position: sticky;
      top: 0;
      z-index: 10;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 1.1rem;
      font-weight: 700;
      letter-spacing: 0.04em;
      text-transform: uppercase;
    }

    .brand-mark {
      width: 36px;
      height: 36px;
      border-radius: 11px;
      background: rgba(255, 255, 255, 0.16);
      display: grid;
      place-items: center;
      font-size: 1.25rem;
      font-weight: 600;
      letter-spacing: 0.08em;
    }

    .app-nav {
      display: flex;
      align-items: center;
      gap: clamp(8px, 2vw, 16px);
      flex-wrap: wrap;
      justify-content: flex-end;
    }

    .nav-link {
      padding: 8px 14px;
      border-radius: 999px;
      background: rgba(255, 255, 255, 0.12);
      color: var(--text-light);
      font-size: 0.9rem;
      font-weight: 600;
      transition: all 0.2s ease;
    }

    .nav-link:hover {
      background: rgba(255, 255, 255, 0.2);
      text-decoration: none;
    }

    .nav-link.primary {
      background: var(--accent);
      color: #fff;
      box-shadow: 0 10px 24px rgba(99, 102, 241, 0.35);
    }

    .nav-link.primary:hover {
      background: var(--accent-strong);
    }

    .user-chip {
      padding: 8px 14px;
      background: rgba(255, 255, 255, 0.16);
      border-radius: 999px;
      font-weight: 600;
      color: var(--text-light);
    }

    .main {
      flex: 1;
      width: min(1080px, 100%);
      margin: clamp(32px, 6vw, 72px) auto;
      padding: 0 clamp(18px, 4vw, 32px) clamp(64px, 8vw, 96px);
      display: flex;
      flex-direction: column;
      gap: clamp(18px, 3vw, 28px);
    }

    .page-header {
      color: var(--text-light);
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .page-title {
      margin: 0;
      font-size: clamp(2rem, 4vw, 2.7rem);
      font-weight: 700;
      letter-spacing: -0.02em;
    }

    .page-subtitle {
      margin: 0;
      font-size: 1rem;
      color: rgba(226, 232, 240, 0.82);
      max-width: 560px;
      line-height: 1.5;
    }

    .card {
      background: var(--surface);
      border-radius: 18px;
      padding: clamp(22px, 3vw, 32px);
      box-shadow: 0 22px 45px rgba(15, 23, 42, 0.18);
      border: 1px solid var(--border);
    }

    .card h2 {
      margin-top: 0;
      margin-bottom: 12px;
      font-size: clamp(1.35rem, 3vw, 1.7rem);
      letter-spacing: -0.01em;
    }

    .card small {
      color: var(--muted);
      font-weight: 600;
    }

    .card p { color: var(--muted); line-height: 1.6; }

    .message-list {
      display: flex;
      flex-direction: column;
      gap: 14px;
      margin-top: 18px;
    }

    .message {
      padding: 16px 18px;
      background: rgba(99, 102, 241, 0.06);
      border: 1px solid rgba(99, 102, 241, 0.18);
      border-radius: 14px;
      line-height: 1.55;
      color: #1e1b4b;
      font-size: 0.98rem;
    }

    .user-tag {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(59, 130, 246, 0.14);
      color: #1d4ed8;
      padding: 4px 10px;
      border-radius: 999px;
      font-size: 0.78rem;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      font-weight: 700;
      margin-right: 8px;
    }

    .form-card {
      display: flex;
      flex-direction: column;
      gap: clamp(18px, 3vw, 26px);
    }

    .form-stack {
      display: flex;
      flex-direction: column;
      gap: clamp(16px, 2vw, 22px);
    }

    .input-group { display: flex; flex-direction: column; gap: 6px; }

    label span, .input-label {
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--muted);
    }

    input[type=text], input[type=password], textarea {
      width: 100%;
      border-radius: 12px;
      border: 1px solid rgba(148, 163, 184, 0.6);
      padding: 12px 14px;
      font-size: 1rem;
      transition: border 0.2s ease, box-shadow 0.2s ease;
      font-family: inherit;
      color: var(--text);
      background: rgba(255, 255, 255, 0.94);
    }

    textarea { resize: vertical; min-height: 120px; }

    input[type=text]:focus, input[type=password]:focus, textarea:focus {
      outline: none;
      border-color: var(--accent);
      box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
    }

    .form-actions {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      align-items: center;
    }

    button, .btn {
      border: none;
      cursor: pointer;
      border-radius: 999px;
      padding: 10px 20px;
      font-weight: 600;
      font-size: 0.95rem;
      transition: transform 0.15s ease, box-shadow 0.2s ease;
    }

    button:hover, .btn:hover { transform: translateY(-1px); }

    button.primary, .btn.primary {
      background: var(--accent);
      color: #fff;
      box-shadow: 0 12px 24px rgba(99, 102, 241, 0.32);
    }

    button.primary:hover, .btn.primary:hover { background: var(--accent-strong); }

    .btn.link { background: transparent; color: var(--accent-strong); padding: 0; }

    .alert {
      padding: 14px 16px;
      border-radius: 12px;
      font-weight: 600;
      background: rgba(239, 68, 68, 0.1);
      color: #b91c1c;
      border: 1px solid rgba(239, 68, 68, 0.18);
    }

    pre {
      background: #0f172a;
      color: #a5f3fc;
      padding: 18px;
      border-radius: 14px;
      overflow: auto;
      border: 1px solid rgba(148, 163, 184, 0.18);
      font-size: 0.95rem;
    }

    footer {
      padding: 28px;
      text-align: center;
      color: rgba(226, 232, 240, 0.68);
      font-size: 0.85rem;
      letter-spacing: 0.02em;
    }

    .stack {
      display: flex;
      flex-direction: column;
      gap: clamp(12px, 2vw, 18px);
    }

    .muted { color: var(--muted); }

    .pill {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 4px 12px;
      border-radius: 999px;
      font-size: 0.75rem;
      background: rgba(15, 23, 42, 0.08);
      color: #1e293b;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      font-weight: 700;
    }

    .inline-actions { display: flex; gap: 12px; align-items: center; }

    .back-link { color: var(--accent-strong); font-weight: 600; }

    @media (max-width: 720px) {
      .app-header { flex-direction: column; align-items: flex-start; }
      .app-nav { width: 100%; justify-content: flex-start; }
      .main { margin-top: 24px; }
    }
  </style>
</head>
<body>
  <div class="app-shell">
    <header class="app-header">
      <div class="brand">
        <span class="brand-mark">VA</span>
        <span>VulnApp Console</span>
      </div>
      <div class="app-nav">
        <?php if (current_user()): ?>
          <span class="user-chip">Hello, <strong><?= current_user()['username'] ?></strong></span>
          <a class="nav-link" href="index.php">Timeline</a>
          <a class="nav-link" href="message.php">Compose</a>
          <a class="nav-link" href="search.php">Directory</a>
          <a class="nav-link" href="archive.php">Archive</a>
          <a class="nav-link" href="ping.php">Diagnostics</a>
          <a class="nav-link primary" href="logout.php">Logout</a>
        <?php else: ?>
          <a class="nav-link" href="index.php">Home</a>
          <a class="nav-link" href="register.php">Register</a>
          <a class="nav-link primary" href="login.php">Login</a>
        <?php endif; ?>
      </div>
    </header>
    <main class="main">
<?php }
function site_footer() { ?>
    </main>
    <footer>VulnApp training playground – intentionally insecure. Polish the defenses, not the flaws.</footer>
  </div>
</body>
</html>
<?php } ?>
