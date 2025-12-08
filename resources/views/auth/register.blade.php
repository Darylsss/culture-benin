<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #f8fafc;
            --text: #1e293b;
            --text-light: #64748b;
            --border: #e2e8f0;
            --error: #ef4444;
            --success: #10b981;
            --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: var(--text);
            line-height: 1.5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1rem;
        }

        .container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .illustration {
            flex: 1;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            color: white;
            text-align: center;
        }

        .illustration h2 {
            font-size: 1.75rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .illustration p {
            font-size: 1rem;
            opacity: 0.9;
            max-width: 300px;
        }

        .form-container {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary);
        }

        .logo-icon {
            width: 32px;
            height: 32px;
            background-color: var(--primary);
            border-radius: 8px;
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        h1 {
            font-size: 1.875rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: var(--text-light);
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--text);
        }

        .input-container {
            position: relative;
        }

        input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.2s;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .input-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
        }

        .password-strength {
            margin-top: 0.5rem;
            font-size: 0.75rem;
        }

        .strength-bar {
            height: 4px;
            background-color: var(--border);
            border-radius: 2px;
            margin-top: 0.25rem;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak {
            background-color: var(--error);
            width: 33%;
        }

        .strength-medium {
            background-color: #f59e0b;
            width: 66%;
        }

        .strength-strong {
            background-color: var(--success);
            width: 100%;
        }

        .error-message {
            color: var(--error);
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .terms {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .terms input {
            width: auto;
            margin-right: 0.75rem;
            margin-top: 0.25rem;
        }

        .terms label {
            font-size: 0.875rem;
            color: var(--text-light);
        }

        .terms a {
            color: var(--primary);
            text-decoration: none;
        }

        .terms a:hover {
            text-decoration: underline;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-primary:disabled {
            background-color: var(--border);
            cursor: not-allowed;
        }

        .separator {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: var(--text-light);
            font-size: 0.875rem;
        }

        .separator::before,
        .separator::after {
            content: "";
            flex: 1;
            height: 1px;
            background-color: var(--border);
        }

        .separator span {
            padding: 0 1rem;
        }

        .btn-secondary {
            background-color: white;
            color: var(--text);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-secondary:hover {
            background-color: var(--secondary);
        }

        .btn-icon {
            margin-right: 0.5rem;
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--text-light);
            font-size: 0.875rem;
        }

        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .illustration {
                padding: 2rem 1rem;
            }
            
            .form-container {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="illustration">
            <h2>Rejoignez-nous</h2>
            <p>Créez votre compte pour découvrir toutes nos fonctionnalités et commencer votre expérience.</p>
            <svg width="250" height="200" viewBox="0 0 250 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="50" y="50" width="150" height="100" rx="10" fill="white" fill-opacity="0.2"/>
                <rect x="70" y="70" width="80" height="8" rx="4" fill="white" fill-opacity="0.7"/>
                <rect x="70" y="85" width="60" height="6" rx="3" fill="white" fill-opacity="0.5"/>
                <rect x="70" y="100" width="110" height="8" rx="4" fill="white" fill-opacity="0.5"/>
                <rect x="70" y="115" width="90" height="8" rx="4" fill="white" fill-opacity="0.5"/>
                <circle cx="190" cy="80" r="15" fill="white" fill-opacity="0.7"/>
                <path d="M185 80L188 83L195 75" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        
        <div class="form-container">
           
            
            <h1>Créez votre compte</h1>
            <p class="subtitle">Remplissez les informations ci-dessous pour vous inscrire</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Nom complet</label>
                    <div class="input-container">
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Votre nom complet">
                        <div class="input-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <div class="input-container">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="votre@email.com">
                        <div class="input-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M22 6L12 13L2 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <div class="input-container">
                        <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Créez un mot de passe sécurisé">
                        <div class="input-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M19 12C19 12 17 15 12 15C7 15 5 12 5 12C5 12 7 9 12 9C17 9 19 12 19 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                   
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">Confirmer le mot de passe</label>
                    <div class="input-container">
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmez votre mot de passe">
                        <div class="input-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M19 12C19 12 17 15 12 15C7 15 5 12 5 12C5 12 7 9 12 9C17 9 19 12 19 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                    @error('password_confirmation')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Terms and Conditions -->
                <div class="terms">
                    <input id="terms" type="checkbox" name="terms" required>
                    <label for="terms">
                        J'accepte les <a href="#">conditions d'utilisation</a> et la <a href="#">politique de confidentialité</a>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary" id="register-btn">Créer mon compte</button>
            </form>
            
            <div class="separator">
                <span>Ou s'inscrire avec</span>
            </div>
            
            <button class="btn btn-secondary">
                <svg class="btn-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 12C22 10.6868 21.7413 9.38642 21.2388 8.17317C20.7362 6.95991 19.9997 5.85752 19.0711 4.92893C18.1425 4.00035 17.0401 3.26375 15.8268 2.7612C14.6136 2.25866 13.3132 2 12 2C10.6868 2 9.38642 2.25866 8.17317 2.7612C6.95991 3.26375 5.85752 4.00035 4.92893 4.92893C4.00035 5.85752 3.26375 6.95991 2.7612 8.17317C2.25866 9.38642 2 10.6868 2 12C2 14.6522 3.05357 17.1957 4.92893 19.0711C6.8043 20.9464 9.34784 22 12 22C14.6522 22 17.1957 20.9464 19.0711 19.0711C20.9464 17.1957 22 14.6522 22 12Z" stroke="currentColor" stroke-width="2"/>
                    <path d="M12 2C14.5013 4.73835 15.9228 8.29203 16 12C15.9228 15.708 14.5013 19.2616 12 22" stroke="currentColor" stroke-width="2"/>
                    <path d="M2 12H22" stroke="currentColor" stroke-width="2"/>
                </svg>
                Google
            </button>
            
            <div class="login-link">
                Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
            </div>
        </div>
    </div>

    <script>
        // Indicateur de force du mot de passe
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthFill = document.getElementById('strength-fill');
            const strengthText = document.getElementById('strength-text');
            
            // Réinitialiser
            strengthFill.className = 'strength-fill';
            
            let strength = 0;
            
            // Longueur
            if (password.length >= 8) strength++;
            
            // Lettres minuscules et majuscules
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            
            // Chiffres
            if (/[0-9]/.test(password)) strength++;
            
            // Caractères spéciaux
            if (/[^a-zA-Z0-9]/.test(password)) strength++;
            
            // Mettre à jour l'affichage
            if (password.length === 0) {
                strengthText.textContent = 'Faible';
                strengthFill.className = 'strength-fill';
            } else if (strength <= 2) {
                strengthText.textContent = 'Faible';
                strengthFill.className = 'strength-fill strength-weak';
            } else if (strength === 3) {
                strengthText.textContent = 'Moyen';
                strengthFill.className = 'strength-fill strength-medium';
            } else {
                strengthText.textContent = 'Fort';
                strengthFill.className = 'strength-fill strength-strong';
            }
        });

        // Validation des mots de passe identiques
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (confirmPassword && password !== confirmPassword) {
                this.style.borderColor = 'var(--error)';
            } else {
                this.style.borderColor = '';
            }
        });

        // Validation du formulaire
        document.querySelector('form').addEventListener('submit', function(e) {
            const terms = document.getElementById('terms');
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            
            if (!terms.checked) {
                e.preventDefault();
                alert('Veuillez accepter les conditions d\'utilisation');
                return;
            }
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Les mots de passe ne correspondent pas');
                return;
            }
        });
    </script>
</body>
</html>