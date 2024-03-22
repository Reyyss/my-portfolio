 // Get the logout button
 const logoutBtn = document.getElementById('logoutBtn');

 // Add click event listener to the logout button
 logoutBtn.addEventListener('click', () => {
   // Display SweetAlert confirmation dialog
   Swal.fire({
     title: 'Are you sure?',
     text: 'You will be logged out!',
     icon: 'warning',
     showCancelButton: true,
     confirmButtonColor: '#3085d6',
     cancelButtonColor: '#d33',
     confirmButtonText: 'Yes, logout!'
   }).then((result) => {
     // If user confirms logout
     if (result.isConfirmed) {
       // Perform logout action
       logout();
     }
   });
 });

 // Function to perform logout action
 function logout() {
   // Redirect to logout page or perform logout action
   window.location.href = '../index.php';
 }