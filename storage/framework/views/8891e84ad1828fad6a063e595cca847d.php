<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Employee Management System')); ?></title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">

    <?php echo $__env->yieldPushContent('head'); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <div id="app">
        <!-- Top Navigation -->
<nav class="navbar navbar-expand-lg" style="background-color: #87CEEB;">
    <div class="container-fluid">
        <a class="navbar-brand text-white fw-bold" href="<?php echo e(route('dashboard')); ?>">
            <i class="fas fa-users me-2"></i><?php echo e(config('app.name', 'Employee Management System')); ?>

        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-1"></i><?php echo e(Auth::user()->display_name ?? Auth::user()->username); ?>

                        <span class="badge bg-white text-dark ms-1"><?php echo e(ucfirst(Auth::user()->role)); ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?php echo e(route('profile.show')); ?>"><i class="fas fa-user me-2"></i>Profile</a></li>

                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>


        <div class="container-fluid">
            <div class="row align-items-start">
                <!-- Sidebar -->
<nav class="col-md-3 col-lg-2 d-md-block bg-white sidebar collapse border-end">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <!-- Dashboard -->
            <li class="nav-item mb-1">
                <a class="nav-link <?php echo e(request()->routeIs('*.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('dashboard')); ?>">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </li>
            <?php if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('hr')): ?>
                <li class="nav-item mb-1">
                    <a class="nav-link <?php echo e(request()->routeIs('employees.*') ? 'active' : ''); ?>" href="<?php echo e(route('employees.index')); ?>">
                        <i class="fas fa-users me-2"></i>Employees
                    </a>
                </li>
            <?php endif; ?>
            <?php if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('hr') || Auth::user()->hasRole('manager')): ?>
                <li class="nav-item mb-1">
                    <a class="nav-link <?php echo e(request()->routeIs('attendance.*') ? 'active' : ''); ?>" href="<?php echo e(route('attendance.index')); ?>">
                        <i class="fas fa-clock me-2"></i>Attendance
                    </a>
                </li>
            <?php endif; ?>


            <!-- Work Logs - Available for all users except system -->
            <?php if(!Auth::user()->hasRole('system')): ?>
                <li class="nav-item mb-1">
                    <a class="nav-link <?php echo e(request()->routeIs('worklogs.*') ? 'active' : ''); ?>" href="<?php echo e(route('worklogs.index')); ?>">
                        <i class="fas fa-tasks me-2"></i>Work Logs
                    </a>
                </li>
            <?php endif; ?>

            <?php if(!Auth::user()->hasRole('system')): ?>
                <li class="nav-item mb-1">
                    <a class="nav-link <?php echo e(request()->routeIs('dokumen.*') || request()->routeIs('management-document') ? 'active' : ''); ?>" href="<?php echo e(route('dokumen.index')); ?>">
                        <i class="fas fa-file-alt me-2"></i>Document Management
                    </a>
                </li>
            <?php endif; ?>


            <!--<?php if(!Auth::user()->hasRole('system')): ?>
                My Schedule for all users
                <li class="nav-item mb-1">
                    <a class="nav-link <?php echo e(request()->routeIs('job-batches.schedule') ? 'active' : ''); ?>" href="<?php echo e(route('job-batches.schedule')); ?>">
                        <i class="fas fa-calendar-check me-2"></i>My Schedule
                    </a>
                </li>
            <?php endif; ?>-->

            <!-- Job Batches Section -->
            <!--<?php if(Auth::user()->hasRole(['admin', 'hr', 'manager'])): ?>
                 Job Management for Admin/HR/Manager
                <li class="nav-item mb-1">
                    <a class="nav-link <?php echo e(request()->routeIs('job-batches.index') || request()->routeIs('job-batches.create') || request()->routeIs('job-batches.edit') || request()->routeIs('job-batches.show') ? 'active' : ''); ?>" href="<?php echo e(route('job-batches.index')); ?>">
                        <i class="fas fa-briefcase me-2"></i>Employee Jobs
                    </a>
                </li>
            <?php endif; ?>-->
            <li class="nav-item mb-1">
                <a class="nav-link <?php echo e(request()->routeIs('leave.*') ? 'active' : ''); ?>" href="<?php echo e(route('leave.index')); ?>">
                    <i class="fas fa-calendar-alt me-2"></i>
                    <?php if(Auth::user()->isEmployee()): ?>
                        My Leave Requests
                    <?php else: ?>
                        Leave Management
                    <?php endif; ?>
                </a>
            </li>

            <?php if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('hr') || Auth::user()->hasRole('manager')): ?>

                <li class="nav-item mb-1">
                    <a class="nav-link <?php echo e(request()->routeIs('reports.*') ? 'active' : ''); ?>" href="<?php echo e(route('reports.index')); ?>">
                        <i class="fas fa-chart-bar me-2"></i>Reports
                    </a>
                </li>
            <?php endif; ?>
            <?php if(Auth::user()->hasRole('admin')): ?>

            <?php endif; ?>
        </ul>
    </div>
</nav>


                <!-- Main content -->
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <?php echo $__env->yieldContent('content'); ?>
                </main>
            </div>
        </div>

        <!-- Logout Form -->
        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
            <?php echo csrf_field(); ?>
        </form>
    </div>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Additional Scripts -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Profile Photo Management -->
    <script src="<?php echo e(asset('js/profile-photo.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>

<style>
.sidebar {
    min-height: calc(100vh - 56px);
    background-color: #ffffff;
}

.sidebar .nav-link {
    color: #333;
    border-radius: 0.5rem;
    margin-bottom: 0.3rem;
    padding: 0.75rem 1rem;
    transition: all 0.2s ease-in-out;
    font-weight: 500;
}

.sidebar .nav-link:hover {
    background-color: #e0f7ff;
    color: #0d6efd;
}

.sidebar .nav-link.active {
    background-color: #87CEEB;
    color: white;
    font-weight: 600;
    box-shadow: inset 3px 0 0 #0d6efd;
}

.navbar-brand {
    font-weight: 700;
    font-size: 1.1rem;
}

@media (max-width: 767.98px) {
    .sidebar {
        min-height: auto;
    }
}
</style>

<style>
    body {
        margin: 0;
    }

    /* 1. Navbar fix di atas */
    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 56px;
        z-index: 1030;
        border-bottom: 1px solid #ccc;
    }

    /* 2. Sidebar fix di kiri */
    .sidebar {
        position: fixed;
        top: 56px; /* di bawah navbar */
        left: 0;
        width: 250px;
        height: calc(100vh - 56px);
        overflow-y: auto;
        z-index: 1020;
    }

    /* 3. Konten utama geser ke kanan dan ke bawah */
    main.col-md-9.ms-sm-auto.col-lg-10.px-md-4 {
        margin-left: 250px;
        padding-top: 70px; /* padding supaya tidak tertimpa navbar */
    }

    @media (max-width: 767.98px) {
        .sidebar {
            position: static;
            height: auto;
        }

        main.col-md-9.ms-sm-auto.col-lg-10.px-md-4 {
            margin-left: 0;
            padding-top: 70px;
        }
    }
</style>


<?php /**PATH D:\backoffice-fasya\resources\views/layouts/admin.blade.php ENDPATH**/ ?>