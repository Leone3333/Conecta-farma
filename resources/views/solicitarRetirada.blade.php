@extends('layouts.main')

@section('title', 'Solicitar retirada')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/solicitarRetirada.css') }}">
@endsection

<body>
    @section('content')

        <div class="main-container">
            <div class="search-section">
                <h2 class="search-title">Digite o nome do medicamento</h2>

                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Ex: Dipirona" id="medicationInput">

                    <div class="suggestions" id="suggestions" style="display: none;">

                        @foreach($medicamentos as $medicamento)

                            <div class="suggestion-item" data-id='{{ $medicamento['id_medicamento'] }}'
                                data-nome='{{ $medicamento['nome'] }}' onclick="selectSuggestion(this)">
                                {{$medicamento['nome']}}
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <div class="pickup-section">
                <h2 class="pickup-title">Medicamentos para retirada</h2>
                <p class="pickup-subtitle">Atenção coloque apenas a quantidade<br>que consta na receita</p>

                @if (session('error'))
                    <p class="pickup-subtitle"><br>{{session('error')}}</p>
                @endif
                <form action="/solicitar" method="post">
                    @csrf
                    <div id="medicationList">

                    </div>
                    <button class="search-final-btn">Buscar</button>
                </form>
            </div>
        </div>
    @endsection


    @section('scripts')
        <script src="{{ asset('js/solicitarRetirada.js') }}"></script>
    @endsection
</body>

</html>