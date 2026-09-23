
@extends('layouts.backlayout')

@section('content')

<div class="content-wrapper" style="padding-top: 60px !important;">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="page-title font-weight-bold text-dark mb-1">
                Prompts Management
            </h3>
            <p class="text-muted mb-0">All AI Prompts</p>
        </div>

        <a href="{{ route('admin.prompts.create') }}"
           class="btn btn-primary fw-bold">
            + Add New Prompt
        </a>
    </div>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>
        </div>
    @endif


    {{-- Filter Form --}}
    <form method="GET"
          action="{{ route('admin.prompts.index') }}"
          class="mb-4 row g-3 align-items-center">

        {{-- User Filter --}}
        <div class="col-md-3 col-sm-6">

            <select name="user_id"
                    class="form-select select2-user"
                    onchange="this.form.submit()">

                <option value="">All Users</option>

                @foreach($users as $user)

                    <option value="{{ $user->id }}"
                        {{ request('user_id') == $user->id ? 'selected' : '' }}>

                        {{ $user->name ?? $user->email }}

                    </option>

                @endforeach

            </select>

        </div>


        {{-- Date Filter --}}
        <div class="col-md-2 col-sm-6">

            <input type="date"
                   name="date"
                   value="{{ request('date') }}"
                   class="form-control"
                   onchange="this.form.submit()">

        </div>


        {{-- Reset Filters --}}
        @if(request('user_id') || request('date'))

            <div class="col-auto">

                <a href="{{ route('admin.prompts.index') }}"
                   class="btn btn-outline-secondary btn-sm">

                    Reset Filters

                </a>

            </div>

        @endif

    </form>


    {{-- Custom CSS --}}
    <style>

        .prompts-table td {
            white-space: normal !important;
            word-break: break-word !important;
            vertical-align: middle;
        }

        .prompts-table .badge {
            max-width: 180px;
            white-space: normal !important;
            text-align: left;
            height: auto;
            display: inline-block;
        }

        .prompt-actions {
            white-space: nowrap;
            position: relative;
        }

        .prompt-text {
            white-space: pre-wrap;
            word-break: break-word;
            font-family: monospace;
            margin: 0;
        }

        .prompt-image {
            max-height: 250px;
            max-width: 100%;
            object-fit: contain;
        }

    </style>


    {{-- Prompts Table --}}
    <div class="row">

        <div class="col-12 grid-margin stretch-card">

            <div class="card border-0 shadow-sm rounded-3">

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-hover align-middle prompts-table">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Created By</th>
                                    <th>Label</th>
                                    <th>Status</th>
                                    <th>Copies</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>


                            <tbody>

                            @forelse($prompts as $key => $prompt)

                                {{-- Status Handling --}}
                                @php
                                    $status = $prompt->status ?? null;

                                    if ($status === null) {
                                        $status = $prompt->is_approved ?? 0;
                                    }

                                    if ($status === 'approved' || $status == 1) {
                                        $statusText = 'approved';
                                    } elseif ($status === 'rejected' || $status == 2) {
                                        $statusText = 'rejected';
                                    } else {
                                        $statusText = 'pending';
                                    }
                                @endphp


                                <tr>

                                    {{-- Number --}}
                                    <td>
                                        {{ ($prompts->currentPage() - 1) * $prompts->perPage() + $key + 1 }}
                                    </td>


                                    {{-- Title --}}
                                    <td class="fw-bold">
                                        {{ $prompt->title }}
                                    </td>


                                    {{-- Category --}}
                                    <td>

                                        <span class="badge px-2 py-1"
                                              style="
                                                background-color: #eef2ff;
                                                color: #4f46e5;
                                                border-radius: 6px;
                                              ">

                                            {{ $prompt->category->name ?? 'N/A' }}

                                        </span>

                                    </td>


                                    {{-- Created By --}}
                                    <td>

                                        <span class="text-dark fw-medium">

                                            {{ $prompt->user->name
                                                ?? $prompt->user->email
                                                ?? 'N/A' }}

                                        </span>

                                    </td>


                                    {{-- Label --}}
                                    <td>

                                        @if(!empty($prompt->label))

                                            <span class="badge bg-secondary">
                                                {{ $prompt->label }}
                                            </span>

                                        @else

                                            <span class="text-muted">-</span>

                                        @endif

                                    </td>


                                    {{-- Status --}}
                                    <td>

                                        @if($statusText === 'approved')

                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                                Approved
                                            </span>

                                        @elseif($statusText === 'rejected')

                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                                Rejected
                                            </span>

                                        @else

                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">
                                                Pending
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Copies --}}
                                    <td>

                                        <span class="badge bg-light text-dark border">
                                            {{ $prompt->copies_count ?? 0 }}
                                        </span>

                                    </td>


                                    {{-- Actions --}}
                                    <td class="text-center prompt-actions">

                                        <div class="dropdown">

                                            <button
                                                type="button"
                                                class="btn btn-light btn-sm border px-3 py-1 rounded-pill shadow-sm dropdown-toggle d-inline-flex align-items-center"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false">

                                                <i class="bi bi-three-dots-vertical me-1 text-secondary"></i>
                                                Actions

                                            </button>


                                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-2 rounded-3"
                                                style="min-width: 160px;">


                                                {{-- Approve --}}
                                                <li>

                                                    <form
                                                        action="{{ route('admin.prompts.approve', $prompt->id) }}"
                                                        method="POST">

                                                        @csrf

                                                        <button
                                                            type="submit"
                                                            class="dropdown-item py-2 px-3 text-success d-flex align-items-center"
                                                            style="font-size: 13px; font-weight: 500;">

                                                            <i class="bi bi-check-circle-fill me-2"></i>
                                                            Approve

                                                        </button>

                                                    </form>

                                                </li>


                                                {{-- Reject --}}
                                                <li>

                                                    <form
                                                        action="{{ route('admin.prompts.reject', $prompt->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Reject this prompt?');">

                                                        @csrf

                                                        <button
                                                            type="submit"
                                                            class="dropdown-item py-2 px-3 text-warning d-flex align-items-center"
                                                            style="font-size: 13px; font-weight: 500;">

                                                            <i class="bi bi-x-circle-fill me-2"></i>
                                                            Reject

                                                        </button>

                                                    </form>

                                                </li>


                                                <li>
                                                    <hr class="dropdown-divider my-1">
                                                </li>


                                                {{-- View Button --}}
                                                <li>

                                                    <button
                                                        type="button"
                                                        class="dropdown-item py-2 px-3 text-dark d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#viewModal{{ $prompt->id }}">

                                                        <i class="bi bi-eye-fill me-2 text-info"></i>
                                                        View

                                                    </button>

                                                </li>


                                                {{-- Edit --}}
                                                <li>

                                                    <a
                                                        href="{{ route('admin.prompts.edit', $prompt->id) }}"
                                                        class="dropdown-item py-2 px-3 text-dark d-flex align-items-center"
                                                        style="font-size: 13px;">

                                                        <i class="bi bi-pencil-square me-2 text-primary"></i>
                                                        Edit

                                                    </a>

                                                </li>


                                                <li>
                                                    <hr class="dropdown-divider my-1">
                                                </li>


                                                {{-- Delete --}}
                                                <li>

                                                    <form
                                                        action="{{ route('admin.prompts.destroy', $prompt->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Delete this prompt?');">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            class="dropdown-item py-2 px-3 text-danger d-flex align-items-center"
                                                            style="font-size: 13px;">

                                                            <i class="bi bi-trash-fill me-2"></i>
                                                            Delete

                                                        </button>

                                                    </form>

                                                </li>

                                            </ul>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="8"
                                        class="text-center py-4 text-muted">

                                        No prompts found.

                                    </td>

                                </tr>

                            @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- VIEW MODALS: OUTSIDE THE TABLE AND TABLE-RESPONSIVE       --}}
    {{-- ========================================================= --}}

    @foreach($prompts as $prompt)

        <div
            class="modal fade"
            id="viewModal{{ $prompt->id }}"
            tabindex="-1"
            aria-labelledby="viewModalLabel{{ $prompt->id }}"
            aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered modal-lg">

                <div class="modal-content border-0 shadow rounded-4">


                    {{-- Modal Header --}}
                    <div class="modal-header">

                        <h5
                            class="modal-title fw-bold"
                            id="viewModalLabel{{ $prompt->id }}">

                            {{ $prompt->title }}

                        </h5>


                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                        </button>

                    </div>


                    {{-- Modal Body --}}
                    <div class="modal-body">


                        {{-- Category, Label and User --}}
                        <div class="mb-3">

                            <span class="badge bg-primary">

                                {{ $prompt->category->name ?? 'N/A' }}

                            </span>


                            @if(!empty($prompt->label))

                                <span class="badge bg-secondary ms-1">

                                    {{ $prompt->label }}

                                </span>

                            @endif


                            <span class="badge bg-light text-dark border ms-1">

                                By:
                                {{ $prompt->user->name
                                    ?? $prompt->user->email
                                    ?? 'Admin' }}

                            </span>

                        </div>


                        {{-- Prompt Image --}}
                        @if(!empty($prompt->image))

                            <div class="text-center mb-3">

                                <img
                                    src="{{ asset('storage/' . $prompt->image) }}"
                                    alt="{{ $prompt->title }}"
                                    class="img-fluid rounded border prompt-image">

                            </div>

                        @endif


                        {{-- Prompt Text --}}
                        <div class="mb-2">

                            <label class="fw-bold text-muted small">
                                PROMPT TEXT:
                            </label>

                        </div>


                        <div class="p-3 bg-light rounded border text-dark">

                            <pre class="prompt-text">{{ $prompt->prompt_text }}</pre>

                        </div>

                    </div>


                    {{-- Modal Footer --}}
                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                            Close

                        </button>

                    </div>

                </div>

            </div>

        </div>

    @endforeach


    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-3">

        {{ $prompts->links() }}

    </div>

</div>

@endsection