@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content">
            <div class="standup-form">
                <form action="/standup/send" method="POST">
                    <div class="form-group">
                        <label for="who">You are who?</label>
                        <input class="form-control" id="who" name="who" value="{{ Auth::user()->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="yesterday">Yesterday I accomplished</label>
                        <textarea class="form-control" rows="5" cols="80" name="yesterday" id="yesterday"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="today">Today I will accomplish</label>
                        <textarea class="form-control" rows="5" cols="80" name="today" id="today"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="challenges">Challenges standing in my way</label>
                        <textarea class="form-control" rows="5" cols="80" name="challenges" id="challenges"></textarea>
                    </div>

                    {{ csrf_field() }}

                    <button class="btn btn-primary btn-lg" type="submit">STAND'R UP</button>
                </form>
            </div>
        </div>
    </div>
@endsection
