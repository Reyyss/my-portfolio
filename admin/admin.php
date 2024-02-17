<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>REY'S CMS</title>
    <link rel="stylesheet" href="admin-style.css" />
    <!-- Link your CSS file here -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    />
    <!-- Font Awesome -->
  </head>
  <body>
    <nav class="navbar">
      <div class="logo">
        <img src="../images/LOGO.png" alt="Logo" />
      </div>
      <div class="admin-profile">
        <img src="../images/profile.png" alt="Admin Profile" />
      </div>
    </nav>
    <div class="wrapper">
      <input type="checkbox" id="btn" hidden />
      <label for="btn" class="menu-btn">
        <i class="fas fa-bars"></i>
        <i class="fas fa-times"></i>
      </label>
      <nav id="sidebar">
        <div class="title">CMS Menu</div>
        <ul class="list-items">
          <!-- Add your CMS options here -->
          <li class="active">
            <a href="#dashboard"><i class="fas fa-chart-line"></i>Dashboard</a>
          </li>
          <li>
            <a href="#profile"><i class="fas fa-user"></i>Profile</a>
          </li>
          <li>
            <a href="#about"><i class="fas fa-info-circle"></i>About</a>
          </li>
          <li>
            <a href="#skills"><i class="fas fa-cogs"></i>Skills</a>
          </li>
          <li>
            <a href="#projects"
              ><i class="fas fa-project-diagram"></i>Projects</a
            >
          </li>
          <li>
            <a href="#contact"><i class="fas fa-envelope"></i>Contact</a>
          </li>
        </ul>
      </nav>
    </div>
    <div class="content">
      <div class="content-container">
        <div class="header">CMS Dashboard</div>
        <div class="cms-content">
          <!-- Add your CMS content here -->
        </div>
      </div>
      
    </div>
  </body>
</html>