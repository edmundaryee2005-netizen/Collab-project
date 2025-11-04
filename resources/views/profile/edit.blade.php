@extends('layouts.app') {{-- Make sure this matches your main Bootstrap layout file --}}

@section('content')
<div class="container my-4 my-md-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">

            {{-- This replaces the <x-slot name="header"> --}}
            <h2 class="h3 mb-4 fw-light">{{ __('Profile') }}</h2>

            {{-- Card 1: Update Profile Information --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body p-4 p-md-5">
                    {{-- This partial still needs to be converted to Bootstrap --}}
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Card 2: Update Password --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body p-4 p-md-5">
                    {{-- This partial still needs to be converted to Bootstrap --}}
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Card 3: Delete User --}}
            <div class="card shadow-sm">
                <div class="card-body p-4 p-md-5">
                    {{-- This partial still needs to be converted to Bootstrap --}}
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
