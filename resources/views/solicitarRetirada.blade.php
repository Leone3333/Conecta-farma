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
            border-bottom: 1px solid #eeeeeeff;
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
                    @foreach($medicamentos as $medicamento)
                        <div class="suggestion-item" onclick="selectSuggestion('{{ $medicamento['nome'] }}')">
                            {{$medicamento['nome']}}
                        </div>
                    @endforeach
                    <!-- <div class="suggestion-item" onclick="selectSuggestion('Dipirona 1g')">Dipirona 1g</div>
                    <div class="suggestion-item" onclick="selectSuggestion('Buscopan')">Buscopan</div>
                    <div class="suggestion-item" onclick="selectSuggestion('Nimesulida')">Nimesulida</div>
                    <div class="suggestion-item" onclick="selectSuggestion('Amitriptilina')">Amitriptilina</div> -->
                </div>
            </div>
        </div>

        <div class="divider"></div>

        <div class="pickup-section">
            <h2 class="pickup-title">Medicamentos para retirada</h2>
            <p class="pickup-subtitle">Atenção coloque apenas a quantidade<br>que consta na receita</p>

            <form action="/solicitar" method="post">
            @csrf
                <div id="medicationList">
                    
                </div>
                <button class="search-final-btn">Buscar</button>
            </form>
        </div>
    </div>

    <script>
        let medications = [];

        const medicationInput = document.getElementById('medicationInput');
        const suggestions = document.getElementById('suggestions');

        // Adiciona um evento de input para filtrar as sugestões em tempo real
        medicationInput.addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();

            // Filtra os itens de sugestão para mostrar apenas os que correspondem
            const suggestionItems = suggestions.querySelectorAll('.suggestion-item');
            let hasMatch = false;

            suggestionItems.forEach(item => {
                const medicationName = item.textContent.toLowerCase();
                if (medicationName.includes(searchTerm)) {
                    item.style.display = 'block'; // Exibe o item
                    hasMatch = true;
                } else {
                    item.style.display = 'none'; // Esconde o item
                }
            });

            // Exibe ou esconde a caixa de sugestões com base na entrada e nos resultados
            if (searchTerm.length > 0 && hasMatch) {
                suggestions.style.display = 'block';
            } else {
                suggestions.style.display = 'none';
            }
        });

        // NOVO: Adiciona um evento de foco para exibir todas as sugestões quando o usuário clica no campo
        medicationInput.addEventListener('focus', function () {
            const suggestionItems = suggestions.querySelectorAll('.suggestion-item');
            suggestionItems.forEach(item => {
                item.style.display = 'block'; // Exibe todos os itens
            });
            suggestions.style.display = 'block'; // Exibe a caixa de sugestões
        });

        medicationInput.addEventListener('blur', function () {
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
                // Verifica se o medicamento já existe
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

        // Permite a tecla Enter para adicionar o medicamento
        medicationInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                addMedication();
            }
        });

        function renderMedicationList() {
    const medicationList = document.getElementById('medicationList');
    
    // Limpa a lista antes de renderizar para evitar duplicações
    medicationList.innerHTML = '';

    medications.forEach((med, index) => {
        // Cria a div de exibição do medicamento
        const medicationItem = document.createElement('div');
        medicationItem.className = 'medication-item';

        // Cria e adiciona a div com os controles de quantidade
        medicationItem.innerHTML = `
            <div class="quantity-controls">
                <button class="quantity-btn" onclick="changeQuantity(${index}, -1)">-</button>
                <span class="quantity">${med.quantity}</span>
                <button class="quantity-btn" onclick="changeQuantity(${index}, 1)">+</button>
            </div>
            <div class="medication-name">${med.name}</div>
        `;
        
        // --- AQUI ESTÁ A PARTE IMPORTANTE! ---
        // Cria um campo oculto para o nome do medicamento
        const nameInput = document.createElement('input');
        nameInput.type = 'hidden';
        nameInput.name = `medicamentos[${index}][nome]`;
        nameInput.value = med.name;

        // Cria um campo oculto para a quantidade do medicamento
        const quantityInput = document.createElement('input');
        quantityInput.type = 'hidden';
        quantityInput.name = `medicamentos[${index}][quantidade]`;
        quantityInput.value = med.quantity;
        
        // Adiciona os campos ocultos à div do medicamento
        medicationItem.appendChild(nameInput);
        medicationItem.appendChild(quantityInput);

        // Adiciona o item à lista principal
        medicationList.appendChild(medicationItem);
    });
}
    </script>
</body>

</html>