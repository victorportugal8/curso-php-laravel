Site da aplicação Controle de Tarefas
@auth
    <h1>Usuário autenticado</h1>
    <p>ID: {{Auth::user()->id}}</p>
    <p>Nome: {{Auth::user()->name}}</p>
    <p>E-mail: {{Auth::user()->email}}</p>
@endauth

@guest
    <br>Olá visitante, tudo bem?
@endguest