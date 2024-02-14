$(document).ready(function () {
  // Add smooth scrolling on all links inside the navbar
  $(".navbar-nav a").on("click", function (event) {
    const hash = this.hash;
    // Remove active class from all links
    $(".navbar-nav a").removeClass("active");
    // Add active class to the clicked link
    $(this).addClass("active");

    $("html, body").animate(
      {
        scrollTop: $(hash).offset().top,
      },
      800,
      function () {
        window.location.hash = hash;
      }
    );
  });

  // Update active state on scroll
  $(window).scroll(function () {
    const scrollDistance = $(window).scrollTop();

    // Assign active class to nav links while scrolling
    $("section").each(function () {
      const sectionTop = $(this).offset().top;
      const sectionBottom = sectionTop + $(this).height();

      if (sectionTop <= scrollDistance && sectionBottom > scrollDistance) {
        const sectionId = $(this).attr("id");
        // Remove active class from all links
        $(".navbar-nav a").removeClass("active");
        // Add active class to the corresponding link
        $(".navbar-nav a[href='#" + sectionId + "']").addClass("active");
      }
    });
  });
});
