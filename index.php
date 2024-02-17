<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <title>Rey's - Portfolio</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/about-section.css" />
    <link rel="stylesheet" href="css/contact-section.css" />
    <link rel="stylesheet" href="css/projects-section.css" />
    <link rel="stylesheet" href="css/skills-section.css" />
    <link rel="stylesheet" href="css/reponsiveness.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
    />
  </head>
  <body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light">
      <a class="navbar-brand" href="admin/login/login.php"
        ><img src="images/LOGO.png" alt="Logo" style="height: 30px"
      /></a>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="#home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#about">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#skills">Skills</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#projects">Projects</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contact">Contact</a>
          </li>
        </ul>
      </div>
    </nav>

    <main>
      <!-- Home Section -->
      <section id="home">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <div class="text-center text-lg-left">
                <h2 class="display-4 mb-4">
                  Hello, it's me <br /><span id="name">Reynido</span>
                </h2>
                <h2 class="display-4 mb-4" id="work">
                  <span id="typing-text"></span><span id="cursor">_</span>
                </h2>

                <p class="lead">
                  Aspiring Web and Mobile App Developer with a passion for
                  crafting digital experiences. Currently studying at Western
                  Mindanao State University, I am dedicated to learning and
                  exploring new technologies to bring innovative ideas to life.
                </p>
                <a href="#contact" class="btn btn-outline-dark">
                  <i class="fas fa-envelope mr-1"></i> Message Me
                </a>
                <a
                  href="path/to/your-cv.pdf"
                  download
                  class="btn btn-outline-dark"
                >
                  <i class="fas fa-download mr-1"></i> Download CV
                </a>
              </div>
            </div>
            <div class="col-lg-6 position-relative">
              <div class="profile-container">
                <img
                  src="images/profile.png"
                  alt="profile"
                  class="img-fluid rounded-circle mx-auto d-block"
                />
                <i class="fas fa-power-off power-icon"></i>
                <div class="social-icons">
                  <!-- Add your social icons here -->
                  <div class="social-icon facebook">
                    <i class="fab fa-facebook"></i>
                  </div>
                  <div class="social-icon github">
                    <i class="fab fa-github"></i>
                  </div>
                  <div class="social-icon telegram">
                    <i class="fab fa-telegram"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- About Section -->
      <section id="about">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <img
                src="images/profile.png"
                alt="About Me"
                class="img-fluid rounded"
                id="about-me-profile"
              />
            </div>
            <div class="col-lg-6">
              <div class="about-content">
                <h2 class="display-4 mb-4 text-center">About Me</h2>
                <p class="lead">
                  Hey there! 🌟 I'm <span id="aboutme">Reynido S. Hamog</span>,
                  23 years old and a fourth-year student at Western Mindanao
                  State University (WMSU), pursuing a degree in Bachelor of
                  Science in Information Technology (BSIT). I'm on a mission to
                  become a skilled Web and Android Developer, and my college
                  journey is a thrilling ride of discovery and growth.
                </p>
                <p class="lead">
                  Right now, I'm diving into the worlds of front-end and
                  back-end development. Learning the ropes, unraveling
                  complexities, and finding creative ways to build awesome
                  things online keep me hooked. Challenges are my playground,
                  and I'm always up for new and exciting projects.
                </p>
                <p class="lead">
                  My portfolio is a showcase of the projects I've tackled during
                  my college adventures. I'm eager to collaborate and open to
                  any opportunities that come my way. Whether you've got a cool
                  project or just want to chat tech, feel free to hit me up!
                  Let's bring fantastic ideas to life together! 🚀
                </p>
                <p class="lead">
                  Alongside my academic journey, I stay tuned to the latest tech
                  trends. My goal is to contribute meaningfully to the
                  ever-evolving field of technology and make a positive impact.
                  If you share the same passion, let's connect and explore the
                  boundless possibilities of the tech world.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Skills Section -->
      <section id="skills" class="py-5">
        <div class="container">
          <h2 class="display-4 text-center">Skills</h2>

          <div class="row">
            <div class="col-md-6">
              <h3 class="text-center mb-4">Front-end Development</h3>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <i class="fab fa-html5 mr-2"></i> <span>HTML5</span>
                  <div class="progress mt-2">
                    <div
                      class="progress-bar bg-success"
                      role="progressbar"
                      style="width: 85%"
                      aria-valuenow="80"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    >
                      85%
                    </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <i class="fab fa-css3-alt mr-2"></i> <span>CSS3</span>
                  <div class="progress mt-2">
                    <div
                      class="progress-bar bg-info"
                      role="progressbar"
                      style="width: 72%"
                      aria-valuenow="70"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    >
                      72%
                    </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <i class="fab fa-js mr-2"></i> <span>JavaScript</span>
                  <div class="progress mt-2">
                    <div
                      class="progress-bar bg-warning"
                      role="progressbar"
                      style="width: 49%"
                      aria-valuenow="90"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    >
                      49%
                    </div>
                  </div>
                </li>
              </ul>
            </div>

            <div class="col-md-6">
              <h3 class="text-center mb-4">Mobile App Development</h3>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <i class="fab fa-dart mr-2"></i> <span>Dart</span>
                  <div class="progress mt-2">
                    <div
                      class="progress-bar bg-warning"
                      role="progressbar"
                      style="width: 56%"
                      aria-valuenow="70"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    >
                      56%
                    </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <i class="fab fa-flutter mr-2"></i> <span>Flutter</span>
                  <div class="progress mt-2">
                    <div
                      class="progress-bar bg-success"
                      role="progressbar"
                      style="width: 60%"
                      aria-valuenow="75"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    >
                      60%
                    </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <i class="fab fa-java mr-2"></i> <span>Java</span>
                  <div class="progress mt-2">
                    <div
                      class="progress-bar bg-info"
                      role="progressbar"
                      style="width: 43%"
                      aria-valuenow="60"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    >
                      43%
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-md-6">
              <h3 class="text-center mb-4">Back-end Development</h3>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <i class="fab fa-php mr-2"></i> <span>PHP</span>
                  <div class="progress mt-2">
                    <div
                      class="progress-bar bg-info"
                      role="progressbar"
                      style="width: 53%"
                      aria-valuenow="75"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    >
                      53%
                    </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <i class="fas fa-database mr-2"></i> <span>SQL</span>
                  <div class="progress mt-2">
                    <div
                      class="progress-bar bg-success"
                      role="progressbar"
                      style="width: 50%"
                      aria-valuenow="85"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    >
                      50%
                    </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <i class="fab fa-python mr-2"></i> <span>Python</span>
                  <div class="progress mt-2">
                    <div
                      class="progress-bar bg-danger"
                      role="progressbar"
                      style="width: 42%"
                      aria-valuenow="65"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    >
                      42%
                    </div>
                  </div>
                </li>
              </ul>
            </div>

            <div class="col-md-6">
              <h3 class="text-center mb-4">Other Skills</h3>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <i class="fab fa-git mr-2"></i>
                  <span>Git & Version Control</span>
                  <div class="progress mt-2">
                    <div
                      class="progress-bar bg-danger"
                      role="progressbar"
                      style="width: 40%"
                      aria-valuenow="90"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    >
                      40%
                    </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <i class="fas fa-mobile-alt mr-2"></i>
                  <span>Responsive Design</span>
                  <div class="progress mt-2">
                    <div
                      class="progress-bar bg-warning"
                      role="progressbar"
                      style="width: 70%"
                      aria-valuenow="80"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    >
                      70%
                    </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <i class="fas fa-lightbulb mr-2"></i>
                  <span>Problem Solving</span>
                  <div class="progress mt-2">
                    <div
                      class="progress-bar bg-success"
                      role="progressbar"
                      style="width: 80%"
                      aria-valuenow="95"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    >
                      80%
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>

      <!-- Projects Section -->
      <section id="projects" class="py-5">
        <div class="container">
          <h2 class="display-4 text-center">Projects</h2>
          <div class="row mt-5">
            <!-- Project 1 -->
            <div class="col-md-4">
              <div class="card mb-4">
                <div class="flip-card">
                  <div class="flip-card-inner">
                    <!-- Front face of the card -->
                    <div class="flip-card-front">
                      <div class="position-relative">
                        <img
                          src="images/profile.png"
                          class="card-img-top"
                          alt="Project 1"
                        />
                        <div class="card-title-inside">E-Commerce Website</div>
                      </div>
                    </div>
                    <!-- Back face of the card -->
                    <div class="flip-card-back">
                      <div class="card-body">
                        <p class="card-text">
                          Developed a fully functional e-commerce website using
                          HTML, CSS, and JavaScript. Implemented features such
                          as product listing, user authentication, and cart
                          management.
                        </p>
                        <p class="card-text">
                          Technologies Used: HTML, CSS, JavaScript and PHP
                          <br />
                          Role: Full Stack Developer
                        </p>
                        <a
                          href="#"
                          class="btn btn-outline-dark"
                          id="see-project"
                        >
                          View Details
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Contact Section -->
      <section id="contact" class="py-5">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 mx-auto text-center">
              <h2 class="display-4 mb-4">Contact Me</h2>
              <p class="lead mb-4">
                I'm excited to hear from you. Feel free to reach out!
              </p>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6 mx-auto">
              <form>
                <div class="form-group">
                  <label for="name">Name</label>
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    placeholder="Enter your name"
                  />
                </div>
                <div class="form-group">
                  <label for="email">Email Address</label>
                  <input
                    type="email"
                    class="form-control"
                    id="email"
                    placeholder="Enter your email"
                  />
                </div>
                <div class="form-group">
                  <label for="message">Message</label>
                  <textarea
                    class="form-control"
                    id="message"
                    rows="4"
                    placeholder="Enter your message"
                  ></textarea>
                </div>
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-paper-plane mr-2"></i> Send Message
                </button>
              </form>
            </div>
          </div>

          <div class="row mt-5">
            <div class="col-lg-8 mx-auto text-center">
              <p class="lead mb-4">Connect with me on social media:</p>
              <i class="fab fa-facebook mx-3" id="social"></i>
              <i class="fab fa-telegram mx-3" id="social"></i>
              <i class="fab fa-github mx-3" id="social"></i>
            </div>
          </div>
        </div>
      </section>

      <!-- Footer Section -->
      <footer class="py-3 text-white text-center">
        <div class="container">
          <p>&copy; 2024 Reynido S. Hamog</p>
        </div>
      </footer>
    </main>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script src="js/text-animation.js"></script>
    <script src="js/icon-display.js"></script>
    <script src="js/active-nav.js"></script>
  </body>
</html>