<?php require 'utils.php'; require 'db.php'; site_header('Register'); if($_SERVER['REQUEST_METHOD']==='POST'){ $db=get_db(); $sql="INSERT INTO users(username,password) VALUES ('{$_POST['username']}', '{$_POST['password']}')"; try { $db->exec($sql); echo "<section class='card'><h2>Account ready</h2><p class='muted'>You can sign in right away.</p><div class='form-actions'><a class='btn primary' href='login.php'>Proceed to login</a></div></section>"; site_footer(); exit; } catch(Exception $e){ echo "<section class='card'><div class='alert'>Error: ".htmlspecialchars($e->getMessage())."</div></section>"; site_footer(); exit; }} ?>

<section class="page-header">
  <h1 class="page-title">Join the Console</h1>
  <p class="page-subtitle">Provision a ground-crew account and see how weak onboarding can cascade into broader compromise.</p>
</section>

<section class="card form-card">
  <div class="inline-actions" style="justify-content: space-between; align-items: center;">
    <h2>Create Account</h2>
    <span class="pill">Module 06</span>
  </div>
  <form method="POST" class="form-stack">
    <label class="input-group">
      <span>Username</span>
      <input name="username" autocomplete="username">
    </label>
    <label class="input-group">
      <span>Password</span>
      <input name="password" type="password" autocomplete="new-password">
    </label>
    <div class="form-actions">
      <button type="submit" class="primary">Register</button>
      <a class="btn link" href="login.php">Back to login</a>
    </div>
  </form>
</section>

<?php site_footer(); ?>
