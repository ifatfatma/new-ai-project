@extends('layouts.backlayout')

@section('content')
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="page-title font-weight-bold text-dark mb-1">Prompts Management</h3>
                <p class="text-muted mb-0">Manage all AI prompts and categories</p>
            </div>
            <a href="{{ route('admin.prompts.create') }}" class="btn btn-primary fw-bold">+ Add New Prompt</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.prompts.index') }}" class="mb-4 row g-3 align-items-center">
           
            <!-- User Filter Dropdown with Search -->
           <div class="col-auto" style="width: 260px;">
    <select name="user_id" class="form-select select2-user" onchange="this.form.submit()">
        <option value=""></option>
        @foreach($users as $user)
            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                {{ $user->name ?? $user->email }}
            </option>
        @endforeach
    </select>
</div>
            <!-- Date Filter Input -->
            <div class="col-auto">
                <input type="date" name="date" value="{{ request('date') }}" class="form-control"
                    onchange="this.form.submit()">
            </div>

            <!-- Reset Filter Button -->
            @if(request('user_id') || request('date'))
                <div class="col-auto">
                    <a href="{{ route('admin.prompts.index') }}" class="btn btn-outline-secondary btn-sm">Reset Filters</a>
                </div>
            @endif
        </form>

        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Created By</th>
                                        <th>Label</th>
                                        <th>Copies</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($prompts as $key => $prompt)
                                        <tr>
                                            <td>{{ ($prompts->currentPage() - 1) * $prompts->perPage() + $key + 1 }}</td>
                                            <td class="fw-bold">{{ $prompt->title }}</td>

                                            <!-- Category Badge -->
                                            <td>
                                                <span
                                                    class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1"
                                                    style="background-color: #eef2ff; color: #4f46e5; border-radius: 6px;">
                                                    {{ $prompt->category->name ?? 'N/A' }}
                                                </span>
                                            </td>

                                            <!-- Created By User Column -->

                                            <span
                                                class="text-dark fw-medium">{{ $prompt->user->name ?? $prompt->user->email ?? 'N/A' }}</span>


                                            <!-- Label -->
                                            <td>
                                                @if($prompt->label)
                                                    <span class="badge bg-secondary">{{ $prompt->label }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>

                                            <!-- Copies Count -->
                                            <td>
                                                <span
                                                    class="badge bg-light text-dark border">{{ $prompt->copies_count ?? 0 }}</span>
                                            </td>

                                            <!-- Actions -->
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-info" data-toggle="modal"
                                                    data-target="#viewModal{{ $prompt->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#viewModal{{ $prompt->id }}">
                                                    View
                                                </button>

                                                <a href="{{ route('admin.prompts.edit', $prompt->id) }}"
                                                    class="btn btn-sm btn-outline-warning">Edit</a>

                                                <form action="{{ route('admin.prompts.destroy', $prompt->id) }}" method="POST"
                                                    class="d-inline" onsubmit="return confirm('Delete this prompt?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>

                                                <!-- Admin View Prompt Modal -->
                                                <div class="modal fade" id="viewModal{{ $prompt->id }}" tabindex="-1"
                                                    role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                        <div class="modal-content border-0 shadow rounded-4">
                                                            <div class="modal-header border-0">
                                                                <h5 class="modal-title fw-bold">{{ $prompt->title }}</h5>
                                                                <button type="button" class="close btn-close"
                                                                    data-dismiss="modal" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-left">
                                                                <div class="mb-3">
                                                                    <span
                                                                        class="badge badge-primary bg-primary">{{ $prompt->category->name ?? 'N/A' }}</span>
                                                                    @if($prompt->label)
                                                                        <span
                                                                            class="badge badge-secondary bg-secondary ms-1">{{ $prompt->label }}</span>
                                                                    @endif
                                                                    <span class="badge bg-light text-dark border ms-1">By:
                                                                        {{ $prompt->user->name ?? $prompt->user->email ?? 'Admin' }}</span>
                                                                </div>
                                                                @if($prompt->image)
                                                                    <div class="text-center mb-3">
                                                                        <img src="{{ asset('storage/' . $prompt->image) }}"
                                                                            class="img-fluid rounded border"
                                                                            style="max-height: 250px;">
                                                                    </div>
                                                                @endif
                                                                <label class="font-weight-bold text-muted small mb-1">PROMPT
                                                                    TEXT:</label>
                                                                <div class="p-3 bg-light rounded border text-dark">
                                                                    <pre
                                                                        style="white-space: pre-wrap; font-family: monospace; margin: 0;">{{ $prompt->prompt_text }}</pre>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer border-0">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End View Modal -->
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">No prompts found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $prompts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection