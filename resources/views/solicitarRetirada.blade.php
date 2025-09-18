<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conecta Farmácia</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #2196F3, #1976D2);
            min-height: 100vh;
        }

        .top-bar {
            background: rgba(0, 0, 0, 0.3);
            color: white;
            padding: 10px 20px;
            font-size: 14px;
            text-align: center;
            position: relative;
        }

        .escape-btn {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: 2px solid white;
            color: white;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        .header {
            background: linear-gradient(135deg, #2196F3, #1976D2);
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
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
            color: #2196F3;
            font-size: 20px;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
        }

        .salvador {
            font-size: 18px;
            font-weight: bold;
        }

        .prefeitura {
            font-size: 12px;
            font-weight: normal;
        }

        .conecta-farmacia {
            font-size: 28px;
            font-weight: bold;
        }

        .pill-icon {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
            margin-left: 10px;
        }

        .main-container {
            display: flex;
            background: white;
            min-height: calc(100vh - 140px);
        }

        .search-section {
            flex: 1;
            padding: 40px;
            background: white;
        }

        .search-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 30px;
        }

        .search-container {
            position: relative;
            margin-bottom: 20px;
        }

        .search-input {
            width: 100%;
            padding: 15px 20px;
            font-size: 16px;
            border: 2px solid #ddd;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.3s;
        }

        .search-input:focus {
            border-color: #2196F3;
        }

        .search-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: #2196F3;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        .search-btn:hover {
            background: #1976D2;
        }

        .suggestions {
            border: 2px solid #ddd;
            border-top: none;
            border-radius: 0 0 8px 8px;
            background: white;
            max-height: 200px;
            overflow-y: auto;
        }

        .suggestion-item {
            padding: 12px 20px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }

        .suggestion-item:hover {
            background: #f5f5f5;
        }

        .suggestion-item:last-child {
            border-bottom: none;
        }

        .divider {
            width: 2px;
            background: linear-gradient(to bottom, transparent, #ddd, transparent);
        }

        .pickup-section {
            width: 400px;
            padding: 40px;
            background: #f8f9fa;
        }

        .pickup-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .pickup-subtitle {
            color: #e74c3c;
            font-size: 14px;
            margin-bottom: 30px;
            text-align: center;
        }

        .medication-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #ddd;
        }

        .medication-item:last-child {
            border-bottom: none;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            border: 2px solid #333;
            background: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            border-radius: 4px;
        }

        .quantity-btn:hover {
            background: #f0f0f0;
        }

        .quantity {
            font-size: 18px;
            font-weight: bold;
            min-width: 20px;
            text-align: center;
        }

        .medication-name {
            font-size: 16px;
            font-weight: 500;
            color: #333;
        }

        .search-final-btn {
            width: 100%;
            padding: 15px;
            background: #1abc9c;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 30px;
        }

        .search-final-btn:hover {
            background: #16a085;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        www.canva.com – Para sair do modo tela cheia, pressione
        <button class="escape-btn">Esc</button>
    </div>

    <header class="header">
        <div class="logo-section">
            <div class="logo">⚕</div>
            <div class="logo-text">
                <div class="salvador">SALVADOR</div>
                <div class="prefeitura">PREFEITURA</div>
            </div>
        </div>
        <div class="conecta-farmacia">
            Conecta farmácia 💊
        </div>
    </header>

    <div class="main-container">
        <div class="search-section">
            <h2 class="search-title">Digite o nome do medicamento</h2>
            
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Ex: Dipirona" id="medicationInput">
                <button class="search-btn" onclick="addMedication()">Adicionar</button>
                
                <div class="suggestions" id="suggestions" style="display: none;">
                    <div class="suggestion-item" onclick="selectSuggestion('Dipirona 500mg')">Dipirona 500mg</div>
                    <div class="suggestion-item" onclick="selectSuggestion('Dipirona 1g')">Dipirona 1g</div>
                    <div class="suggestion-item" onclick="selectSuggestion('Buscopan')">Buscopan</div>
                    <div class="suggestion-item" onclick="selectSuggestion('Nimesulida')">Nimesulida</div>
                    <div class="suggestion-item" onclick="selectSuggestion('Amitriptilina')">Amitriptilina</div>
                </div>
            </div>
        </div>

        <div class="divider"></div>

        <div class="pickup-section">
            <h2 class="pickup-title">Medicamentos para retirada</h2>
            <p class="pickup-subtitle">Atenção coloque apenas a quantidade<br>que consta na receita</p>
            
            <div id="medicationList">
                <div class="medication-item">
                    <div class="quantity-controls">
                        <button class="quantity-btn" onclick="changeQuantity(0, -1)">-</button>
                        <span class="quantity">1</span>
                        <button class="quantity-btn" onclick="changeQuantity(0, 1)">+</button>
                    </div>
                    <div class="medication-name">Buscopan</div>
                </div>

                <div class="medication-item">
                    <div class="quantity-controls">
                        <button class="quantity-btn" onclick="changeQuantity(1, -1)">-</button>
                        <span class="quantity">3</span>
                        <button class="quantity-btn" onclick="changeQuantity(1, 1)">+</button>
                    </div>
                    <div class="medication-name">Nimesulida</div>
                </div>
            </div>

            <button class="search-final-btn">Buscar</button>
        </div>
    </div>

    <script>
        let medications = [
            { name: 'Buscopan', quantity: 1 },
            { name: 'Nimesulida', quantity: 3 }
        ];

        const medicationInput = document.getElementById('medicationInput');
        const suggestions = document.getElementById('suggestions');

        medicationInput.addEventListener('input', function() {
            if (this.value.length > 0) {
                suggestions.style.display = 'block';
            } else {
                suggestions.style.display = 'none';
            }
        });

        medicationInput.addEventListener('blur', function() {
            setTimeout(() => {
                suggestions.style.display = 'none';
            }, 200);
        });

        function selectSuggestion(medication) {
            medicationInput.value = medication;
            suggestions.style.display = 'none';
        }

        function addMedication() {
            const medicationName = medicationInput.value.trim();
            if (medicationName) {
                // Check if medication already exists
                const existingIndex = medications.findIndex(med => med.name.toLowerCase() === medicationName.toLowerCase());
                
                if (existingIndex >= 0) {
                    medications[existingIndex].quantity += 1;
                } else {
                    medications.push({ name: medicationName, quantity: 1 });
                }
                
                renderMedicationList();
                medicationInput.value = '';
            }
        }

        function changeQuantity(index, change) {
            medications[index].quantity = Math.max(0, medications[index].quantity + change);
            if (medications[index].quantity === 0) {
                medications.splice(index, 1);
            }
            renderMedicationList();
        }

        function renderMedicationList() {
            const medicationList = document.getElementById('medicationList');
            medicationList.innerHTML = medications.map((med, index) => `
                <div class="medication-item">
                    <div class="quantity-controls">
                        <button class="quantity-btn" onclick="changeQuantity(${index}, -1)">-</button>
                        <span class="quantity">${med.quantity}</span>
                        <button class="quantity-btn" onclick="changeQuantity(${index}, 1)">+</button>
                    </div>
                    <div class="medication-name">${med.name}</div>
                </div>
            `).join('');
        }

        // Allow Enter key to add medication
        medicationInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                addMedication();
            }
        });
    </script>
</body>
</html>