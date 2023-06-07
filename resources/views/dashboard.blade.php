@extends('layouts.app', ['pageSlug' => 'dashboard'])

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('tweets.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="content" class="form-control" placeholder="apa yang kamu pikirin?" rows="3"></textarea>
                </div>
                <input type="submit" class="btn btn-primary" value="Tweet">
            </form>
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Latest Tweets</h5>
                    @forelse($tweets as $tweet)
                        @php
                            $alertClasses = [
                                'primary',
                                'info',
                                'success',
                                'danger',
                                'warning',
                                'default',
                            ];
                            $randomAlertClass = $alertClasses[array_rand($alertClasses)];
                        @endphp
                        <div class="alert alert-{{ $randomAlertClass }}" role="alert">
                            <span class="fw-bold">{{ $tweet->user->name }}:</span> {{ $tweet->content }}
                            @if(Auth::id() === $tweet->user_id)
                                <div class="float-end">
                                    <a href="{{ route('tweets.edit', $tweet->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('tweets.destroy', $tweet->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this tweet?')">Delete</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @empty
                        <p>No tweets found.</p>
                    @endforelse

                    {{ $tweets->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
