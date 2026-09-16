@extends('layouts.backlayout')

@section('content')
<div class="row mb-3 align-items-center">
  <div class="col-md-8">
    <h3 class="fw-bold">All Saved Prompts</h3>
    <p class="text-muted">Manage all prompts created across categories.</p>
  </div>
  <div class="col-md-4 text-end">
    <a href="{{ route('admin.prompts.create') }}" class="btn btn-primary text-white">+ Add New Prompts</a>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="card border rounded shadow-sm">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Preview Image</th>
            <th>Category</th>
            <th>Topic / Collection</th>
            <th>Step Label</th>
            <th>Prompt Text</th>
            <th class="text-center">Actions</th>
            <th>Copies</th>
          </tr>
        </thead>
        <tbody>
          @forelse($prompts as $key => $prompt)
            <tr>
              <td>{{ $prompts->firstItem() + $key }}</td>
              
              <!-- Image Preview -->
              <td>
                @if(!empty($prompt->image))
                  <img src="{{ asset('storage/' . $prompt->image) }}" alt="Preview" class="rounded border" style="width: 50px; height: 50px; object-fit: cover;">
                @else
                  <span class="badge bg-light text-muted border">No Image</span>
                @endif
              </td>

              <td>
                <span class="badge bg-secondary">{{ $prompt->category->name ?? 'Uncategorized' }}</span>
              </td>
              <td><strong>{{ $prompt->title }}</strong></td>
              <td>{{ $prompt->label ?? '-' }}</td>
              <td style="max-width: 250px;">
                {{ \Illuminate\Support\Str::limit($prompt->prompt_text, 50) }}
              </td>

              <td>
    <span class="badge bg-light text-primary border font-weight-bold">
        <i class="mdi mdi-content-copy me-1 text-info"></i> {{ $prompt->copies_count ?? 0 }}
    </span>
</td>


              
              <td class="text-center">
                <div class="btn-group" role="group">
                  <!-- View Button Triggering Modal -->
                  <button type="button" class="btn btn-sm btn-info text-white me-1" data-bs-toggle="modal" data-bs-target="#viewModal{{ $prompt->id }}">
                    View
                  </button>

                  <!-- Edit Button -->
                  <a href="{{ route('admin.prompts.edit', $prompt->id) }}" class="btn btn-sm btn-warning text-white me-1">
                    Edit
                  </a>

                  <!-- Delete Button -->
                  <form action="{{ route('admin.prompts.destroy', $prompt->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this prompt?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger text-white">Delete</button>
                  </form>
                </div>

                <!-- View Detail Modal -->
                <div class="modal fade" id="viewModal{{ $prompt->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $prompt->id }}" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content text-start">
                      <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="viewModalLabel{{ $prompt->id }}">{{ $prompt->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="mb-3">
                          <span class="badge bg-primary me-2">{{ $prompt->category->name ?? 'Uncategorized' }}</span>
                          @if($prompt->label)
                            <span class="badge bg-secondary">{{ $prompt->label }}</span>
                          @endif
                        </div>

                        <!-- Example Output Image -->
                        @if(!empty($prompt->image))
                          <div class="mb-3 text-start">
                            <label class="fw-bold d-block mb-2">Example Output Image:</label>
                            <div class="text-center bg-light p-2 rounded border">
                              <img src="{{ asset('storage/' . $prompt->image) }}" class="img-fluid rounded" style="max-height: 350px;">
                            </div>
                          </div>
                        @else
                          <div class="mb-3 text-muted">
                            <small><em>No Example Image Uploaded.</em></small>
                          </div>
                        @endif

                        <label class="fw-bold mb-1">Prompt Text:</label>
                        <div class="p-3 bg-light rounded border">
                          <p style="color: #333; white-space: pre-wrap; margin-bottom: 0;">{{ $prompt->prompt_text }}</p>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>

              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center text-muted py-4">No prompts added yet.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      {{ $prompts->links() }}
    </div>
  </div>
</div>

<!-- Ensure Bootstrap JS bundle is included for Modal -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection