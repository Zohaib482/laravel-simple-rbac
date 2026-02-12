@extends('simplerbac::layouts.auth')

@section('title', 'Verify Email')

@section('content')

    <div class="text-center mb-4">
        <h5 class="text-muted">Please check your email</h5>
        <p class="text-muted">We've sent a verification link to your email address.</p>
    </div>

    @if (session('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-grid gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-outline-primary">
                Resend Verification Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary">
                Logout
            </button>
        </form>
    </div>

@endsection
