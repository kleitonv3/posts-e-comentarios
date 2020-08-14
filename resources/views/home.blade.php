@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
                <form action="{{ route('posts.index') }}" method="get" style="text-align: center; padding: 2px">
                    @csrf
                    <button type="submit" class="btn btn-success" id="voltar">Ir para o site</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
