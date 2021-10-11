@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verifique seu endereço de email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Um link de verificação foi enviado para seu email.') }}
                        </div>
                    @endif

                    {{ __('Antes de processeguir, Por favor check seu email para um link de verificação.') }}
                    {{ __('Se você não recebeu o email') }}, <a href="{{ route('verification.resend') }}">{{ __('clique aqui para requisitar outro') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
