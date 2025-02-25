document.getElementById('loginForm').addEventListener('submit', function(event) {
  event.preventDefault();

  const email = document.getElementById('email').value;
  const password = document.getElementById('password').value;
  const role = document.getElementById('role').value;

  const data = {
      email: email,
      password: password,
      role: role
  };

  fetch('http://localhost:3000/login', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
  })
  .then(response => response.json())
  .then(data => {
      const responseDiv = document.getElementById('response');
      if (data.message) {
          responseDiv.textContent = data.message;
      } else {
          responseDiv.textContent = 'Login failed. Please try again.';
      }
  })
  .catch(error => {
      console.error('Error:', error);
      const responseDiv = document.getElementById('response');
      responseDiv.textContent = 'An error occurred. Please try again later.';
  });
});