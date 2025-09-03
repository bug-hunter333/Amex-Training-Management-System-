@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3>{{ $stats['total_users'] }}</h3>
                        <p class="mb-0">Total Users</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-people h1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3>{{ $stats['total_trainers'] }}</h3>
                        <p class="mb-0">Total Trainers</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-person-badge h1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3>{{ $stats['total_courses'] }}</h3>
                        <p class="mb-0">Total Courses</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-book h1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3>{{ $stats['total_enrollments'] }}</h3>
                        <p class="mb-0">Total Enrollments</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-clipboard-check h1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Additional Stats -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="text-success">{{ $stats['active_courses'] }}</h4>
                <small class="text-muted">Active Courses</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="text-warning">{{ $stats['pending_enrollments'] }}</h4>
                <small class="text-muted">Pending Enrollments</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="text-primary">{{ $stats['active_sessions'] }}</h4>
                <small class="text-muted">Active Sessions</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="text-info">{{ $stats['completed_sessions'] }}</h4>
                <small class="text-muted">Completed Sessions</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Enrollments -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Enrollments</h5>
            </div>
            <div class="card-body">
                @if($recentEnrollments->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentEnrollments as $enrollment)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $enrollment->user->name }}</strong><br>
                                    <small class="text-muted">{{ $enrollment->course->title }}</small>
                                </div>
                                <span class="badge bg-{{ $enrollment->status == 'approved' ? 'success' : ($enrollment->status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($enrollment->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No recent enrollments</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Courses -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Courses</h5>
            </div>
            <div class="card-body">
                @if($recentCourses->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentCourses as $course)
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $course->title }}</h6>
                                    <small>{{ $course->created_at->format('M d') }}</small>
                                </div>
                                <p class="mb-1">by {{ $course->trainer->user->name ?? 'N/A' }}</p>
                                <small class="text-muted">{{ $course->category }}</small>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No recent courses</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection