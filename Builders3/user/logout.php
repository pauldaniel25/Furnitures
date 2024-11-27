<?php
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to login page or homepage
header('Location: index.php'); // or index.php
exit;
?>

<li class="logout">
  <a href="#" onclick="confirmLogout()">
    <i class="fa-solid fa-right-from-bracket"></i>
  </a>
</li>

<script>
function confirmLogout() {
  if (confirm("Are you sure you want to log out?")) {
    window.location.href = 'logout.php';
  }
}
</script>