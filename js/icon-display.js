document.addEventListener("DOMContentLoaded", function () {
    const powerIcon = document.querySelector(".power-icon");
    const socialIcons = document.querySelector(".social-icons");
  
    // Function to toggle social icons
    function toggleSocialIcons() {
      socialIcons.classList.toggle("visible");
    }
  
    // Event listener for the power icon
    powerIcon.addEventListener("click", function () {
      toggleSocialIcons();
    });
  });