@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Home</div>

                    <div class="panel-body">
                            Please <a href="/auth/login" title="Log in">log in</a> first.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
