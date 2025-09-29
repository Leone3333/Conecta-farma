@extends('layouts.main')

@section('title', 'Busca postos')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/procurarUbs.css') }}">
@endsection

<body>
    @section('content')
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
    @endsection

    @section('scripts')
        <script src="{{ asset('js/procurarUbs.js') }}"></script>
    @endsection
</body>
</html>