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
            font-family: Arial, sans-serif;
        }

        body {
            background: linear-gradient(to bottom, #e6f3f7 0%, #f0f8fa 100%);
            min-height: 100vh;
        }

        .header {
            background: #1f5582;
            padding: 15px 30px;
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
            background: white;
            color: #1f5582;
            width: 60px;
            height: 60px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 24px;
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

        .prefecture {
            font-size: 12px;
            opacity: 0.9;
        }

        .title-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .title-text {
            font-size: 24px;
            font-weight: bold;
        }

        .pharmacy-icon {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .main-content {
            padding: 40px 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .search-title {
            font-size: 20px;
            color: #333;
            margin-bottom: 20px;
            font-weight: normal;
        }

        .search-container {
            position: relative;
            margin-bottom: 40px;
        }

        .search-input {
            width: 400px;
            max-width: 100%;
            padding: 15px 50px 15px 20px;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            background: white;
        }

        .search-input:focus {
            outline: none;
            border-color: #1f5582;
        }

        .search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 30px;
            height: 30px;
            background: #666;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
        }

        .results-container {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            justify-content: flex-start;
        }

        .health-post {
            background: white;
            border: 3px solid #17a2b8;
            border-radius: 15px;
            padding: 25px;
            width: 280px;
            min-height: 180px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .post-title {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .post-address {
            font-size: 13px;
            color: #333;
            margin-bottom: 15px;
            line-height: 1.3;
        }

        .post-phone {
            font-size: 13px;
            color: #333;
            font-weight: bold;
        }

        .btn-solicitar_retirar {
            /* Aparência Básica */
            display: block;
            /* Garante que ocupe a largura total */
            width: 100%;
            padding: 10px;

            /* Cores e Borda */
            background-color: #17a2b8;
            /* Cor que combina com a borda do card */
            color: white;
            border: none;
            border-radius: 8px;

            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;

            /* Efeitos de Interação */
            cursor: pointer;
            transition: background-color 0.2s ease;
            margin-top: 15px;
            /* Adiciona um espaço acima do botão, separando-o do telefone */
        }

        /* Efeito de hover */
        .btn-solicitar_retirar:hover {
            background-color: #137989;
            /* Um tom um pouco mais escuro ao passar o mouse */
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .results-container {
                justify-content: center;
            }

            .search-input {
                width: 100%;
            }

            .health-post {
                width: 100%;
                max-width: 350px;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="logo-section">
            <div class="logo">V</div>
            <div class="city-info">
                <div class="city-name">SALVADOR</div>
                <div class="prefecture">PREFEITURA</div>
            </div>
        </div>
        <div class="title-section">
            <div class="title-text">Conecta farmácia</div>
            <div class="pharmacy-icon">💊</div>
        </div>
    </header>

    <main class="main-content">
        <h1 class="search-title">Digite UBS ou USF e o nome do posto</h1>

        <div class="search-container">
            <input type="text" class="search-input" placeholder="Ex: UBS SAO GONCALO" id="searchInput">
        </div>

        <div class="results-container" id="resultsContainer">
            @if ($postosLotesDisponiveis->isEmpty())

                <div class="alert alert-warning" role="alert">
                    Nenhum posto encontrado que possua todos os medicamentos solicitados.
                </div>
            @else
                @foreach($postosLotesDisponiveis as $posto)

                    <form action='/postoEscolhido' method="post">
                        @csrf

                        <div class="health-post">
                            <!-- CARD COM INFORMAÇÕES DO POSTO -->
                            <div class="post-title">Posto de saúde: {{$posto['nome']}}</div>
                            <div class="post-address">Endereço: {{$posto['endereco']}}</div>
                            <div class="post-phone">Telefone: {{$posto['telefone'] ?? 'Sem telefone'}}</div>

                            <!-- DADOS PARA CONFIRMAR RETIRADA -->
                            <!-- ID DO POSTO ESCOLHIDO -->

                            <input type="hidden" name="idPosto" value="{{ $posto['idPostoFK'] }}">

                            <!-- DADOS DO LOTE A SER RETIRADO E DA SOLICITAÇÃO-->
                            @foreach($posto['loteRetirada'] as $index => $lote)
                                @php
                                    $idMedicamento = $lote['idMedicamento'];

                                @endphp

                                {{-- id medicamento --}}
                                <input type="hidden" name="lotes_retirada[{{ $idMedicamento  }}][{{ $index }}][idMedicamento]"
                                    value="{{ $lote['idMedicamento'] }}">

                                {{-- Número do Lote --}}
                                <input type="hidden" name="lotes_retirada[{{ $idMedicamento  }}][{{ $index }}][lote]"
                                    value="{{ $lote['lote'] }}">

                                <!-- Quantidade a ser consumida neste lote específico -->
                                <input type="hidden"
                                    name="lotes_retirada[{{ $idMedicamento  }}][{{ $index }}][saldoUsadoParaRetirada]"
                                    value="{{ $lote['saldoUsadoParaRetirada'] }}">

                                <input type="hidden" name="lotes_retirada[{{ $idMedicamento  }}][{{ $index }}][data_entrada]"
                                    value="{{ $lote['data_entrada'] }}">


                            @endforeach
                            <button class="btn btn-solicitar_retirar">Retirar</button>
                        </div>
                    </form>
                @endforeach
            @endif
        </div>
    </main>

    <script>

        const searchInput = document.getElementById('searchInput');
        const resultsContainer = document.getElementById('resultsContainer');

        // Coleção de todos os cards de postos (health-post)
        const healthPostCards = resultsContainer.querySelectorAll('.health-post');

        function performSearch() {
            const searchTerm = searchInput.value.toLowerCase().trim();

            healthPostCards.forEach(postCard => {
                // Obtém o texto relevante para busca do card
                // Você precisa adaptar as classes conforme seu Blade
                const postName = postCard.querySelector('.post-title').textContent.toLowerCase();
                const postAddress = postCard.querySelector('.post-address').textContent.toLowerCase();

                // Verifica se o termo de busca está no nome OU no endereço
                if (postName.includes(searchTerm) || postAddress.includes(searchTerm)) {
                    postCard.style.display = 'block'; // Mostra o card
                } else {
                    postCard.style.display = 'none'; // Esconde o card
                }
            });
        }

        // Busca ao pressionar Enter
        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });

        // Busca em tempo real enquanto digita
        searchInput.addEventListener('input', function () {
            performSearch();
        });

        // Opcional: Se o campo estiver vazio ao carregar, mostra todos os resultados
        window.addEventListener('load', function () {
            if (!searchInput.value.trim()) {
                healthPostCards.forEach(card => card.style.display = 'block');
            }
        });
    </script>
</body>

</html>