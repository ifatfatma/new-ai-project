@extends('layouts.backlayout')

@section('content')


@if ($errors->any())
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        
        <h4 class="card-title">Add New Prompts</h4>
        <p class="card-description">Select category and enter multiple prompts using the <strong>Add More</strong> option.</p>

        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <form action="{{ route('admin.prompts.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="row">
            <div class="col-md-6 form-group mb-3">
              <label class="fw-bold">Select Category</label>
              <select name="category_id" class="form-control" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6 form-group mb-3">
              <label class="fw-bold">Prompt Collection / Topic Title</label>
              <input type="text" name="title" class="form-control" placeholder="e.g. SEO Article Blueprint" required>
            </div>
          </div>

          <hr class="my-3">

          <h5 class="mb-3 fw-bold">Prompts List</h5>
          <div id="prompts-container">
            
            <!-- Default First Prompt Box -->
            <div class="prompt-card border rounded p-3 mb-3 bg-light" id="prompt-block-0">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <span class="badge bg-primary">Prompt #1</span>
  </div>

  <div class="mb-3">
    <label for="ai_tool" class="fw-bold">AI Tool / Platform (e.g. ChatGPT, Midjourney)</label>
    <input type="text" name="prompts[0][ai_tool]" class="form-control" value="{{ old('prompts.0.ai_tool') }}" placeholder="ChatGPT">
  </div>

  <div class="form-group mb-2">
    <label>Prompt Step / Title (Optional)</label>
    <input type="text" name="prompts[0][label]" class="form-control" placeholder="e.g. Step 1: Catchy Headline Generator">
  </div>

  <div class="form-group mb-2">
    <label>Prompt Text <span class="text-danger">*</span></label>
    <textarea name="prompts[0][text]" class="form-control" rows="3" placeholder="Write your complete prompt here..." required></textarea>
  </div>

  <div class="form-group mb-0">
    <label>Example Output Image (Optional)</label>
    <div class="input-group">
      <input type="file" name="prompts[0][image]" id="img_0" class="form-control" accept="image/*">
      <button type="button" class="btn btn-outline-secondary" onclick="clearInput('img_0')">Clear Image</button>
    </div>
  </div>
</div>

          </div>

          <div class="mb-4">
            <button type="button" id="add-more-btn" class="btn btn-outline-primary btn-sm fw-bold">
              <i class="mdi mdi-plus"></i> Add More Prompt
            </button>
          </div>

          <button type="submit" class="btn btn-success text-white">Save All Prompts</button>
        </form>

      </div>
    </div>
  </div>
</div>

<script>
  let count = 1;

  document.getElementById('add-more-btn').addEventListener('click', function () {
    let index = count;
    count++;

    let newPromptBox = `
      <div class="prompt-card border rounded p-3 mb-3 bg-light" id="box-${index}">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="badge bg-primary">Prompt #${index + 1}</span>
          <button type="button" class="btn btn-danger btn-sm text-white" onclick="deleteBox('box-${index}')">Remove Box</button>
        </div>

        <div class="form-group mb-3">
          <label class="fw-bold">AI Tool / Platform (e.g. ChatGPT, Midjourney)</label>
          <input type="text" name="prompts[${index}][ai_tool]" class="form-control" placeholder="ChatGPT">
        </div>

        <div class="form-group mb-2">
          <label>Prompt Step / Title (Optional)</label>
          <input type="text" name="prompts[${index}][label]" class="form-control" placeholder="e.g. Step ${index + 1}: Content Rephraser">
        </div>

        <div class="form-group mb-2">
          <label>Prompt Text <span class="text-danger">*</span></label>
          <textarea name="prompts[${index}][text]" class="form-control" rows="3" placeholder="Write your complete prompt here..." required></textarea>
        </div>

        <div class="form-group mb-0">
          <label>Example Output Image (Optional)</label>
          <div class="input-group">
            <input type="file" name="prompts[${index}][image]" id="img_${index}" class="form-control" accept="image/*">
            <button type="button" class="btn btn-outline-secondary" onclick="clearInput('img_${index}')">Clear Image</button>
          </div>
        </div>
      </div>
    `;

    document.getElementById('prompts-container').insertAdjacentHTML('beforeend', newPromptBox);
  });

  function deleteBox(boxId) {
    document.getElementById(boxId).remove();
  }

  function clearInput(inputId) {
    document.getElementById(inputId).value = "";
  }
</script>
@endsection