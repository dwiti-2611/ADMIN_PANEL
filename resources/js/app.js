// Assume this function retrieves the current user's role
function getUserRole() {
  // Logic to get user role
  return 'user'; // or "admin"
}

// Function to handle dashboard redirection
function redirectToDashboard() {
  var userRole = getUserRole();
  if (userRole === 'user') {
    window.location.href = '/user/dashboard';
  } else if (userRole === 'admin') {
    window.location.href = '/admin/dashboard';
  }
}

// Assuming there's an event listener for when the user clicks on the Dashboards option
document.getElementById('dashboard-link').addEventListener('click', redirectToDashboard);
