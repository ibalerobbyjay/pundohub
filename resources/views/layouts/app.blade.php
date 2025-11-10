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

    /* ✅ Styled Logout Modal */
    .modal-content {
      background: rgba(20, 20, 20, 0.85);
      color: #fff;
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 16px;
      backdrop-filter: blur(12px);
      box-shadow: 0 0 30px rgba(245, 244, 243, 0.3);
      animation: popIn 0.25s ease-out;
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
    }

    .modal-footer {
      border-top: 1px solid rgba(255, 255, 255, 0.15);
    }

    .btn-danger {
      background-color: white;
      border: none;
      color: black;
      font-weight: 600;
      transition: all 0.3s ease;
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
    }

    .btn-secondary:hover {
      background-color: #555;
      transform: scale(1.05);
    }

    .modal-body {
      font-size: 1rem;
      text-align: center;
    }

    body.modal-open {
      overflow: hidden !important;
      padding-right: 0 !important;
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

    <ul class="nav flex-column px-2 mb-3">
      @auth
      <li class="nav-item dropdown text-center">
        <a class="nav-link dropdown-toggle text-light d-flex align-items-center justify-content-center" href="#"
          id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-person-circle me-2"></i>
          {{ auth()->user()->name }}
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow border-0 mt-2"
          aria-labelledby="userDropdown">
          <li>
            <a class="dropdown-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}"
              href="{{ route('profile.edit') }}">
              <i class="bi bi-pencil-square me-2"></i> Edit Profile
            </a>
          </li>
          <li><hr class="dropdown-divider" /></li>
          <li>
            <form id="logoutForm" action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="dropdown-item text-danger">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
              </button>
            </form>
          </li>
        </ul>
      </li>
      @else
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
          <i class="bi bi-box-arrow-in-right me-2"></i> Login
        </a>
      </li>
      @endauth
    </ul>
  </nav>

  <!-- Sidebar toggle -->
  <button id="sidebarToggle" class="btn btn-dark d-lg-none">
    <i class="bi bi-list"></i>
  </button>

  <!-- Main Content -->
  <div id="content" class="p-4">@yield('content')</div>

  <!-- ✅ Logout Confirmation Modal -->
  <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="logoutModalLabel">
            <i class="bi bi-box-arrow-right text-warning me-2"></i> Confirm Logout
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to <strong class="text-warning">log out</strong> of PundoHub?
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
          <button id="confirmLogoutBtn" type="button" class="btn btn-danger px-4">Logout</button>
        </div>
      </div>
    </div>
  </div>

  <!-- ✅ Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  const spinner = document.getElementById("loadingSpinner");

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

  window.addEventListener("load", () => hideSpinner());

  // ✅ Logout Confirmation (with fade-out + fullscreen spinner)
  const logoutForm = document.getElementById("logoutForm");
  const confirmLogoutBtn = document.getElementById("confirmLogoutBtn");
  const logoutModalEl = document.getElementById("logoutModal");
  const logoutModal = new bootstrap.Modal(logoutModalEl);

  if (logoutForm && confirmLogoutBtn) {
    logoutForm.addEventListener("submit", function (e) {
      e.preventDefault();
      logoutModal.show();

      confirmLogoutBtn.addEventListener(
        "click",
        function () {
          // Disable the button briefly to avoid double-clicks
          confirmLogoutBtn.disabled = true;
          confirmLogoutBtn.innerHTML = `
            <i class="bi bi-box-arrow-right me-2"></i> Logging out...
          `;

          // Smooth fade-out animation for modal
          const modalContent = logoutModalEl.querySelector(".modal-content");
          modalContent.style.transition = "opacity 0.4s ease";
          modalContent.style.opacity = "0";

          setTimeout(() => {
            logoutModal.hide(); // hide modal
            showSpinner(); // show fullscreen spinner
            logoutForm.submit(); // submit logout
          }, 400);
        },
        { once: true }
      );
    });
  }

  @if(session('success') && request()->routeIs('dashboard'))
    alert("{{ session('success') }}");
  @endif
</script>

</body>
</html>
