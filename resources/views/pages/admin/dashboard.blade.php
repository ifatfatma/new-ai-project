@extends('layouts.backlayout') 

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="page-title font-weight-bold text-dark mb-1">Admin Dashboard Overview</h3>
            <p class="text-muted mb-0">Welcome to AI Prompt Management System</p>
        </div>
        <span class="badge bg-white text-dark shadow-sm px-3 py-2 border">
            <i class="mdi mdi-calendar me-1 text-primary"></i> {{ date('d M, Y') }}
        </span>
    </div>

    <!-- 4 Stats Cards Row -->
    <div class="row">
        <!-- Card 1: Total Prompts -->
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card mb-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 font-weight-bold">Total Prompts</p>
                            <h3 class="mb-0 font-weight-bold text-primary">{{ $stats['total_prompts'] ?? 0 }}</h3>
                        </div>
                        <div class="icon-shape bg-primary text-white rounded-circle p-3">
                            <i class="mdi mdi-text-box-multiple-outline mdi-24px"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Categories -->
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card mb-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 font-weight-bold">Categories</p>
                            <h3 class="mb-0 font-weight-bold text-success">{{ $stats['total_categories'] ?? 0 }}</h3>
                        </div>
                        <div class="icon-shape bg-success text-white rounded-circle p-3">
                            <i class="mdi mdi-shape-outline mdi-24px"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Registered Users -->
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card mb-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 font-weight-bold">Total Users</p>
                            <h3 class="mb-0 font-weight-bold text-warning">{{ $stats['total_users'] ?? 0 }}</h3>
                        </div>
                        <div class="icon-shape bg-warning text-white rounded-circle p-3">
                            <i class="mdi mdi-account-group-outline mdi-24px"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

    <!-- Card 4: Total Copied Prompts (Clickable to Graph Page) -->
<div class="col-xl-3 col-sm-6 grid-margin stretch-card mb-4">
    <a href="{{ route('admin.analytics.copies') }}" class="text-decoration-none w-100">
        <div class="card border-0 shadow-sm rounded-3 hover-shadow transition">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 font-weight-bold">Total Copies</p>
                        <h3 class="mb-0 font-weight-bold text-info">{{ $stats['total_copies'] ?? 0 }}</h3>
                        <small class="text-primary font-weight-bold">View Analytics &rarr;</small>
                    </div>
                    <div class="icon-shape bg-info text-white rounded-circle p-3">
                        <i class="mdi mdi-content-copy mdi-24px"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>

    <!-- Recent Prompts Table Section -->
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">Recent Activity / Prompts</h4>
                        <a href="{{ route('admin.prompts.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPrompts as $index => $prompt)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><strong>{{ $prompt->title }}</strong></td>
                                        <td>
                                            <span class="badge bg-light text-primary border">
                                                {{ $prompt->category->name ?? 'Uncategorized' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if(isset($prompt->status) && $prompt->status == 1)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Draft</span>
                                            @endif
                                        </td>
                                        <td>{{ $prompt->created_at ? $prompt->created_at->format('d M, Y') : 'N/A' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.prompts.edit', $prompt->id) }}" class="btn btn-sm btn-light border me-1" title="Edit">
                                                <i class="mdi mdi-pencil text-warning"></i>
                                            </a>
                                            <form action="{{ route('admin.prompts.destroy', $prompt->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this prompt?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light border" title="Delete">
                                                    <i class="mdi mdi-delete text-danger"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">No recent prompts found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
