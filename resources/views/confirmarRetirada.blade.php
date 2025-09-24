<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conecta Farmácia - Salvador</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #e8f4f8 0%, #d1e9f0 100%);
            min-height: 100vh;
        }

        .header {
            background: linear-gradient(135deg, #2980b9 0%, #3498db 100%);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #2980b9;
            font-size: 24px;
        }

        .city-info {
            display: flex;
            flex-direction: column;
        }

        .city-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .city-subtitle {
            font-size: 14px;
            opacity: 0.9;
        }

        .conecta-section {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .conecta-text {
            font-size: 22px;
            font-weight: bold;
        }

        .pharmacy-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            display: flex;
            gap: 40px;
            align-items: flex-start;
        }

        .main-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 3px solid #3498db;
            flex: 1;
            max-width: 500px;
        }

        .ubs-title {
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 30px;
            text-align: center;
        }

        .medications-section h3 {
            font-size: 20px;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .medication-list {
            list-style: none;
            margin-bottom: 40px;
        }

        .medication-item {
            background: #f8f9fa;
            padding: 12px 20px;
            margin-bottom: 10px;
            border-radius: 8px;
            border-left: 4px solid #3498db;
            font-size: 16px;
            color: #2c3e50;
            transition: all 0.3s ease;
        }

        .medication-item:hover {
            background: #e3f2fd;
            transform: translateX(5px);
        }

        .buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-cancel {
            background: #e74c3c;
            color: white;
        }

        .btn-cancel:hover {
            background: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        }

        .btn-request {
            background: #27ae60;
            color: white;
        }

        .btn-request:hover {
            background: #229954;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
        }

        .info-panel {
            flex: 1;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .info-title {
            color: #e74c3c;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .info-list {
            list-style: none;
        }

        .info-item {
            color: #e74c3c;
            font-size: 16px;
            margin-bottom: 12px;
            position: relative;
            padding-left: 20px;
        }

        .info-item::before {
            content: "•";
            position: absolute;
            left: 0;
            color: #e74c3c;
            font-weight: bold;
            font-size: 18px;
        }

        .success-message {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
            text-align: center;
            display: none;
        }

        .success-message > small{
            font-size: 18px;
        }
        .success-message > strong{
            font-size: 20px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s ease;
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 30px;
            border-radius: 15px;
            width: 90%;
            max-width: 500px;
            text-align: center;
            animation: slideIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                padding: 20px 10px;
            }

            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="logo-section">
            <div class="logo">⚕</div>
            <div class="city-info">
                <div class="city-name">SALVADOR</div>
                <div class="city-subtitle">PREFEITURA</div>
            </div>
        </div>
        <div class="conecta-section">
            <div>
                <div class="conecta-text">Conecta</div>
                <div class="conecta-text">farmácia</div>
            </div>
            <div class="pharmacy-icon">💊</div>
        </div>
    </header>

    <div class="container">
        <div class="main-card">
            <h2 class="ubs-title">UBS São Gonçalo</h2>


            <div class="medications-section">
                <h3>Medicamentos</h3>
                <ul class="medication-list">
                    <li class="medication-item">Dipirona: 1</li>
                    <li class="medication-item">Nimesulida: 3</li>
                </ul>
            </div>

            <div class="buttons">
                <button class="btn btn-cancel" onclick="cancelRequest()">Cancelar</button>
                <button class="btn btn-request" onclick="requestMedication()">Solicitar retirada</button>
            </div>


            <div class="success-message" id="successMessage">
                ✅ Solicitação enviada com sucesso! Você receberá uma confirmação em breve.
            </div>
        </div>

        <div class="info-panel">
            <div class="info-title">Importante!! Para retirada levar para unidade de saúde:</div>
            <ul class="info-list">
                <li class="info-item">RG</li>
                <li class="info-item">Cartão do SUS</li>
                <li class="info-item">Receita assinada por médico credenciado</li>
                <li class="info-item">Código único emitido pelo sistema</li>
            </ul>
        </div>
    </div>

    <!-- Modal de Confirmação -->
    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <h3 style="color: #2c3e50; margin-bottom: 20px;">Confirmar Solicitação</h3>
            <p style="margin-bottom: 20px; color: #7f8c8d;">Deseja realmente solicitar a retirada dos medicamentos?</p>
            <div style="display: flex; gap: 15px; justify-content: center;">
                <button class="btn" style="background: #95a5a6; color: white;" onclick="closeModal()">Não</button>
                <button class="btn" style="background: #27ae60; color: white;" onclick="confirmRequest()">Sim,
                    solicitar</button>
            </div>
        </div>
    </div>

    <!-- Modal de Cancelamento -->
    <div id="cancelModal" class="modal">
        <div class="modal-content">
            <h3 style="color: #e74c3c; margin-bottom: 20px;">Cancelar Solicitação</h3>
            <p style="margin-bottom: 20px; color: #7f8c8d;">Tem certeza que deseja cancelar esta solicitação?</p>
            <div style="display: flex; gap: 15px; justify-content: center;">
                <button class="btn" style="background: #95a5a6; color: white;" onclick="closeModal()">Não</button>
                <button class="btn btn-cancel" onclick="confirmCancel()">Sim, cancelar</button>
            </div>
        </div>
    </div>

    <script>
        function requestMedication() {
            document.getElementById('confirmModal').style.display = 'block';
        }

        function cancelRequest() {
            document.getElementById('cancelModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('confirmModal').style.display = 'none';
            document.getElementById('cancelModal').style.display = 'none';
        }

        function confirmRequest() {
            closeModal();
            console.log("teste");

            // Suponha que você pegou os dados do formulário ou da lista de medicamentos
            const requestData = {
                id_funcionarioFK: 2,
                id_postoFK: 2,
                itens: [
                    { id_medicamentoFK: 4, qtt_saida: 2, lote: 'L1234' },
                    { id_medicamentoFK: 5, qtt_saida: 1, lote: 'L5678' },
                ]
            };

            // Fazendo a requisição POST para o seu endpoint no Laravel
            fetch('/api/ConfirmarRetirada', { // Mude '/api/confirmar' para a sua rota
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(requestData)
            })
                .then(response => response.json())
                .then(data => {
                    // Verifica se a operação foi um sucesso
                    if (data.status === 'aprovado') {
                        const buttons = document.querySelector('.buttons');
                        const successMessage = document.getElementById('successMessage');

                        buttons.style.display = 'none';
                        successMessage.style.display = 'block';

                        // Usa o código retornado pelo backend
                        successMessage.innerHTML = `
                ✅ Solicitação enviada com sucesso!<br><br>
                <strong>Código único: ${data.codigo}</strong><br><br>
                <small>Apresente este código na unidade de saúde junto com os documentos.</small><br><br>
                <a href='/solicitar'><button class="btn btn-back">Sair</button></a>
            `;
                    } else {
                        // Lógica para lidar com erros
                        alert('Erro ao enviar solicitação: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Ocorreu um erro na requisição. Tente novamente.');
                });
        }

        function confirmCancel() {
            closeModal();

            // Simula o cancelamento
            alert('Solicitação cancelada com sucesso!');

            // Reset da interface
            const buttons = document.querySelector('.buttons');
            const successMessage = document.getElementById('successMessage');

            buttons.style.display = 'flex';
            successMessage.style.display = 'none';
        }

        // Fecha modal ao clicar fora dele
        window.onclick = function (event) {
            const confirmModal = document.getElementById('confirmModal');
            const cancelModal = document.getElementById('cancelModal');

            if (event.target == confirmModal || event.target == cancelModal) {
                closeModal();
            }
        }

        // Adiciona efeitos de hover aos itens de medicamentos
        document.addEventListener('DOMContentLoaded', function () {
            const medicationItems = document.querySelectorAll('.medication-item');

            medicationItems.forEach(item => {
                item.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateX(5px)';
                });

                item.addEventListener('mouseleave', function () {
                    this.style.transform = 'translateX(0)';
                });
            });
        });
    </script>
</body>

</html>