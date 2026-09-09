@extends('layouts.backlayout')

@section('content')
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        
        <h4 class="card-title">Add New Prompts</h4>
        <p class="card-description">Select category and enter multiple prompts using the <strong>Add More</strong> option.</p>

        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.prompts.store') }}" method="POST">
          @csrf

          <div class="row">
            <!-- Category Selection -->
            <div class="col-md-6 form-group mb-3">
              <label class="fw-bold">Select Category</label>
              <select name="category_id" class="form-control" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
            </div>

            <!-- Collection Title -->
            <div class="col-md-6 form-group mb-3">
              <label class="fw-bold">Prompt Collection / Topic Title</label>
              <input type="text" name="title" class="form-control" placeholder="e.g. SEO Article Blueprint" required>
            </div>
          </div>

          <hr class="my-3">

          <!-- Prompts Section -->
          <h5 class="mb-3 fw-bold">Prompts List</h5>
          <div id="prompts-container">
            
            <!-- Default First Prompt Box -->
            <div class="prompt-card border rounded p-3 mb-3 bg-light" id="prompt-block-0">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-primary">Prompt #1</span>
              </div>

              <div class="form-group mb-2">
                <label>Prompt Step / Title (Optional)</label>
                <input type="text" name="prompts[0][label]" class="form-control" placeholder="e.g. Step 1: Catchy Headline Generator">
              </div>

              <div class="form-group mb-0">
                <label>Prompt Text <span class="text-danger">*</span></label>
                <textarea name="prompts[0][text]" class="form-control" rows="3" placeholder="Write your complete prompt here..." required></textarea>
              </div>
            </div>

          </div>

          <!-- Add More Button -->
          <div class="mb-4">
            <button type="button" id="add-more-btn" class="btn btn-outline-primary btn-sm fw-bold">
              <i class="mdi mdi-plus"></i>  Add More Prompt
            </button>
          </div>

          <!-- Submit Button -->
          <button type="submit" class="btn btn-success text-white">Save All Prompts</button>
        </form>

      </div>
    </div>
  </div>
</div>

<!-- Dynamic Add More JavaScript -->
<script>
  let count = 1;

  // 1. Add Button Par Click
  document.getElementById('add-more-btn').addEventListener('click', function () {
    count++; // Step counter 2, 3, 4... karega

    // HTML Structure jo naya box banayega
    let newPromptBox = `
      <div class="prompt-card border rounded p-3 mb-3 bg-light" id="box-${count}">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="badge bg-primary">Prompt #${count}</span>
          <button type="button" class="btn btn-danger btn-sm text-white" onclick="deleteBox('box-${count}')">Remove</button>
        </div>

        <div class="form-group mb-2">
          <label>Prompt Step / Title (Optional)</label>
          <input type="text" name="prompts[${count - 1}][label]" class="form-control" placeholder="e.g. Step ${count}: Content Rephraser">
        </div>

        <div class="form-group mb-0">
          <label>Prompt Text <span class="text-danger">*</span></label>
          <textarea name="prompts[${count - 1}][text]" class="form-control" rows="3" placeholder="Write your complete prompt here..." required></textarea>
        </div>
      </div>
    `;

    // Direct container mein HTML add kar do
    document.getElementById('prompts-container').insertAdjacentHTML('beforeend', newPromptBox);
  });

  // 2. Remove Button Par Click (Box Delete karne ke liye)
  function deleteBox(boxId) {
    document.getElementById(boxId).remove();
  }
</script>
@endsection