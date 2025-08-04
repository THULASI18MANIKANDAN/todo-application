<?php
require_once 'includes/session.php';

if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}

$page_title = "Welcome to TaskMaster";
include 'includes/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
            <h1 class="display-4 mb-4">
                <i class="fas fa-tasks text-primary"></i> TaskMaster
            </h1>
            <p class="lead mb-5">
                Organize your life with our powerful and intuitive to-do list application. 
                Stay productive, meet deadlines, and achieve your goals.
            </p>
            
            <div class="row mb-5">
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Secure & Private</h5>
                            <p class="card-text">Your tasks are stored securely. Only you can access your personal to-do lists.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="fas fa-bolt fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Easy to Use</h5>
                            <p class="card-text">Intuitive interface designed for productivity. Add, edit, and complete tasks with ease.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="fas fa-users fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Personal Dashboard</h5>
                            <p class="card-text">Get insights into your productivity with task statistics and progress tracking.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-grid gap-2 d-md-block">
                <a href="register.php" class="btn btn-primary btn-lg me-3">
                    <i class="fas fa-user-plus"></i> Get Started Free
                </a>
                <a href="login.php" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
