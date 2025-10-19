
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

    // 1. Acessa os dados injetados pelo Blade
    const postoIdElement = document.getElementById('posto-id');
    const codigoIdElement = document.getElementById('codigo');
    const lotesDataElement = document.getElementById('lotes-data');
    // console.log(lotesDataElement);

    // 2. Extrai o ID do Posto e do codigo da retirada converte a string JSON de Lotes de volta para Objeto JS
    const idPosto = postoIdElement.value;
    const codigo = codigoIdElement.value;

    // JSON.parse() converte a string JSON em objeto/array JavaScript
    const lotesRetirada = JSON.parse(lotesDataElement.dataset.lotes);
    console.log(lotesRetirada);

    // 3. Monta a estrutura de dados esperada pelo seu Controller
    const requestData = {

        idPosto: idPosto,
        codigo: codigo,

        // Passa a lista de lotes diretamente. 
        // Lembre-se que esta estrutura deve bater com o que o Controller ConfirmarSoliController está processando.
        lotes_retirada: lotesRetirada
    };

    // Fazendo a requisição POST para o seu endpoint no Laravel
    fetch(API_URL, { 
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
                <a href='/'><button class="btn btn-back">Sair</button></a>
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
