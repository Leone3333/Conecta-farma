@extends('layouts.main')

@section('title', 'Conecta farmácia - Salvador')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/confirmarRetirada.css') }}">
@endsection

<script>
    const API_URL = "{{ route('api.confirmarRetirada') }}";
</script>
</head>

<body>
    @section('content')
        <div id="app-data" data-api-url="{{ route('api.confirmarRetirada') }}">
        </div>
        <div class="container">
            <div class="main-card">
                <h2 class="ubs-title">{{$nomePosto}}</h2>

                <input type="hidden" id="posto-id" value="{{ $idPosto }}">
                <input type="hidden" id="codigo" value="{{ $codigo }}">

                <div id="lotes-data" data-lotes="{{ json_encode($lotes) }}"></div>

                <div class="medications-section">
                    <h3>Medicamentos</h3>
                    <ul class="medication-list">
                        @foreach ($lotes as $retirada)
                            <li class="medication-item">{{$retirada['nomeMedicamento']}}:
                                {{$retirada['saldoUsadoParaRetirada']}}
                            </li>
                        @endforeach
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
                    <button class="btn btn-cancel" onclick="confirmCancel()"><a href="/solicitar">Sim, cancelar</a></button>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')

        <script src="{{ asset('js/confirmarRetirada.js') }}"></script>
    @endsection
</body>

</html>