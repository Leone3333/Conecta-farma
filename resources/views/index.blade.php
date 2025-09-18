<div>
    <form action="/login" method="post">
        @csrf
        <label>Matricula</label>
        <input type="text" name="matricula" placeholder="Digite seu RA" required>
        
        
        <label>Senha</label>
        <input type="text" name="senha" placeholder="Digite sua senha" required>

       <button type="submit">Enviar</button>
    </form>
</div>
