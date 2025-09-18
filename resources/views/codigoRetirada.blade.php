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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            min-height: 100vh;
        }

        .header {
            background: linear-gradient(135deg, #1e5fa8, #2980b9);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #2980b9;
            font-size: 12px;
            text-align: center;
            line-height: 1.2;
        }

        .city-info {
            display: flex;
            flex-direction: column;
        }

        .city-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .city-subtitle {
            font-size: 12px;
            opacity: 0.9;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .conecta-farmacia {
            font-size: 24px;
            font-weight: bold;
        }

        .pharmacy-icon {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .main-content {
            padding: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 600;
            color: #333;
        }

        .add-btn {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        }

        .add-btn::before {
            content: '+';
            font-size: 16px;
            font-weight: bold;
        }

        .codes-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .code-card {
            background: white;
            border: 3px solid #3498db;
            border-radius: 15px;
            padding: 25px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        .code-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3498db, #2980b9);
        }

        .code-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.2);
            border-color: #2980b9;
        }

        .code-number {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
            padding: 8px 12px;
            background: rgba(52, 152, 219, 0.1);
            border-radius: 8px;
            display: inline-block;
        }

        .medication-info {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .medication-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            background: #f8f9fa;
            border-radius: 6px;
            font-size: 14px;
        }

        .medication-name {
            font-weight: 500;
            color: #2c3e50;
        }

        .medication-quantity {
            background: #3498db;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            min-width: 20px;
            text-align: center;
        }

        .card-actions {
            position: absolute;
            top: 15px;
            right: 15px;
            display: flex;
            gap: 8px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .code-card:hover .card-actions {
            opacity: 1;
        }

        .action-btn {
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .edit-btn {
            background: #f39c12;
            color: white;
        }

        .delete-btn {
            background: #e74c3c;
            color: white;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 30px;
            border-radius: 15px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .modal-header {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #555;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #3498db;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .modal-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-save {
            background: #27ae60;
            color: white;
        }

        .btn-cancel {
            background: #95a5a6;
            color: white;
        }

        .modal-btn:hover {
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .main-content {
                padding: 20px;
            }

            .content-header {
                flex-direction: column;
                gap: 20px;
                align-items: stretch;
            }

            .codes-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo-section">
            <div class="logo">
                SALVADOR<br>PREFEITURA
            </div>
            <div class="city-info">
                <div class="city-name">SALVADOR</div>
                <div class="city-subtitle">PREFEITURA</div>
            </div>
        </div>
        <div class="header-right">
            <div class="conecta-farmacia">Conecta farmácia</div>
            <div class="pharmacy-icon">💊</div>
        </div>
    </header>

    <main class="main-content">
        <div class="content-header">
            <h1 class="page-title">Lista dos códigos de retirada</h1>
            <button class="add-btn" onclick="openModal()">Adicionar medicamento</button>
        </div>

        <div class="codes-container" id="codesContainer">
            <div class="code-card">
                <div class="card-actions">
                    <button class="action-btn edit-btn" onclick="editCard(this)">✎</button>
                    <button class="action-btn delete-btn" onclick="deleteCard(this)">✕</button>
                </div>
                <div class="code-number">#C4U6777</div>
                <div class="medication-info">
                    <div class="medication-item">
                        <span class="medication-name">Buscopan</span>
                        <span class="medication-quantity">1</span>
                    </div>
                </div>
            </div>

            <div class="code-card">
                <div class="card-actions">
                    <button class="action-btn edit-btn" onclick="editCard(this)">✎</button>
                    <button class="action-btn delete-btn" onclick="deleteCard(this)">✕</button>
                </div>
                <div class="code-number">#BNU6777</div>
                <div class="medication-info">
                    <div class="medication-item">
                        <span class="medication-name">Buscopan</span>
                        <span class="medication-quantity">4</span>
                    </div>
                    <div class="medication-item">
                        <span class="medication-name">Dipirona</span>
                        <span class="medication-quantity">2</span>
                    </div>
                </div>
            </div>

            <div class="code-card">
                <div class="card-actions">
                    <button class="action-btn edit-btn" onclick="editCard(this)">✎</button>
                    <button class="action-btn delete-btn" onclick="deleteCard(this)">✕</button>
                </div>
                <div class="code-number">#YU89NG7</div>
                <div class="medication-info">
                    <div class="medication-item">
                        <span class="medication-name">Nimesulida</span>
                        <span class="medication-quantity">2</span>
                    </div>
                </div>
            </div>

            <div class="code-card">
                <div class="card-actions">
                    <button class="action-btn edit-btn" onclick="editCard(this)">✎</button>
                    <button class="action-btn delete-btn" onclick="deleteCard(this)">✕</button>
                </div>
                <div class="code-number">#CHT6009</div>
                <div class="medication-info">
                    <div class="medication-item">
                        <span class="medication-name">Imosec</span>
                        <span class="medication-quantity">6</span>
                    </div>
                    <div class="medication-item">
                        <span class="medication-name">Decongex</span>
                        <span class="medication-quantity">2</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal -->
    <div class="modal" id="medicationModal">
        <div class="modal-content">
            <div class="modal-header">Adicionar Novo Medicamento</div>
            <form id="medicationForm">
                <div class="form-group">
                    <label class="form-label">Código de Retirada</label>
                    <input type="text" class="form-input" id="codeInput" placeholder="Ex: #ABC1234" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Nome do Medicamento</label>
                    <input type="text" class="form-input" id="medicationInput" placeholder="Ex: Dipirona" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Lote</label>
                    <input type="text" class="form-input" id="medicationInput" placeholder="L45AB" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Quantidade</label>
                    <input type="number" class="form-input" id="quantityInput" min="1" placeholder="1" required>
                </div>
                <div class="modal-actions">
                    <button type="button" class="modal-btn btn-cancel" onclick="closeModal()">Cancelar</button>
                    <button type="submit" class="modal-btn btn-save">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let editingCard = null;

        function openModal() {
            document.getElementById('medicationModal').style.display = 'block';
            document.getElementById('medicationForm').reset();
            editingCard = null;
            document.querySelector('.modal-header').textContent = 'Adicionar Novo Medicamento';
        }

        function closeModal() {
            document.getElementById('medicationModal').style.display = 'none';
            editingCard = null;
        }

        function generateCode() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let code = '#';
            for (let i = 0; i < 7; i++) {
                code += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return code;
        }

        function createMedicationCard(code, medications) {
            const card = document.createElement('div');
            card.className = 'code-card';
            
            let medicationItems = '';
            medications.forEach(med => {
                medicationItems += `
                    <div class="medication-item">
                        <span class="medication-name">${med.name}</span>
                        <span class="medication-quantity">${med.quantity}</span>
                    </div>
                `;
            });

            card.innerHTML = `
                <div class="card-actions">
                    <button class="action-btn edit-btn" onclick="editCard(this)">✎</button>
                    <button class="action-btn delete-btn" onclick="deleteCard(this)">✕</button>
                </div>
                <div class="code-number">${code}</div>
                <div class="medication-info">
                    ${medicationItems}
                </div>
            `;

            return card;
        }

        function addMedication(code, medicationName, quantity) {
            const medications = [{name: medicationName, quantity: quantity}];
            const card = createMedicationCard(code, medications);
            
            // Add with animation
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            document.getElementById('codesContainer').appendChild(card);
            
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        }

        function editCard(button) {
            const card = button.closest('.code-card');
            const code = card.querySelector('.code-number').textContent;
            const firstMedication = card.querySelector('.medication-name').textContent;
            const firstQuantity = card.querySelector('.medication-quantity').textContent;
            
            document.getElementById('codeInput').value = code;
            document.getElementById('medicationInput').value = firstMedication;
            document.getElementById('quantityInput').value = firstQuantity;
            
            editingCard = card;
            document.querySelector('.modal-header').textContent = 'Editar Medicamento';
            document.getElementById('medicationModal').style.display = 'block';
        }

        function deleteCard(button) {
            const card = button.closest('.code-card');
            const code = card.querySelector('.code-number').textContent;
            
            if (confirm(`Tem certeza que deseja excluir o código ${code}?`)) {
                card.style.transition = 'all 0.3s ease';
                card.style.transform = 'scale(0.8)';
                card.style.opacity = '0';
                
                setTimeout(() => {
                    card.remove();
                }, 300);
            }
        }

        document.getElementById('medicationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const code = document.getElementById('codeInput').value || generateCode();
            const medicationName = document.getElementById('medicationInput').value;
            const quantity = document.getElementById('quantityInput').value;
            
            if (editingCard) {
                // Update existing card
                editingCard.querySelector('.code-number').textContent = code;
                editingCard.querySelector('.medication-name').textContent = medicationName;
                editingCard.querySelector('.medication-quantity').textContent = quantity;
                
                // Add update animation
                editingCard.style.transform = 'scale(1.05)';
                editingCard.style.background = 'rgba(52, 152, 219, 0.1)';
                setTimeout(() => {
                    editingCard.style.transform = 'scale(1)';
                    editingCard.style.background = 'white';
                }, 200);
            } else {
                // Add new card
                addMedication(code, medicationName, quantity);
            }
            
            closeModal();
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('medicationModal');
            if (e.target === modal) {
                closeModal();
            }
        });

        // Add some interactive animations
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.code-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 150);
            });
        });
    </script>
</body>
</html>