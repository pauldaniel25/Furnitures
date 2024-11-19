<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../vendor/bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendor//bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../vendor/datatable-2.1.8/datatables.min.css" >
<header>
  <div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg navbar-custom">
      <div class="container-fluid">
        <img src="images/LOGO.png" alt="Logo" class="logo">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <nav>
            <ul class="navbar-nav ms-auto">
              <li><a class="nav-link" href="Dashboard.php">Home</a></li>
              <li><a class="nav-link" href="product.php">Products</a></li>
              <li><a class="nav-link" href="#">Builders</a></li>
              <li class="nav-item">
                <a class="nav-link" href="addproduct.php"><i class="fa-solid fa-cart-shopping"></i><sup>1</sup></a>
              </li>
            </ul>
          </nav>
          <form class="Search d-flex" method="POST" role="search">
            <input class="Sbar form-control me-2" type="search" name="keyword" placeholder="Search" value="<?= htmlspecialchars($keyword) ?>" />
            <button class="bt btn btn-outline-success" type="submit">Search</button>
          </form>
        </div>
      </div>
    </nav>
  </div>
</header>