@extends('layouts.backlayout')

@section('content')
    <div class="content-wrapper" style="padding-top: 60px !important;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="page-title font-weight-bold text-dark mb-1">Prompts Management</h3>
                <p class="text-muted mb-0"> All AI Prompts</p>
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
            <div class="col-12 grid-margin stretch-card" style="overflow: visible !important;">
                <div class="card border-0 shadow-sm rounded-3" style="overflow: visible !important;">
                    <div class="card-body" style="overflow: visible !important;">
                        <div class="table-responsive" style="overflow: visible !important;">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Created By</th>
                                        <th>Label</th>
                                        <th>Status</th> <!-- New Status Column Added -->
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
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1"
                                                    style="background-color: #eef2ff; color: #4f46e5; border-radius: 6px;">
                                                    {{ $prompt->category->name ?? 'N/A' }}
                                                </span>
                                            </td>

                                            <!-- Created By User Column -->
                                            <td>
                                                <span class="text-dark fw-medium">{{ $prompt->user->name ?? $prompt->user->email ?? 'N/A' }}</span>
                                            </td>

                                            <!-- Label -->
                                            <td>
                                                @if($prompt->label ?? false)
                                                    <span class="badge bg-secondary">{{ $prompt->label }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>

                                            <!-- Status Column (Check your column name, e.g., status or is_approved) -->
                                            <td>
                                                @if(($prompt->status ?? $prompt->is_approved) == 'approved' || ($prompt->status ?? $prompt->is_approved) == 1)
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Approved</span>
                                                @elseif(($prompt->status ?? $prompt->is_approved) == 'rejected' || ($prompt->status ?? $prompt->is_approved) == 2)
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Rejected</span>
                                                @else
                                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">Pending</span>
                                                @endif
                                            </td>

                                            <!-- Copies Count -->
                                            <td>
                                                <span class="badge bg-light text-dark border">{{ $prompt->copies_count ?? 0 }}</span>
                                            </td>

                                            <!-- Actions Dropdown -->
                                            <td class="text-center" style="white-space: nowrap; position: relative;">
                                                <div class="dropdown">
                                                    <button class="btn btn-light btn-sm border px-3 py-1.5 rounded-pill shadow-sm dropdown-toggle d-inline-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: #f8fafc; font-weight: 500; font-size: 13px;">
                                                        <i class="bi bi-three-dots-vertical me-1 text-secondary"></i> Actions
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-2 rounded-3" style="min-width: 150px; position: absolute; right: 0;">
                                                        <!-- Approve Option -->
                                                        <li>
                                                            <form action="{{ route('admin.prompts.approve', $prompt->id) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item py-2 px-3 text-success d-flex align-items-center" style="font-size: 13px; font-weight: 500;">
                                                                    <i class="bi bi-check-circle-fill me-2 fs-6"></i> Approve
                                                                </button>
                                                            </form>
                                                        </li>

                                                        <!-- Reject Option -->
                                                        <li>
                                                            <form action="{{ route('admin.prompts.reject', $prompt->id) }}" method="POST" onsubmit="return confirm('Reject this prompt?')">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item py-2 px-3 text-warning d-flex align-items-center" style="font-size: 13px; font-weight: 500;">
                                                                    <i class="bi bi-x-circle-fill me-2 fs-6"></i> Reject
                                                                </button>
                                                            </form>
                                                        </li>

                                                        <li><hr class="dropdown-divider my-1"></li>

                                                        <!-- View Modal Trigger -->
                                                        <li>
                                                            <button type="button" class="dropdown-item py-2 px-3 text-dark d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#viewModal{{ $prompt->id }}" style="font-size: 13px;">
                                                                <i class="bi bi-eye-fill me-2 text-info fs-6"></i> View
                                                            </button>
                                                        </li>

                                                        <!-- Edit Link -->
                                                        <li>
                                                            <a class="dropdown-item py-2 px-3 text-dark d-flex align-items-center" href="{{ route('admin.prompts.edit', $prompt->id) }}" style="font-size: 13px;">
                                                                <i class="bi bi-pencil-square me-2 text-primary fs-6"></i> Edit
                                                            </a>
                                                        </li>

                                                        <li><hr class="dropdown-divider my-1"></li>

                                                        <!-- Delete Form -->
                                                        <li>
                                                            <form action="{{ route('admin.prompts.destroy', $prompt->id) }}" method="POST" onsubmit="return confirm('Delete this prompt?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item py-2 px-3 text-danger d-flex align-items-center" style="font-size: 13px;">
                                                                    <i class="bi bi-trash-fill me-2 fs-6"></i> Delete
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <!-- Admin View Prompt Modal -->
                                                <div class="modal fade" id="viewModal{{ $prompt->id }}" tabindex="-1"
                                                    role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                        <div class="modal-content border-0 shadow rounded-4 text-left">
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
                                                                    <span class="badge bg-primary">{{ $prompt->category->name ?? 'N/A' }}</span>
                                                                    @if($prompt->label ?? false)
                                                                        <span class="badge bg-secondary ms-1">{{ $prompt->label }}</span>
                                                                    @endif
                                                                    <span class="badge bg-light text-dark border ms-1">By:
                                                                        {{ $prompt->user->name ?? $prompt->user->email ?? 'Admin' }}</span>
                                                                </div>
                                                                @if($prompt->image ?? false)
                                                                    <div class="text-center mb-3">
                                                                        <img src="{{ asset('storage/' . $prompt->image) }}"
                                                                            class="img-fluid rounded border"
                                                                            style="max-height: 250px;">
                                                                    </div>
                                                                @endif
                                                                <label class="font-weight-bold text-muted small mb-1">PROMPT TEXT:</label>
                                                                <div class="p-3 bg-light rounded border text-dark">
                                                                    <pre style="white-space: pre-wrap; font-family: monospace; margin: 0;">{{ $prompt->prompt_text }}</pre>
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
                                            <td colspan="8" class="text-center py-4 text-muted">No prompts found.</td>
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

    <script>
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-menu.show').forEach(function (openDropdown) {
                    openDropdown.classList.remove('show');
                    openDropdown.closest('.dropdown').querySelector('.dropdown-toggle').setAttribute('aria-expanded', 'false');
                });
            }
        });
    </script>
@endsection