@extends('layouts.app')
@section('title', 'Listagem')
@section('content')

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
@if(session('danger'))
<div class="alert alert-danger">
    {{ session('danger') }}
</div>
@endif
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-10">
            <h1>Listagem de Jogos</h1>
        </div>
        <div class="col-sm-4">
            <a href="{{ route('jogos.create') }}" class="btn btn-success">Novo jogo</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Título</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Lançamento</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jogos as $jogo)
                <tr>
                    <th>{{ $jogo->nome }}</th>
                    <th>{{ $jogo->categoria }}</th>
                    <th>{{ $jogo->ano_criacao }}</th>
                    <th>R${{ number_format((float)$jogo->valor, 2, ',', '.') }}</th>
                    <th class="d-flex">
                        <a href="{{ route('jogos.edit', ['id'=> $jogo->id]) }}" class="btn btn-primary me-2">
                            <svg xmlns="<svg xmlns=" http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                            </svg> Editar
                        </a>
                        <form action="{{ route('jogos-destroy', ['id'=>$jogo->id]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este jogo?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                </svg> Excluir
                            </button> 
                        </form>
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @endsection