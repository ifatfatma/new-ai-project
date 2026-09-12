@extends('layouts.backlayout')

@section('content')
<div class="row">
  <div class="col-md-8 mx-auto grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Edit Prompt</h4>

        <form action="{{ route('admin.prompts.update', $prompt->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="form-group mb-3">
            <label class="fw-bold">Category</label>
            <select name="category_id" class="form-control" required>
              @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $prompt->category_id == $category->id ? 'selected' : '' }}>
                  {{ $category->name }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="form-group mb-3">
            <label class="fw-bold">Topic / Collection Title</label>
            <input type="text" name="title" class="form-control" value="{{ $prompt->title }}" required>
          </div>

          <div class="form-group mb-3">
            <label class="fw-bold">Step Label (Optional)</label>
            <input type="text" name="label" class="form-control" value="{{ $prompt->label }}">
          </div>

          <div class="form-group mb-3">
            <label class="fw-bold">Prompt Text</label>
            <textarea name="prompt_text" class="form-control" rows="5" required>{{ $prompt->prompt_text }}</textarea>
          </div>

          <div class="form-group mb-4">
            <label class="fw-bold">Example Output Image (Optional)</label>
            
            <!-- Existing Saved Image Preview with Remove Checkbox -->
            @if($prompt->image)
              <div class="mb-2 p-2 border rounded bg-light d-flex align-items-center justify-content-between" id="existing-img-box">
                <div class="d-flex align-items-center">
                  <img src="{{ asset('storage/' . $prompt->image) }}" class="rounded me-3" style="width: 65px; height: 65px; object-fit: cover;">
                  <span class="text-muted small">Current Saved Image</span>
                </div>
                <div class="form-check me-2">
                  <input class="form-check-input" type="checkbox" name="remove_image" value="1" id="remove_image_check">
                  <label class="form-check-label text-danger fw-bold" for="remove_image_check">
                    Remove Current Image
                  </label>
                </div>
              </div>
            @endif

            <!-- Upload new or clear selected file -->
            <div class="input-group">
              <input type="file" name="image" id="edit_image_input" class="form-control" accept="image/*">
              <button type="button" class="btn btn-outline-secondary" onclick="clearEditInput()">Clear Selected</button>
            </div>
            <small class="text-muted">Upload a new image to replace the existing one.</small>
          </div>

          <button type="submit" class="btn btn-success text-white">Update Prompt</button>
          <a href="{{ route('admin.prompts.index') }}" class="btn btn-secondary">Cancel</a>
        </form>

      </div>
    </div>
  </div>
</div>

<script>
  function clearEditInput() {
    document.getElementById('edit_image_input').value = "";
  }
</script>
@endsection