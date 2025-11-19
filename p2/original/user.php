<?php require 'utils.php'; require 'db.php'; $id=$_GET['id']??'1'; $db=get_db(); $row=$db->query("SELECT * FROM users WHERE id = $id")->fetch(PDO::FETCH_ASSOC); if(!$row){ site_header('User Profile'); echo "<section class='card'><div class='alert'>No such user</div><div class='form-actions'><a class='btn link' href='index.php'>Return to feed</a></div></section>"; site_footer(); exit; } site_header('User Profile'); ?>

<section class="page-header">
  <h1 class="page-title">Crew Member</h1>
  <p class="page-subtitle">Every operator’s details are just an incrementing ID away. Observe the impact of missing access controls.</p>
</section>

<section class="card stack">
  <div class="inline-actions" style="justify-content: space-between; align-items: center;">
    <h2>User Profile</h2>
    <span class="pill">Module 07</span>
  </div>
  <div class="stack">
    <p><strong>ID:</strong> <?= $row['id'] ?></p>
    <p><strong>Username:</strong> <?= $row['username'] ?></p>
    <p><strong>Password:</strong> <?= $row['password'] ?></p>
  </div>
  <div class="form-actions">
    <a class="btn link" href="index.php">Back to feed</a>
  </div>
</section>

<?php site_footer(); ?>
