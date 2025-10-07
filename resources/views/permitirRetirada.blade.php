<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo Funcionários - Permitir Retirada</title>

    {{--
    *********************************************************
    BLOCO DE ESTILOS (CSS)
    *********************************************************
    --}}
    <style>
        /* Variáveis de cores (ajuste conforme a identidade da Prefeitura) */
        :root {
            --cor-primaria: #007bff;
            /* Azul */
            --cor-fundo: #f4f7f9;
            --cor-sucesso: #28a745;
            /* Verde */
            --cor-erro: #dc3545;
            /* Vermelho */
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--cor-fundo);
            min-height: 100vh;
        }

        /* Header (Simulação do cabeçalho da Prefeitura) */
        .app-header {
            background-color: var(--cor-primaria);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.2rem;
        }

        /* Estilos Gerais do Card */
        .retirada-container {
            display: flex;
            justify-content: center;
            padding: 40px 20px;
        }

        .retirada-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 600px;
        }

        .solicitacao-titulo {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 600;
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
        }

        /* Estilos da Tabela */
        .medicamentos-tabela {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .medicamentos-tabela th,
        .medicamentos-tabela td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #dee2e6;
            /* Linhas internas */
        }

        .medicamentos-tabela th {
            background-color: #e9ecef;
            color: #495057;
            font-weight: 600;
        }

        /* Estilos das Ações (Botões) */
        .td-acoes {
            text-align: center;
            width: 80px;
            /* Largura fixa para a coluna de ações */
            white-space: nowrap;
        }

        .btns{
            display:flex;
            justify-content: end;
            width:100%;
            padding:12px;
            gap:10px;
        }

        .btn-acao {
            border: none;
            background: none;
            cursor: pointer;
            font-size: 1.5rem;
            margin: 0 5px;
            transition: transform 0.2s, opacity 0.3s;
            padding: 0;
            line-height: 1;
        }

        .btn-acao:hover:not(:disabled) {
            transform: scale(1.15);
        }

        .btn-acao:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-rejeitar .icone-acao {
            color: var(--cor-erro);
        }

        .btn-aprovar .icone-acao {
            color: var(--cor-sucesso);
        }

        /* Estilo do Alerta de Status */
        .alerta-status {
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            margin-top: 20px;
            display: none;
            /* Inicia escondido */
        }

        .alerta-status.sucesso {
            background-color: #d4edda;
            color: #155724;
        }

        .alerta-status.erro {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>

    {{--
    *********************************************************
    BLOCO DE HTML (BLADE)
    *********************************************************
    --}}
    <header class="app-header">
        <div>SALVADOR PREFEITURA</div>
        <div>Conecta farmácia 💊</div>
    </header>

    <div class="retirada-container">
        <div class="retirada-card">

            {{-- Simulação de dados do Laravel
            @php
            // Simulação dos dados que viriam do Controller
            $solicitacao = (object)[
            'id' => 123,
            'codigo_unico' => 'C4U6777',
            'itens' => [
            (object)['id' => 101, 'nome_medicamento' => 'Buscopan', 'quantidade_solicitada' => 1],
            (object)['id' => 102, 'nome_medicamento' => 'Nimesulida', 'quantidade_solicitada' => 3],
            ]
            ];
            // Rota de exemplo (no Laravel isso viria de route('api.confirmar_acao_funcionario'))
            $rota_api = '/api/processar_acao_funcionario';
            @endphp
            --}}
           
            <h2 class="solicitacao-titulo">Permitir retirada {{$dataRetirada->cod_saida}}</h2>

            <table class="medicamentos-tabela">
                <thead>
                    <tr>
                        <th>Medicamento</th>
                        <th>Quantidade</th>
                    </tr>
                </thead>
                <tbody id="itensTabela">
                   
                    @foreach($dataItensRetirada as $listaItens)
                    <tr>
                        <td>{{$listaItens->nome}}</td>
                        <td>{{$listaItens->qtt_saida}}</td>
                    </tr>
                    @endforeach()
                </tbody>
            </table>

            <p class="alerta-status" id="alertaStatus"></p>

            <div class="btns">

                <form action="/" method="post">
                    <input type="hidden" name="retirada" value="">
                    <input type="hidden" name="status" value="Negado">
                    
                    <button class="btn-acao btn-rejeitar" onclick="confirmarAcao('rejeitar')" title="Rejeitar Retirada">
                        <i class="icone-acao">❌</i>
                    </button>
                </form>
                
                <form action="/" method="post">
                    <input type="hidden" name="retirada" value="">
                    <input type="hidden" name="status" value="Permitida">
                    
                    <button class="btn-acao btn-aprovar" onclick="confirmarAcao('aprovar')" title="Confirmar Retirada">
                        <i class="icone-acao">✔️</i>
                    </button>
                </form>
            </div>
        </div>

    </div>


    {{--
    *********************************************************
    BLOCO DE JAVASCRIPT
    *********************************************************
    --}}
    <script>
        // Variáveis globais INJETADAS pelo Blade (simuladas aqui)
        // const API_URL_ACAO = "$rota_api "; URL para onde o fetch vai
        // const SOLICITACAO_ID = "$solicitacao->id "; ID da solicitação principal

    </script>
</body>

</html>