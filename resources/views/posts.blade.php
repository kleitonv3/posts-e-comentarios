@extends('layouts.app')

@section('style')
    <style>
        .col-12{
            margin:10px 0;
        }

        .row {
            justify-content: center;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        @auth
        <!-- Tem que ter o auth aqui !-->
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('posts.store') }}" method="POST">
                        @csrf
                        <div class="card-header">Criar nova postagem</div>
                        <div class="card-body">
                            <label for="titulo">Titulo</label>
                            <input type="text" name="title" id="titulo"><br>
                            <label for="conteudo">Conteúdo</label>
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}"> <!--Manda o id do usuário logado!-->
                            <textarea name="content" id="conteudo" rows="10" cols="80"></textarea>
                        </div>
                        <div class="card-footer d-flex flex-row-reverse">
                            <button type="submit" class="btn btn-success">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        @endauth
        @for ($i=0; $i<count($posts); $i++)
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header">{{ $posts[$i]['title'] }}</div>
                    <div class="card-body">
                        <h5>Autor: <small>{{ $posts[$i]['author'] }}</small></h5>
                        <p>
                            {{ $posts[$i]['content'] }}
                        </p>
                        <hr>
                        @php
                            $num_comms = count($posts[$i]['comments']);
                            $comment_href = $comment_id = "";

                            if ($num_comms != 0) {
                                $comment_href = "#comentario-".$posts[$i]['comments'][0]->id;
                                $comment_id = "comentario-".$posts[$i]['comments'][0]->id;
                            } else {
                                $comment_href = "#";
                                $comment_id = "";
                            }
                        @endphp
                        <a href={{ $comment_href }} data-toggle="collapse" aria-expanded="false" aria-controls={{ $comment_id }}>
                            <small>
                                comentários ({{ count($posts[$i]['comments']) }})
                            </small>
                        </a>
                        <div class="my-2 comentarios collapse" id={{ $comment_id }}>
                            @foreach ($posts[$i]['comments'] as $comm)
                                @component('components.comentario', ['autor'=>($comm->author)])
                                    <p>{{ $comm->content }}</p>
                                @endcomponent
                            @endforeach
                        </div>
                        @auth
                        <!-- Tem que ter o auth aqui !-->
                            <hr>
                            <div>
                                <form action="{{ route('comments.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}"> <!--Manda o id do usuário logado!-->
                                    <input type="hidden" name="post_id" value="{{ $posts[$i]['id'] }}">
                                    <div class="form-group">
                                        <label for="comentario">Comentario</label>
                                        <textarea name="content" id="comentario" class="form-control"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">Salvar comentário</button>
                                </form>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>
@endsection

@section('script')
    <script>
        window.onload = function(){ 
            CKEDITOR.replace('conteudo')
            CKEDITOR.config.height = 100;
        }
    </script>
@endsection