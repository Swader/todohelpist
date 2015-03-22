@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Home</div>

                    <div class="panel-body">
                        <p>You are logged in as {{ $email }}. The projects we have on record for you are:</p>
                        @foreach ($projects as $project)
                            <p>{{ $project['id'] }} : {{ $project['name'] }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
