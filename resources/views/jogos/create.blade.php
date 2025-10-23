@extends('layouts.app') 
@section('title', 'Criação')
@section('content') 

<div class="container mt-5">
  <div class="row" 0>
    <div class="col-sm-10">
      <h1>Novo jogo</h1>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
    @endif

    <div class="col-sm-2">
      <a href="{{ route('jogos.index') }}" class="btn btn-success">Voltar</a> 
    </div>
  </div>
  <hr>
  <form action="{{ route('jogos.store') }}" method="POST"> 
    @csrf
    <div class="form-group">
      <div class="form-group">
        <label for="nome">Nome: </label>
        <input type="text" class="form-control" name="nome" placeholder="Digite o título do jogo..."><br>
      </div>
      <div class="form-group">
        <label for="nome">Categoria: </label>
        <select id="categoria" name="categoria" class="form-control"> 
          <!-- fazer crud de categoria -->
          <option value="aventura">Aventura</option>
          <option value="rpg">RPG</option>
          <option value="simulação">Simulação</option>
          <option value="fps">FPS</option>
          <option value="puzzle">Puzzle</option>
          <option value="dd">D&D</option>
          <option value="terror">Terror</option>
          <option value="outros">Outros</option>
        </select>
      </div><br>
      <div class="form-group">
        <label for="nome">Ano de criação: </label>
        <input type="number" class="form-control" name="ano_criacao" placeholder="Ano de lançamento..."><br>
      </div>
      <div class="form-group">
        <label for="nome">Valor (R$) </label>
          <div>
            <input type="number" step="0.01" class="form-control" name="valor" placeholder="Digite um valor para o jogo..."><br> <!-- antes o valor estava em number -->
          </div>
      </div>
      <div class="form-group">
        <input type="submit" class="btn btn-primary" name="submit" value="Salvar"><br>
      </div>
    </div>
  </form>
</div>
@endsection 