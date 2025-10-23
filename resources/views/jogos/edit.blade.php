@extends('layouts.app') <!-- herda de app -->

@section('title', 'Edição')

@section('content') <!-- abre a section. Tudo dentro dessa tag será renderizado lá no template -->

<div class="container mt-5">
  <div class="row" 0>
    <div class="col-sm-10">
      <h1>Editar jogo</h1>
    </div>

    @if ($errors->any()) <!-- permite que o validator emita as mensagens (withErrors)-->
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error) <!-- permite que o validator emita as mensagens (withErrors) -->
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    @if(session('success')) <!-- verifica se exist uma mensagem de erro para exibi-la -->
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
    @endif

    <div class="col-sm-2">
      <a href="{{ route('jogos.index') }}" class="btn btn-success">Voltar</a> <!-- botão com link para a route jogos.create, responsável por add um novo registro -->
    </div>
  </div>
  <hr>
  <form action="{{ route('jogos.update', ['id'=>$jogos->id]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja editar este jogo?');"> <!--  É emitido um alert se o usuário tem certeza se quer mesmo excluir o jogo -->
    @csrf
    @method('PUT') <!-- permite que os data sejam reenviados, pois o método indicado é POST e o que pretendemos usar é PUT no parâmetro da rota-->
    <div class="form-group">
      <div class="form-group">
        <label for="nome">Nome: </label>
        <input type="text" class="form-control" name="nome" value="{{ $jogos->nome }}" placeholder="Digite o título do jogo..."><br> <!-- O value é responsável por resgatar os códigos cadastraos -->
      </div>
      <div class="form-group">
        <label for="nome">Categoria: </label>
        <select id="categoria" name="categoria" class="form-control">
          <option value="aventura" {{ $jogos->categoria == 'aventura' ? 'selected' : '' }}>Aventura</option> <!-- Adicionado class=form-control para manter estilo do Bootstrap -->
          <option value="rpg" {{ $jogos->categoria == 'rpg' ? 'selected' : '' }}>RPG</option><!-- Adicionada verificação para marcar como selecionado se for igual -->
          <option value="simulação" {{ $jogos->categoria == 'simulação' ? 'selected' : '' }}>Simulação</option>
          <option value="fps" {{ $jogos->categoria == 'fps' ? 'selected' : '' }}>FPS</option>
          <option value="puzzle" {{ $jogos->categoria == 'puzzle' ? 'selected' : '' }}>Puzzle</option>
          <option value="dd" {{ $jogos->categoria == 'dd' ? 'selected' : '' }}>D&D</option>
          <option value="terror" {{ $jogos->categoria == 'terror' ? 'selected' : '' }}>Terror</option>
          <option value="outros" {{ $jogos->categoria == 'outros' ? 'selected' : '' }}>Outros</option>
        </select>

      </div>
      <div class="form-group">
        <label for="nome">Ano de criação: </label>
        <input type="number" class="form-control" name="ano_criacao" value="{{ $jogos->ano_criacao }}" placeholder="Ano de lançamento..."><br>
      </div>
      <div class="form-group">
        <label for="nome">Valor: </label>
          <div>
            <span class="input-group-text">R$</span>
            <input type="number" step="0.01" class="form-control" name="valor" value="{{ number_format($jogos->valor, 2, '.', '') }}" placeholder="Digite um valor para o jogo..."><br><!-- Adicionado value com number_format para manter o valor salvo preenchido corretamente no campo numérico -->
          </div>
      </div>
      <div class="form-group">
        <input type="submit" class="btn btn-success" name="submit" value="Atualizar"><br>
      </div>
    </div>
  </form>
</div>
@endsection <!-- fecha a section -->