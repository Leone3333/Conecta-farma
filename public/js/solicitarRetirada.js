
let medications = [];

const medicationInput = document.getElementById('medicationInput');
const suggestions = document.getElementById('suggestions');
const medicationList = document.getElementById('medicationList');

// Adiciona um evento de input para filtrar as sugestões em tempo real
medicationInput.addEventListener('input', function () {
    const searchTerm = this.value.toLowerCase();
    const suggestionItems = suggestions.querySelectorAll('.suggestion-item');
    let hasMatch = false;

    suggestionItems.forEach(item => {
        const medicationName = item.textContent.toLowerCase();
        if (medicationName.includes(searchTerm)) {
            item.style.display = 'block';
            hasMatch = true;
        } else {
            item.style.display = 'none';
        }
    });

    if (searchTerm.length > 0 && hasMatch) {
        suggestions.style.display = 'block';
    } else {
        suggestions.style.display = 'none';
    }
});

// Adiciona um evento de foco para exibir todas as sugestões quando o usuário clica no campo
medicationInput.addEventListener('focus', function () {
    const suggestionItems = suggestions.querySelectorAll('.suggestion-item');
    suggestionItems.forEach(item => {
        item.style.display = 'block';
    });
    suggestions.style.display = 'block';
});

medicationInput.addEventListener('blur', function () {
    setTimeout(() => {
        suggestions.style.display = 'none';
    }, 200);
});

// Permite a tecla Enter para adicionar o medicamento
medicationInput.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        const medicationName = medicationInput.value.trim();
        if (medicationName) {
            addMedication({ name: medicationName });
        }
    }
});

// Função chamada ao clicar em uma sugestão
function selectSuggestion(element) {
    const medicationName = element.getAttribute('data-nome');
    const medicationId = element.getAttribute('data-id');

    // Passa o ID e o nome para a função de adicionar
    addMedication({ name: medicationName, id: medicationId });
    suggestions.style.display = 'none';
    medicationInput.value = '';
}

// Função principal para adicionar um medicamento à lista
function addMedication(medication) {
    let existingMedication;

    // Verifica se o medicamento já existe (por ID ou nome)
    if (medication.id) {
        existingMedication = medications.find(med => med.id === medication.id);
    } else {
        existingMedication = medications.find(med => med.name.toLowerCase() === medication.name.toLowerCase());
    }

    if (existingMedication) {
        existingMedication.quantity += 1;
    } else {
        // Se não tiver ID, adicione um novo objeto com quantidade
        if (!medication.id) {
            medications.push({ name: medication.name, quantity: 1 });
        } else {
            // Adiciona um novo objeto com ID e quantidade
            medications.push({ name: medication.name, id: medication.id, quantity: 1 });
        }
    }
    renderMedicationList();
}

// Função para alterar a quantidade de um item na lista
function changeQuantity(index, change) {
    medications[index].quantity = Math.max(0, medications[index].quantity + change);
    if (medications[index].quantity === 0) {
        medications.splice(index, 1);
    }
    renderMedicationList();
}

// Função que renderiza a lista de medicamentos e cria os inputs ocultos
function renderMedicationList() {
    // Limpa a lista antes de renderizar para evitar duplicações
    medicationList.innerHTML = '';

    medications.forEach((med, index) => {
        const medicationItem = document.createElement('div');
        medicationItem.className = 'medication-item';

        medicationItem.innerHTML = `
                <div class="quantity-controls">
                    <button class="quantity-btn" onclick="changeQuantity(${index}, -1)">-</button>
                    <span class="quantity">${med.quantity}</span>
                    <button class="quantity-btn" onclick="changeQuantity(${index}, 1)">+</button>
                </div>
                <div class="medication-name">${med.name}</div>
            `;

        // Cria e adiciona o campo oculto para o NOME
        const nameInput = document.createElement('input');
        nameInput.type = 'hidden';
        nameInput.name = `medicamentos[${index}][nome]`;
        nameInput.value = med.name;
        medicationItem.appendChild(nameInput);

        // Cria e adiciona o campo oculto para o ID, se existir
        const idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = `medicamentos[${index}][id]`;
        idInput.value = med.id;
        medicationItem.appendChild(idInput);

        // Cria e adiciona o campo oculto para a QUANTIDADE
        const quantityInput = document.createElement('input');
        quantityInput.type = 'hidden';
        quantityInput.name = `medicamentos[${index}][quantidade]`;
        quantityInput.value = med.quantity;
        medicationItem.appendChild(quantityInput);

        // Adiciona o item à lista principal
        medicationList.appendChild(medicationItem);
    });
}
