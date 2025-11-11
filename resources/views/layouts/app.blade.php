<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PundoHub</title>

  <!-- ✅ Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />

  <style>
    body {
      overflow-x: hidden;
      font-family: "Poppins", sans-serif;
    }

    #sidebar {
      width: 250px;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      background: #1f1f1f;
      color: white;
      transition: transform 0.3s ease-in-out;
      z-index: 1050;
    }

    #sidebar .nav-link {
      color: #adb5bd;
      font-weight: 500;
      border-radius: 8px;
      margin: 4px 0;
      transition: all 0.3s ease;
    }

    #sidebar .nav-link:hover,
    #sidebar .nav-link.active {
      background: #a1a0a0;
      color: #000;
    }

   body {
  overflow-x: hidden;
  font-family: "Poppins", sans-serif;
  background: url("{{ asset('images/background.jpg') }}") no-repeat center center fixed;
  background-size: cover;
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
}

#content {
  flex-grow: 1;
  margin-left: 250px;
  padding: 20px;
  min-height: 100vh;
  background: rgba(0, 0, 0, 0.5); /* optional overlay to improve text visibility */
  color: #fff;
  transition: margin-left 0.3s ease-in-out;
}


    .card {
      background-color: #d8d7d7;
      color: #333;
      border: none;
      border-radius: 12px;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      padding: 1rem;
    }

    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.25);
    }

    .logo-img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      object-fit: cover;
    }

    @media (max-width: 992px) {
      #sidebar {
        transform: translateX(-100%);
      }
      #sidebar.show {
        transform: translateX(0);
      }
      #content {
        margin-left: 0;
      }
    }

    #sidebarToggle {
      position: fixed;
      top: 15px;
      left: 15px;
      z-index: 1100;
    }

    #loadingSpinner {
      display: none;
      opacity: 0;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      z-index: 2000;
      justify-content: center;
      align-items: center;
      transition: opacity 0.3s ease;
      pointer-events: none;
    }

    #loadingSpinner.active {
      display: flex;
      opacity: 1;
      pointer-events: all;
    }

    .spinner-border {
      width: 3rem;
      height: 3rem;
    }

    /* ✅ Styled Logout Modal - Smaller */
    .modal-content {
      background: rgba(20, 20, 20, 0.95);
      color: #fff;
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 12px;
      backdrop-filter: blur(12px);
      box-shadow: 0 0 30px rgba(245, 244, 243, 0.3);
      animation: popIn 0.25s ease-out;
      max-width: 350px;
      margin: 0 auto;
    }

    @keyframes popIn {
      from {
        transform: scale(0.9);
        opacity: 0;
      }
      to {
        transform: scale(1);
        opacity: 1;
      }
    }

    .modal-header {
      border-bottom: 1px solid rgba(255, 255, 255, 0.15);
      padding: 1rem 1.5rem;
    }

    .modal-body {
      padding: 1.5rem;
      font-size: 0.95rem;
      text-align: center;
    }

    .modal-footer {
      border-top: 1px solid rgba(255, 255, 255, 0.15);
      padding: 1rem 1.5rem;
    }

    .btn-danger {
      background-color: white;
      border: none;
      color: black;
      font-weight: 600;
      transition: all 0.3s ease;
      padding: 0.5rem 1.5rem;
      position: relative;
    }

    .btn-danger:hover {
      background-color: white;
      transform: scale(1.05);
      color: black;
    }

    .btn-secondary {
      background-color: #3a3a3a;
      border: none;
      transition: all 0.3s ease;
      padding: 0.5rem 1.5rem;
    }

    .btn-secondary:hover {
      background-color: #555;
      transform: scale(1.05);
    }

    body.modal-open {
      overflow: hidden !important;
      padding-right: 0 !important;
    }

    /* Profile Picture Styles - Larger */
    .profile-picture {
      width: 55px;
      height: 55px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #0dcaf0;
      transition: all 0.3s ease;
    }

    .profile-picture:hover {
      transform: scale(1.15);
      box-shadow: 0 0 20px rgba(13, 202, 240, 0.6);
    }

    .profile-default {
      width: 55px;
      height: 55px;
      border-radius: 50%;
      background: #6c757d;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 3px solid #0dcaf0;
      transition: all 0.3s ease;
    }

    .profile-default:hover {
      transform: scale(1.15);
      box-shadow: 0 0 20px rgba(13, 202, 240, 0.6);
    }

    .profile-default i {
      font-size: 1.5rem;
    }

    .profile-dropdown-toggle {
      border: none;
      background: transparent;
      padding: 0;
    }

    .profile-dropdown-toggle::after {
      display: none;
    }

    .profile-dropdown {
      min-width: 220px;
      border-radius: 12px;
      background: rgba(25, 25, 25, 0.98);
      border: 1px solid rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(15px);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    .profile-dropdown .dropdown-item {
      color: #fff;
      transition: all 0.2s ease;
      border-radius: 6px;
      margin: 3px 8px;
      padding: 0.6rem 1rem;
    }

    .profile-dropdown .dropdown-item:hover {
      background: rgba(13, 202, 240, 0.15);
      color: #0dcaf0;
      transform: translateX(5px);
    }

    .profile-dropdown .logout-item:hover {
      background: rgba(220, 53, 69, 0.15);
      color: #dc3545;
    }

    .user-info {
      color: #fff;
      font-size: 1rem;
      font-weight: 600;
    }

    .user-role {
      color: #adb5bd;
      font-size: 0.85rem;
    }

    /* Top Right Profile Container */
    .top-profile-container {
      position: fixed;
      top: 15px;
      right: 20px;
      z-index: 1100;
    }

    /* Logout Button Loading State */
    .btn-loading {
      pointer-events: none;
      opacity: 0.7;
    }

    .btn-loading .btn-text {
      visibility: hidden;
    }

    .btn-loading::after {
      content: "";
      position: absolute;
      width: 20px;
      height: 20px;
      top: 50%;
      left: 50%;
      margin-left: -10px;
      margin-top: -10px;
      border: 2px solid transparent;
      border-top: 2px solid #000;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>
</head>

<body>
  <!-- ✅ Global Loading Spinner -->
  <div id="loadingSpinner" class="d-flex">
    <div class="spinner-border text-light" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>

  <!-- ✅ Sidebar -->
  <nav id="sidebar" class="bg-dark">
    <div class="text-center py-4 border-bottom border-secondary">
      <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img mb-2" />
      <h5 class="text-white">
        Pundo<span style="background-color: white; color: black; padding: 2px 6px; border-radius: 4px;">Hub</span>
      </h5>
    </div>

    <ul class="nav flex-column mt-3 px-2">
    @auth
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
    </li>

    {{-- Admin Links --}}
    @if(auth()->user()->role === 'admin')
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('bereavement-cases.*') ? 'active' : '' }}"
               href="{{ route('bereavement-cases.create') }}">
                <i class="bi bi-people me-2"></i> Bereavement Cases
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.death-reports.*') ? 'active' : '' }}"
               href="{{ route('admin.death-reports.index') }}">
                <i class="bi bi-file-earmark-medical-fill me-2"></i> Death Reports
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('donations.*') ? 'active' : '' }}"
               href="{{ route('donations.index') }}">
                <i class="bi bi-cash-coin me-2"></i> Donations
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('notifications.index') ? 'active' : '' }}"
               href="{{ route('notifications.index') }}">
                <i class="bi bi-bell me-2"></i> Notifications
                @if(Auth::user()->unreadNotifications->count() > 0)
                    <span class="badge bg-danger">{{ Auth::user()->unreadNotifications->count() }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('members.*') ? 'active' : '' }}"
               href="{{ route('members.index') }}">
                <i class="bi bi-person-lines-fill me-2"></i> Members
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.penalties') ? 'active' : '' }}"
               href="{{ route('admin.penalties') }}">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> Penalties
            </a>
        </li>

    {{-- Staff Links --}}
    @elseif(auth()->user()->role === 'staff')
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('report.death') ? 'active' : '' }}"
               href="{{ route('report.death') }}">
                <i class="bi bi-file-earmark-medical-fill me-2"></i> Report a Death
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('notifications.index') ? 'active' : '' }}"
               href="{{ route('notifications.index') }}">
                <i class="bi bi-bell me-2"></i> My Notifications
                @if(Auth::user()->unreadNotifications->count() > 0)
                    <span class="badge bg-danger">{{ Auth::user()->unreadNotifications->count() }}</span>
                @endif
            </a>
        </li>

    {{-- Regular Member Links --}}
    @elseif(auth()->user()->role === 'member')
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('donations.create') ? 'active' : '' }}"
               href="{{ route('donations.create') }}">
                <i class="bi bi-heart-fill me-2"></i> Donate
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('report.death') ? 'active' : '' }}"
               href="{{ route('report.death') }}">
                <i class="bi bi-file-earmark-medical-fill me-2"></i> Report a Death
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('notifications.index') ? 'active' : '' }}"
               href="{{ route('notifications.index') }}">
                <i class="bi bi-bell me-2"></i> My Notifications
                @if(Auth::user()->unreadNotifications->count() > 0)
                    <span class="badge bg-danger">{{ Auth::user()->unreadNotifications->count() }}</span>
                @endif
            </a>
        </li>
    @endif
    @endauth
</ul>

    <hr class="bg-secondary" />

    <!-- Profile Section in Sidebar -->
    <div class="px-3 mb-3">
      @auth
      <div class="d-flex align-items-center text-light p-2 rounded">
        <div class="me-3">
          @if(auth()->user()->profile_picture)
            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" 
                 alt="Profile" class="profile-picture">
          @else
            <div class="profile-default">
              <i class="bi bi-person-fill text-light"></i>
            </div>
          @endif
        </div>
        <div class="flex-grow-1">
          <div class="user-info fw-semibold">{{ auth()->user()->name }}</div>
          <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
        </div>
      </div>
      @else
      <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
        <i class="bi bi-box-arrow-in-right me-2"></i> Login
      </a>
      @endauth
    </div>
  </nav>

  <!-- Sidebar toggle -->
  <button id="sidebarToggle" class="btn btn-dark d-lg-none">
    <i class="bi bi-list"></i>
  </button>

  <!-- Top Right Profile Picture Dropdown -->
  @auth
  <div class="top-profile-container">
    <div class="dropdown">
      <button class="profile-dropdown-toggle" type="button" id="topProfileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        @if(auth()->user()->profile_picture)
          <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" 
               alt="Profile" class="profile-picture">
        @else
          <div class="profile-default">
            <i class="bi bi-person-fill text-light"></i>
          </div>
        @endif
      </button>
      <ul class="dropdown-menu profile-dropdown shadow-lg" aria-labelledby="topProfileDropdown">
        <li class="px-3 py-2 border-bottom border-secondary">
          <div class="user-info">{{ auth()->user()->name }}</div>
          <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
        </li>
        <li>
          <a class="dropdown-item" href="{{ route('profile.edit') }}">
            <i class="bi bi-person-gear me-2 text-info"></i>Edit Profile
          </a>
        </li>
      
        <li><hr class="dropdown-divider bg-secondary my-1"></li>
        <li>
          <button class="dropdown-item logout-item" data-bs-toggle="modal" data-bs-target="#logoutModal">
            <i class="bi bi-box-arrow-right me-2 text-danger"></i>Logout
          </button>
        </li>
      </ul>
    </div>
  </div>
  @endauth

  <!-- Main Content -->
  <div id="content" class="p-4">@yield('content')</div>

  <!-- ✅ Logout Confirmation Modal - Smaller -->
  <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="logoutModalLabel">
            <i class="bi bi-box-arrow-right text-warning me-2"></i> Logout
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="mb-0">Are you sure you want to log out?</p>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Cancel</button>
          <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger px-3" id="logoutButton">
              <span class="btn-text">Logout</span>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- ✅ Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  const spinner = document.getElementById("loadingSpinner");
  const logoutButton = document.getElementById("logoutButton");
  const logoutForm = document.getElementById("logoutForm");

  function showSpinner() {
    spinner.classList.add("active");
  }

  function hideSpinner() {
    spinner.classList.remove("active");
  }

  // Sidebar toggle
  document
    .getElementById("sidebarToggle")
    .addEventListener("click", function () {
      document.getElementById("sidebar").classList.toggle("show");
    });

  // Spinner on navigation
  const navLinks = document.querySelectorAll("#sidebar a.nav-link");
  navLinks.forEach((link) => {
    link.addEventListener("click", function () {
      if (this.getAttribute("href") === "#" || this.classList.contains("active")) return;
      showSpinner();
    });
  });

  // Logout with loading spinner
  if (logoutButton && logoutForm) {
    logoutForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Show loading state on button
      logoutButton.classList.add('btn-loading');
      logoutButton.disabled = true;
      
      // Show fullscreen spinner
      showSpinner();
      
      // Submit the form after a short delay to show the loading state
      setTimeout(() => {
        logoutForm.submit();
      }, 500);
    });
  }

  // Profile picture hover effect
  const profilePictures = document.querySelectorAll('.profile-picture, .profile-default');
  profilePictures.forEach(pic => {
    pic.addEventListener('mouseenter', function() {
      this.style.transform = 'scale(1.15)';
      this.style.boxShadow = '0 0 20px rgba(13, 202, 240, 0.6)';
    });
    
    pic.addEventListener('mouseleave', function() {
      this.style.transform = 'scale(1)';
      this.style.boxShadow = 'none';
    });
  });

  // Reset logout button state when modal is closed
  const logoutModal = document.getElementById('logoutModal');
  if (logoutModal) {
    logoutModal.addEventListener('hidden.bs.modal', function () {
      if (logoutButton) {
        logoutButton.classList.remove('btn-loading');
        logoutButton.disabled = false;
      }
    });
  }

  window.addEventListener("load", () => hideSpinner());

  @if(session('success') && request()->routeIs('dashboard'))
    alert("{{ session('success') }}");
  @endif
</script>

</body>
</html>