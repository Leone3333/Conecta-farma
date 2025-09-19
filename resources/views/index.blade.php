<!--
<div>
    <form action="/login" method="post">
        @csrf
        <label>Matricula</label>
        <input type="text" name="matricula" placeholder="Digite seu RA" required>
        
        
        <label>Senha</label>
        <input type="text" name="senha" placeholder="Digite sua senha" required>

       <button type="submit">Enviar</button>
    </form>
</div>
-->

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5fff8;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            background: #1db584;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(180deg); }
        }

        .login-title {
            color: white;
            font-size: 2.5rem;
            font-weight: 300;
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
            z-index: 1;
        }

        .form-label {
            color: white;
            font-size: 1.1rem;
            font-weight: 500;
            display: block;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 15px 20px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.95);
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .form-input::placeholder {
            color: #999;
            opacity: 0.7;
        }

        .login-button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 12px;
            color: white;
            background: linear-gradient(135deg, #3498db, #2980b9);
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
            margin-top: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .login-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            
        }

        .login-button:active {
            transform: translateY(-1px);
        }

        .forgot-password {
            text-align: center;
            margin-top: 20px;
            position: relative;
            z-index: 1;
        }

        .forgot-password a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: white;
            text-decoration: underline;
        }

        .message {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            font-weight: 500;
            position: relative;
            z-index: 1;
            display: none;
        }

        .message.success {
            background: rgba(46, 204, 113, 0.2);
            border: 1px solid rgba(46, 204, 113, 0.5);
            color: #27ae60;
        }

        .message.error {
            background: rgba(231, 76, 60, 0.2);
            border: 1px solid rgba(231, 76, 60, 0.5);
            color: #e74c3c;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
                margin: 10px;
            }
            
            .login-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    
    <div class="login-container">
        <h1 class="login-title">Login</h1>
        
        <!-- id="loginForm"> -->
        <form action="/login" method="post" >
             @csrf
            <div class="form-group">
                <label for="matricula" class="form-label">Matrícula</label>
                <input 
                    type="text" 
                    id="matricula" 
                    name="matricula" 
                    class="form-input" 
                    placeholder="Digite sua matrícula"
                    required
                >
            </div>
            
            <div class="form-group">
                <label for="senha" class="form-label">Senha</label>
                <input 
                    type="password" 
                    id="senha" 
                    name="senha" 
                    class="form-input" 
                    placeholder="Digite sua senha"
                    required
                >
            </div>
            
            <button type="submit" class="login-button" id="loginBtn">
                Entrar
            </button>
            
            <div class="forgot-password">
                <a href="#" onclick="showForgotPassword()">Esqueci minha senha</a>
            </div>
            
            <div id="message" class="message"></div>
        </form>
    </div>
    <script>
        // Função para simular login
        function handleLogin(event) {
            event.preventDefault();
            
            const matricula = document.getElementById('matricula').value;
            const senha = document.getElementById('senha').value;
            const messageDiv = document.getElementById('message');
            const loginBtn = document.getElementById('loginBtn');
            
            // Validação básica
            if (!matricula || !senha) {
                showMessage('Por favor, preencha todos os campos!', 'error');
                return;
            }
            
            // Animação do botão durante o "carregamento"
            loginBtn.innerHTML = 'Entrando...';
            loginBtn.disabled = true;
            
            // Simular uma requisição de login (substituir por sua lógica real)
            setTimeout(() => {
                // Exemplo de validação simples (substituir por sua lógica)
                if (matricula === 'admin' && senha === '123456') {
                    showMessage('Login realizado com sucesso! Redirecionando...', 'success');
                    
                    // Redirecionar após 2 segundos (substituir pela sua lógica)
                    setTimeout(() => {
                        // window.location.href = '/dashboard'; // Uncomment para redirecionar
                        alert('Redirecionando para o dashboard...');
                    }, 2000);
                } else {
                    showMessage('Matrícula ou senha incorretos. Tente novamente.', 'error');
                }
                
                // Restaurar botão
                loginBtn.innerHTML = 'Entrar';
                loginBtn.disabled = false;
            }, 1500);
        }
        
        // Função para exibir mensagens
        function showMessage(text, type) {
            const messageDiv = document.getElementById('message');
            messageDiv.textContent = text;
            messageDiv.className = `message ${type}`;
            messageDiv.style.display = 'block';
            
            // Ocultar mensagem após 5 segundos
            setTimeout(() => {
                messageDiv.style.display = 'none';
            }, 5000);
        }
        
        // Função para "esqueci minha senha"
        function showForgotPassword() {
            alert('Funcionalidade "Esqueci minha senha" seria implementada aqui.\n\nEntre em contato com o suporte ou administrador do sistema.');
        }
        
        // Event listeners
        document.getElementById('loginForm').addEventListener('submit', handleLogin);
        
        // Permitir login com Enter
        document.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                const form = document.getElementById('loginForm');
                if (form.checkValidity()) {
                    handleLogin(event);
                }
            }
        });
        
        // Efeito de foco nos inputs
        const inputs = document.querySelectorAll('.form-input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
        
        // Para demonstração: mostrar credenciais de teste
        console.log('=== CREDENCIAIS DE TESTE ===');
        console.log('Matrícula: admin');
        console.log('Senha: 123456');
        console.log('===========================');
    </script>
    
</body>
</html>