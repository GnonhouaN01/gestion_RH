<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WeHR - Connexion Employé</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#3B82F6',
            secondary: '#6B7280',
            danger: '#EF4444',
            success: '#10B981'
          }
        }
      }
    }
  </script>
</head>
<body class="bg-gray-50 font-sans">
  <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <!-- Header -->
      <div class="text-center">
        <div class="flex items-center justify-center">
          <div class="w-12 h-12 bg-primary rounded-xl flex items-center justify-center">
            <i class="fas fa-users text-white text-xl"></i>
          </div>
          <span class="ml-3 text-2xl font-bold text-gray-900">WeHR</span>
        </div>
        <h2 class="mt-6 text-3xl font-bold text-gray-900">Connexion Employé</h2>
        <p class="mt-2 text-sm text-gray-600">
          Nouveau employé ?
          <a href="/inscription" class="font-medium text-primary hover:text-blue-500">Créer un compte</a>
        </p>
      </div>

      <!-- Login Form -->
      <form id="loginForm" class="mt-8 space-y-6 bg-white p-8 rounded-2xl shadow-lg">
        @csrf
        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <div class="relative">
            <input id="email" name="email" type="email" required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
              placeholder="votre@email.com">
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
              <i class="fas fa-envelope text-gray-400"></i>
            </div>
          </div>
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
          <div class="relative">
            <input id="password" name="password" type="password" required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
              placeholder="Votre mot de passe">
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
              <button type="button" id="togglePassword" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                <i class="fas fa-eye"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Remember -->
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <input id="remember" name="remember" type="checkbox" value="1"
              class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
            <label for="remember" class="ml-2 block text-sm text-gray-900">Se souvenir de moi</label>
          </div>
        </div>

        <!-- Submit -->
        <div>
          <button type="submit" id="submitBtn"
            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-primary hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
            <i class="fas fa-sign-in-alt mr-2"></i>
            Se connecter
          </button>
        </div>
      </form>

      <!-- Demo Credentials -->
      <div class="bg-blue-50 rounded-lg p-4 text-center">
        <p class="text-sm text-blue-700">
          <i class="fas fa-info-circle mr-1"></i>
          Compte de démonstration: demo@wehr.com / password
        </p>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('loginForm');
      const togglePassword = document.getElementById('togglePassword');
      const passwordInput = document.getElementById('password');
      const submitBtn = document.getElementById('submitBtn');

      // Toggle password visibility
      togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
      });

      // Form submission
      form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(form);
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Connexion...';
        submitBtn.disabled = true;

        try {
          const response = await fetch('/login', {
            method: 'POST',
            body: formData,
            headers: {
              'Accept': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            }
          });

          const data = await response.json();

          if (data.success) {
            // Redirection après connexion réussie
            window.location.href = data.redirect || '/dashboard';
          } else {
            alert(data.message || 'Email ou mot de passe incorrect');
            if (data.errors) {
              console.error('Validation errors:', data.errors);
            }
          }
        } catch (error) {
          console.error('Login error:', error);
          alert('Erreur de connexion au serveur');
        }

        submitBtn.innerHTML = '<i class="fas fa-sign-in-alt mr-2"></i> Se connecter';
        submitBtn.disabled = false;
      });

      // Auto-fill demo credentials for testing
      document.getElementById('email').value = 'demo@wehr.com';
      document.getElementById('password').value = 'password';
    });
  </script>
</body>
</html>