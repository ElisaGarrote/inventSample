<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library Management System - Dashboard</title>
  <link rel="stylesheet" href="{{ asset('css/Admin.Dashboard.css') }}">
</head>
<body>

  <!-- Header -->
  <div class="header">
    <img src="{{ asset('assets/UNIARCHIVE.HEADER.png') }}" alt="UNARCHIVE Logo" class="logo">
    <div class="search-container">
      <input type="text" placeholder="Find book..." class="search-bar">
      <button class="clear-btn">✖</button>
    </div>
    <div class="header-icons">
      <button class="logout-btn" onclick="handleLogout()">Log out</button>
    </div>
  </div>

  <script>
      function handleLogout() {
      const confirmation = confirm("Are you sure you want to logout?");
      if (confirmation) {
          document.getElementById('logout-form').submit();
      }
  }
  </script>

  <!-- Title Bar -->
  <div class="title-bar">
    <span id="current-date"></span>
    <span id="current-time"></span>
  </div>

  <script>
    function updateDateTime() {
      const now = new Date();
      const date = now.toLocaleDateString('en-US');
      const time = now.toLocaleTimeString('en-US');
      document.getElementById('current-date').textContent = date;
      document.getElementById('current-time').textContent = time;
    }
    setInterval(updateDateTime, 1000);
    window.onload = updateDateTime;
  </script>

  <!-- Sidebar -->
  <div class="sidebar">
    <button onclick="window.location.href='{{ route('admin.dashboard') }}';">Dashboard</button>
    <button onclick="window.location.href='{{ route('admin.book_inventory') }}';">Book Inventory</button>
    <button onclick="window.location.href='{{ route('admin.user_management') }}';">User Management</button>
    <button onclick="window.location.href='{{ route('admin.reports') }}';">Reports</button>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Status Section -->
    <div class="status-section">
      <div class="status-card">
        <div class="status-number">000</div>
        <div class="status-label">Borrowed Books</div>
      </div>
      <div class="status-card">
        <div class="status-number">000</div>
        <div class="status-label">Reserved Books</div>
      </div>
      <div class="status-card">
        <div class="status-number">000</div>
        <div class="status-label">Available Books</div>
      </div>
      <div class="status-card total-card">
        <div class="status-number">000</div>
        <div class="status-label">Total of Books</div>
      </div>
      <div class="status-card">
        <div class="status-number">000</div>
        <div class="status-label">Damaged Books</div>
      </div>
      <div class="status-card">
        <div class="status-number">000</div>
        <div class="status-label">Missing Books</div>
      </div>
      <div class="status-card">
        <div class="status-number">000</div>
        <div class="status-label">Overdue Books</div>
      </div>
    </div>

    <h2>Faculty Librarian Assign</h2>
    <div class="frame-container">
      <iframe src="" title="Content Frame" class="content-frame" frameborder="0"></iframe>
    </div>

    <!-- Research Books Section -->
    <div class="research-section">
      <h2>Types of Research Books</h2>
      <div class="research-list">
        <ul>
          <li>Descriptive Studies</li>
          <li>Exploratory Studies</li>
          <li>Explanatory (Causal) Studies</li>
          <li>Evaluative Studies</li>
          <li>Qualitative Research</li>
          <li>Quantitative Research</li>
          <li>Mixed-Methods Research</li>
          <li>Theoretical Studies</li>
          <li>Applied Studies</li>
          <li>Empirical Studies</li>
        </ul>
        <ul> 
          <li>000</li>
          <li>000</li>
          <li>000</li>
          <li>000</li>
          <li>000</li>
          <li>000</li>
          <li>000</li>
          <li>000</li>
          <li>000</li>
          <li>000</li>
        </ul>
        <ul>
          <li>Cross-Sectional Studies</li>
          <li>Longitudinal Studies</li>
          <li>Primary Research</li>
          <li>Secondary Research</li>
          <li>Social Sciences Research</li>
          <li>Natural Sciences Research</li>
          <li>Business and Management Research</li>
          <li>Technology Research</li>
          <li>Experimental Research</li>
          <li>Non-Experimental Research</li>
        </ul>
        <ul> 
          <li>000</li>
          <li>000</li>
          <li>000</li>
          <li>000</li>
          <li>000</li>
          <li>000</li>
          <li>000</li>
          <li>000</li>
          <li>000</li>
          <li>000</li>
        </ul>
      </div>
    </div>
  </div>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
</body>
</html>
