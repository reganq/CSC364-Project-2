<?php
require 'utils.php';
require_login();
site_header('Ping Tool');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = $_POST['host'] ?? '';

    // Block dangerous shell characters
    if (preg_match('/[&|><`$!]/', $host)) {
        $output = "Invalid characters detected.";
    } else {
        $output = shell_exec("ping -c 1 $host 2>&1");
    }
}
?>
<section class="page-header">
  <h1 class="page-title">Network Pulse</h1>
  <p class="page-subtitle">Send a single ICMP ping to any host and inspect the raw output streamed back into the console.</p>
</section>

<section class="card form-card">
  <div class="inline-actions" style="justify-content: space-between; align-items: center;">
    <h2>Ping Tool</h2>
    <span class="pill">Module 04</span>
  </div>
  <form method="POST" class="form-stack">
    <label class="input-group">
      <span>Hostname or IP</span>
      <input name="host" placeholder="127.0.0.1">
    </label>
    <div class="form-actions">
      <button type="submit" class="primary">Execute ping</button>
      <a class="btn link" href="index.php">Back</a>
    </div>
  </form>
  <pre><?= $output ?? '' ?></pre>
</section>

<?php site_footer(); ?>
