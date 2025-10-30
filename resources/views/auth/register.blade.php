<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WeHR - Inscription Employé</title>
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
        <h2 class="mt-6 text-3xl font-bold text-gray-900">Inscription Employé</h2>
        <p class="mt-2 text-sm text-gray-600">
          Déjà inscrit ?
          <a href="/connexion" class="font-medium text-primary hover:text-blue-500">Se connecter</a>
        </p>
      </div>

      <!-- Register Form -->
      <form id="registerForm" class="mt-8 space-y-6 bg-white p-8 rounded-2xl shadow-lg">
        @csrf
        <!-- Nom & Prénom -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">Prénom *</label>
            <input id="first_name" name="first_name" type="text" required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
              placeholder="Votre prénom">
          </div>
          <div>
            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
            <input id="last_name" name="last_name" type="text" required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
              placeholder="Votre nom">
          </div>
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
          <input id="email" name="email" type="email" required
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
            placeholder="votre@email.com">
        </div>

        <!-- Mot de passe -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe *</label>
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

        <!-- Confirmation -->
        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmez le mot de passe *</label>
          <input id="password_confirmation" name="password_confirmation" type="password" required
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
            placeholder="Confirmez votre mot de passe">
        </div>

        <!-- Submit -->
        <div>
          <button type="submit" id="submitBtn"
            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-primary hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
            <i class="fas fa-user-plus mr-2"></i>
            Créer mon compte
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('registerForm');
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
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Création...';
        submitBtn.disabled = true;

        try {
          const response = await fetch('/register', {
            method: 'POST',
            body: formData,
            headers: {
              'Accept': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            }
          });

          const data = await response.json();

          if (data.success) {
            alert('Compte créé avec succès');
            window.location.href = data.redirect || '/dashboard';
          } else {
            let errorMessage = data.message || 'Erreur lors de la création du compte';
            if (data.errors) {
              errorMessage += '\n' + Object.values(data.errors).flat().join('\n');
            }
            alert(errorMessage);
          }
        } catch (error) {
          console.error('Registration error:', error);
          alert('Erreur de communication avec le serveur');
        }

        submitBtn.innerHTML = '<i class="fas fa-user-plus mr-2"></i> Créer mon compte';
        submitBtn.disabled = false;
      });
    });
  </script>
</body>
</html>