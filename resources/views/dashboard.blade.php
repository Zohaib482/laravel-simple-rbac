@extends('simplerbac::layouts.dashboard')

@section('title', 'Dashboard')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <!-- You can add buttons here later, e.g. New User, Export, etc. -->
        </div>
    </div>

    <div class="row g-4">
        <!-- Welcome card -->
        <div class="col-12">
            <div class="alert alert-info">
                Welcome back, <strong>{{ auth()->user()->name }}</strong>!
                @if (!auth()->user()->hasVerifiedEmail())
                    <br><small class="text-danger">Your email is not verified yet. Please check your inbox.</small>
                @endif
            </div>
        </div>

        <!-- Example cards -->
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Users</h5>
                    <p class="card-text display-6">0</p> <!-- Replace with real count later -->
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Roles</h5>
                    <p class="card-text display-6">3</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-info shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Permissions</h5>
                    <p class="card-text display-6">12</p>
                </div>
            </div>
        </div>
    </div>

    <!-- You can add charts, tables, recent activity, etc. here later -->

@endsection
