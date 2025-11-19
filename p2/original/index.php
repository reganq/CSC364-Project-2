<?php require 'utils.php'; require 'db.php'; site_header('Mission Feed'); ?>

<section class="page-header">
  <h1 class="page-title">Mission Feed</h1>
  <p class="page-subtitle">Live traffic from the ground crew console. Watch how untrusted payloads cascade through the UI.</p>
</section>

<section class="card">
  <div class="inline-actions" style="justify-content: space-between; align-items: flex-start;">
    <div>
      <h2>Recent Messages</h2>
      <p class="muted" style="margin: 4px 0 0;">Ten latest posts broadcast to every station. Keep watching how the interface renders whatever arrives.</p>
    </div>
    <span class="pill">Module 01</span>
  </div>
  <div class="message-list">
    <?php
    $db = get_db();
    $res = $db->query("SELECT messages.id, content, username FROM messages JOIN users ON users.id = messages.user_id ORDER BY messages.id DESC LIMIT 10;");
    foreach ($res as $row) {
        echo "<div class='message'><span class='user-tag'>".$row['username']."</span> ".$row['content']."</div>"; // still intentionally unescaped
    }
    ?>
  </div>
</section>

<?php site_footer(); ?>
