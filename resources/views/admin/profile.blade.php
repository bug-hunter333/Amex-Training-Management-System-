@extends('admin.layouts.app')

@section('title', 'Profile')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Admin Profile</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Update Profile</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.profile.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $admin->user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $admin->user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone', $admin->user->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Account Information</h6>
            </div>
            <div class="card-body">
                <p><strong>Admin ID:</strong> {{ $admin->id }}</p>
                <p><strong>Access Level:</strong> 
                    <span class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $admin->access_level ?? 'admin')) }}</span>
                </p>
                <p><strong>Status:</strong> 
                    <span class="badge bg-success">Active</span>
                </p>
                <p><strong>Admin Since:</strong> {{ $admin->created_at->format('M d, Y') }}</p>
                <p><strong>Last Updated:</strong> {{ $admin->updated_at->format('M d, Y') }}</p>
            </div>
        </div>
        
        @if($admin->permissions)
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Permissions</h6>
            </div>
            <div class="card-body">
                @foreach($admin->permissions as $permission)
                    <span class="badge bg-info me-1 mb-1">{{ ucfirst(str_replace('_', ' ', $permission)) }}</span>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection