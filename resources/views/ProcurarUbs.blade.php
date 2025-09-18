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
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
            <div class="search-icon" onclick="performSearch()">🔍</div>
        </div>

        <div class="results-container" id="resultsContainer">
            <div class="health-post">
                <div>
                    <div class="post-title">Posto de saúde: UBS SAO GONCALO</div>
                    <div class="post-address">Endereço: AVENIDA CARDEAL DA SILVA - 789, FEDERACAO</div>
                </div>
                <div class="post-phone">Telefone: (71)3611-1340</div>
            </div>

            <div class="health-post">
                <div>
                    <div class="post-title">Posto de saúde: USF PROF EDUARDO MAMEDE</div>
                    <div class="post-address">Endereço: SETOR E CAMINHO 16 - S/N, MUSSURUNGA I</div>
                </div>
                <div class="post-phone">Telefone: (71) 36112962</div>
            </div>

            <div class="health-post">
                <div>
                    <div class="post-title">Posto de saúde: USF BOA VISTA DE SAO CAETANO</div>
                    <div class="post-address">Endereço: RUA RODOVIA A - S/N, BOA VISTA DE SAO CAE</div>
                </div>
                <div class="post-phone">Telefone: (71) 3611-3543</div>
            </div>
        </div>
    </main>

    <script>
        // Dados simulados dos postos de saúde
        const healthPosts = [
            {
                name: "UBS SAO GONCALO",
                address: "AVENIDA CARDEAL DA SILVA - 789, FEDERACAO",
                phone: "(71)3611-1340"
            },
            {
                name: "USF PROF EDUARDO MAMEDE", 
                address: "SETOR E CAMINHO 16 - S/N, MUSSURUNGA I",
                phone: "(71) 36112962"
            },
            {
                name: "USF BOA VISTA DE SAO CAETANO",
                address: "RUA RODOVIA A - S/N, BOA VISTA DE SAO CAE", 
                phone: "(71) 3611-3543"
            },
            {
                name: "UBS CENTRO HISTÓRICO",
                address: "RUA DAS LARANJEIRAS - 123, PELOURINHO",
                phone: "(71) 3611-2000"
            },
            {
                name: "USF ITAPUA",
                address: "AVENIDA DORIVAL CAYMMI - 456, ITAPUA",
                phone: "(71) 3611-3000"
            }
        ];

        function renderResults(posts) {
            const container = document.getElementById('resultsContainer');
            container.innerHTML = '';

            posts.forEach(post => {
                const postElement = document.createElement('div');
                postElement.className = 'health-post';
                postElement.innerHTML = `
                    <div>
                        <div class="post-title">Posto de saúde: ${post.name}</div>
                        <div class="post-address">Endereço: ${post.address}</div>
                    </div>
                    <div class="post-phone">Telefone: ${post.phone}</div>
                `;
                container.appendChild(postElement);
            });
        }

        function performSearch() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
            
            if (!searchTerm) {
                renderResults(healthPosts.slice(0, 3)); // Mostra os primeiros 3 por padrão
                return;
            }

            const filteredPosts = healthPosts.filter(post => 
                post.name.toLowerCase().includes(searchTerm) ||
                post.address.toLowerCase().includes(searchTerm)
            );

            renderResults(filteredPosts);
        }

        // Busca ao pressionar Enter
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });

        // Busca em tempo real enquanto digita
        document.getElementById('searchInput').addEventListener('input', function() {
            performSearch();
        });

        // Renderiza os resultados iniciais
        renderResults(healthPosts.slice(0, 3));
    </script>
</body>
</html>