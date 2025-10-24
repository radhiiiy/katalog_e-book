<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - askala media</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
        }
        .sidebar .nav-link {
            color: #fff;
            padding: 15px 20px;
        }
        .sidebar .nav-link:hover {
            background-color: #495057;
            color: #fff;
        }
        .sidebar .nav-link.active {
            background-color: #007bff;
            color: #fff;
        }
        .main-content {
            margin-left: 0;
            padding: 20px;
        }
        @media (min-width: 768px) {
            .main-content {
                margin-left: 250px;
            }
        }
        .card-stats {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
        }
        .card-stats .card-body {
            padding: 2rem;
        }
        .sidebar-brand {
            padding: 20px;
            text-align: center;
            background-color: #212529;
            color: #fff;
            font-weight: bold;
            font-size: 1.2em;
        }
    </style>
</head>  
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar position-fixed d-none d-md-block" style="width: 250px;">
            <div class="sidebar-brand">
                <i class="fas fa-book"></i> Askala Media
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= ($page == 'dashboard') ? 'active' : '' ?>" href="?page=dashboard">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($page == 'genre') ? 'active' : '' ?>" href="?page=form_genre">
                        <i class="fas fa-tags me-2"></i> Kelola Genre
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($page == 'buku') ? 'active' : '' ?>" href="?page=form_buku">
                        <i class="fas fa-book me-2"></i> Kelola Buku
                    </a>
                </li>
                <li class="nav-item mt-4">
                    <a class="nav-link" href="../../index.php" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i> Lihat Website
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=logout">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Mobile menu button -->
        <button class="btn btn-primary d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Mobile sidebar -->
        <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="mobileSidebar">
            <div class="offcanvas-header bg-dark text-white">
                <h5 class="offcanvas-title">Aksara Jenggala</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body bg-dark">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="?page=dashboard">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="?page=form_kategori">
                            <i class="fas fa-tags me-2"></i> Kelola Genre
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="?page=buku">
                            <i class="fas fa-book me-2"></i> Kelola Buku
                        </a>
                    </li>
                    <li class="nav-item mt-4">
                        <a class="nav-link text-white" href="index.php" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i> Lihat Website
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="admin.php?page=logout">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <main class="main-content flex-fill">
            <!-- Top navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
                <div class="container-fluid">
                    <h4 class="mb-0">Admin Panel</h4>
                    <div class="navbar-nav ms-auto">
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> <?php
                                    echo $_SESSION['admin_username'] ?? 'Admin'
                                 ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="?page=logout">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <?php include "../../route/admin.php"; ?>

<!-- admin/layout/footer.php -->
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            });
        }, 5000);

        // Confirm delete
        function confirmDelete(message = 'Apakah Anda yakin ingin menghapus data ini?') {
            return confirm(message);
        }
    </script>
</body>
</html>
        
        
<!--        


  

	<script src="js/jquery-1.11.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
		crossorigin="anonymous"></script>
	<script src="js/plugins.js"></script>
	<script src="js/script.js"></script>

</body>

</html> -->