// Get the elements
const content = document.querySelector('.content');
const sidebar = document.getElementById('sidebar');
const btn = document.getElementById('btn');

// Function to adjust content position based on sidebar visibility
function adjustContentPosition() {
  const sidebarWidth = sidebar.offsetWidth;
  const contentLeftMargin = sidebarWidth > 0 ? sidebarWidth : 0;
  content.style.marginLeft = contentLeftMargin + 'px';
}

// Add event listener to the toggle button
btn.addEventListener('change', () => {
  adjustContentPosition();
});

// Adjust position on initial load
window.addEventListener('DOMContentLoaded', () => {
  adjustContentPosition();
});
