<?php
require 'utils.php';
require_login();

site_header('Archive Browser');

$token = $_GET['token'] ?? '';
$decoded = null;
$transcript = null;
$status = null;

if ($token !== '') {
    $decoded = base64_decode(strtr($token, '-_', '+/'), true);
    if ($decoded === false) {
        $status = 'Could not interpret that reference token.';
    } else {
        $path = trim($decoded);
        $transcript = @file_get_contents($path);
        if ($transcript === false) {
            $transcript = @file_get_contents(__DIR__ . '/logs/' . $path);
        }
        if ($transcript === false) {
            $status = 'No archive entry matched that reference.';
        }
    }
}
?>

<section class="page-header">
  <h1 class="page-title">Archive Browser</h1>
  <p class="page-subtitle">Operations staff stash telemetry dumps under opaque reference tokens. Supply one to retrieve a historical snapshot.</p>
</section>

<section class="card form-card">
  <div class="inline-actions" style="justify-content: space-between; align-items: center;">
    <h2>Retrieve snapshot</h2>
    <span class="pill">Module 08</span>
  </div>
  <form class="form-stack" method="GET">
    <label class="input-group">
      <span>Reference token</span>
      <input name="token" value="<?= htmlspecialchars($token ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="base64-encoded reference">
    </label>
    <div class="form-actions">
      <button type="submit" class="primary">Open archive</button>
      <a class="btn link" href="archive.php">Clear</a>
    </div>
  </form>
  <?php if ($status): ?>
    <div class="alert" style="margin-top:12px;"><?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8') ?></div>
  <?php endif; ?>
  <?php if ($transcript !== null && $transcript !== false): ?>
    <div class="stack" style="margin-top:18px;">
      <span class="input-label">Transcript preview</span>
      <pre><?= $transcript ?></pre>
    </div>
  <?php endif; ?>
</section>

<?php site_footer(); ?>
