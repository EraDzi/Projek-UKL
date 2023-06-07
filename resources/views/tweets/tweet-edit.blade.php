@extends('layouts.app', ['pageSlug' => 'edit-tweet'])

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('tweets.update', $tweet->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <textarea name="content" class="form-control" rows="3">{{ $tweet->content }}</textarea>
                </div>
                <input type="submit" class="btn btn-primary" value="Update">
            </form>
        </div>
    </div>
@endsection
