@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        
                        <nav class="navbar navbar-expand-lg bg-light">
                            <div class="container-fluid">
                              <a class="navbar-brand" href="#">Tarefas</a>
                              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                              </button>
                              <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav">
                                  <li class="nav-item">
                                    <a href="{{ route('tarefa.create') }}" class="nav-link">Novo</a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="{{ route('tarefa.exportacao' , ['extensao' => 'xlsx']) }}" class="nav-link">XLSX</a>
                                  </li>

                                  <li class="nav-item">
                                    <a href="{{ route('tarefa.exportacao' , ['extensao' => 'csv']) }}" class="nav-link">CSV</a>
                                  </li>

                                  <li class="nav-item">
                                    <a href="{{ route('tarefa.exportacao' , ['extensao' => 'pdf']) }}" class="nav-link">PDF</a>
                                  </li>

                                  <li class="nav-item">
                                    <a href="{{ route('tarefa.exportar') }}" class="nav-link" target="_blank">PDF V2</a>
                                  </li>
                                  
                                </ul>
                              </div>
                            </div>
                          </nav>
                        
                        
                       
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Tarefa</th>
                                    <th scope="col">Data limite conclusão</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tarefas as $key => $tarefa)
                                    <tr>
                                        <th scope="row">{{ $tarefa['id'] }}</th>
                                        <td>{{ $tarefa['tarefa'] }}</td>
                                        <td>{{ date('d/m/Y', strtotime($tarefa['data_limite_conclusao'])) }}</td>
                                        <td><a href="{{ route('tarefa.edit' ,  $tarefa['id'] ) }}" >Editar</a></td>
                                        <td>
                                            <form id="form_{{$tarefa['id']}}" method="POST" action="{{ route('tarefa.destroy' , ['tarefa' => $tarefa['id'] ]) }}" >
                                                @method('DELETE')
                                                @csrf
                                               
                                                <a href="#" onclick="document.getElementById('form_{{$tarefa['id']}}').submit()" >Excluir</a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link"
                                        href="{{ $tarefas->previousPageUrl() }}">Voltar</a></li>

                                @for ($i = 1; $i <= $tarefas->lastPage(); $i++)
                                    <li class="page-item {{ $tarefas->currentPage() == $i ? 'active' : '' }} ">
                                        <a class="page-link" href="{{ $tarefas->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item"><a class="page-link" href="{{ $tarefas->nextPageUrl() }}">Avançar</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
