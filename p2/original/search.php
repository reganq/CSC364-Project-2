<?php require 'utils.php'; require_login(); require 'db.php'; $q=$_GET['q']??''; site_header('Search Users'); ?>

<section class="page-header">
  <h1 class="page-title">Crew Directory</h1>
  <p class="page-subtitle">Probe the operator roster with flexible patterns— and notice how quickly untrusted text bounces straight back at you.</p>
</section>

<section class="card form-card">
  <div class="inline-actions" style="justify-content: space-between; align-items: center;">
    <h2>Search Users</h2>
    <span class="pill">Module 03</span>
  </div>
  <form class="form-stack">
    <label class="input-group">
      <span>Query</span>
      <input name="q" value="<?= $q ?>" placeholder="search username">
    </label>
    <div class="form-actions">
      <button type="submit" class="primary">Run search</button>
      <a class="btn link" href="index.php">Back to feed</a>
    </div>
  </form>
  <?php if($q!==''){ echo "<div class='stack' style='margin-top:18px;'><p class='muted'>Results for: $q</p>"; $db=get_db(); $sql="SELECT id, username FROM users WHERE username LIKE '%$q%'"; foreach($db->query($sql) as $row){ echo "<div><a class='btn link' href='user.php?id={$row['id']}'>".$row['username']."</a></div>"; } echo "</div>"; } ?>
</section>

<?php site_footer(); ?>
