@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <p>You are logged in!</p>

                        <div>Ir para raiz: <a href="{{ route('root') }}">Home (Rota: root)</a></div>

                        <div style="padding-top: 50px">
                            @guest
                                {{--@if (Auth::guest())--}}
                                <p>User não autenticado!</p>
                            @else
                                <p>User <strong>{{ Auth::user()->name }}</strong> autenticado!</p>
                            @endguest
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
