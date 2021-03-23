@extends('layouts.app')

@section('content')
    <form method="POST" action="/" enctype="multipart/form-data">
       ...
    </form>

    <div class="p-2" style="width: 80%;">
        <div class="card-columns">
        @foreach($photos as $photo)
            <div class="card" style="width: 20rem;">
                <img class="card-img-top" src="{{ $photo->getUrlPath() }}" alt="Card image cap">
            </div>
        @endforeach
        </div>
    </div>
@endsection