@extends('layouts.backlayout')

@section('content')
<div class="row">
  <div class="col-md-8 mx-auto grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Edit Prompt</h4>

        <!-- enctype="multipart/form-data" added here -->
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
            @if($prompt->image)
              <div class="mb-2">
                <img src="{{ asset('storage/' . $prompt->image) }}" class="rounded border" style="width: 80px; height: 80px; object-fit: cover;">
              </div>
            @endif
            <input type="file" name="image" class="form-control" accept="image/*">
          </div>

          <button type="submit" class="btn btn-success text-white">Update Prompt</button>
          <a href="{{ route('admin.prompts.index') }}" class="btn btn-secondary">Cancel</a>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection