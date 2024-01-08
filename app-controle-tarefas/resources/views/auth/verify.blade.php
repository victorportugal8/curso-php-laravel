@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Verifique seu endereço de e-mail!</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Reenviamos um novo e-mail com o link para validação.
                        </div>
                    @endif

                    Antes de continuar, por favor verifique seu e-mail para validar seu acesso.
                    Caso não tenha recebido o e-mail de verificação, clique no link a seguir para receber um novo e-mail.
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Reenviar e-mail de validação</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
