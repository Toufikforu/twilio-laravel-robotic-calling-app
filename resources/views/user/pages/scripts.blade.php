@extends('layouts.main')

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">

      <div class="card shadow-sm">

        {{-- HEADER --}}
        <div class="card-header bg-dark text-white">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 brand-text">Scripts</h5>

            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#newScriptModal">
              <i class="fa-solid fa-plus me-1"></i> New Script
            </button>
          </div>
        </div>

        {{-- BODY --}}
<div class="card-body">

  {{-- Flash / Validation Messages --}}
  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Table --}}
  <div class="table-responsive">
    <table class="table table-striped table-hover align-middle mb-0">
      <thead>
        <tr>
          <th style="width:80%;">Script</th>
          <th class="text-center" style="width:5%;">Play</th>
          <th class="text-center" style="width:10%;">Edit</th>
          <th class="text-center" style="width:10%;">Delete</th>
        </tr>
      </thead>

      <tbody>
        @if(isset($scripts) && $scripts->count())

          @foreach($scripts as $script)
            <tr>
              <td>
                @if(!empty($script->name))
                  <div class="fw-semibold">{{ $script->name }}</div>
                @endif
                <div class="text-muted small" style="white-space: normal;">
                  {{ $script->content }}
                </div>
              </td>

              {{-- Play --}}
              <td class="text-center">
                <button type="button"
                        class="btn btn-sm btn-outline-success"
                        onclick="playText(`{{ addslashes($script->content) }}`)">
                  <i class="fa-solid fa-play"></i>
                </button>
              </td>

              {{-- Edit --}}
              <td class="text-center">
                <button type="button"
                        class="btn btn-sm btn-outline-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#editScriptModal-{{ $script->id }}">
                  <i class="fa-solid fa-pen-to-square"></i>
                </button>
              </td>

              {{-- Delete --}}
              <td class="text-center">
                <form method="POST"
                      action="{{ route('scripts.destroy', $script->id) }}"
                      onsubmit="return confirm('Delete this script?');"
                      class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </form>
              </td>
            </tr>

            {{-- Edit Script Modal (per row, MVP) --}}
            <div class="modal fade" id="editScriptModal-{{ $script->id }}" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                  <div class="modal-header">
                    <h5 class="modal-title">Edit Script</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <form method="POST" action="{{ route('scripts.update', $script->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                      <div class="mb-3">
                        <label class="form-label">Script Name (optional)</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name', $script->name) }}"
                               maxlength="120">
                      </div>

                      <div class="mb-3">
                        <label class="form-label">Script Content</label>
                        <textarea name="content"
                                  class="form-control"
                                  rows="5"
                                  required>{{ old('content', $script->content) }}</textarea>
                        <small class="text-muted">You can use placeholders like: <code>{first_name}</code></small>
                      </div>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form>

                </div>
              </div>
            </div>

            <script>
            function playText(text) {
                const speech = new SpeechSynthesisUtterance(text);
                speech.lang = 'en-US'; // change if needed
                speech.rate = 1;       // speed (1 = normal)
                speech.pitch = 1;      // voice tone

                window.speechSynthesis.cancel(); // stop previous
                window.speechSynthesis.speak(speech);
            }
            </script>

          @endforeach

        @else
          <tr>
            <td colspan="3" class="text-center text-muted py-4">
              No scripts created yet.
            </td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>

</div>

{{-- New Script Modal (single) --}}
<div class="modal fade" id="newScriptModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">New Script</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" action="{{ route('scripts.store') }}">
        @csrf

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Script Name (optional)</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" maxlength="120">
          </div>

          <div class="mb-3">
            <label class="form-label">Script Content</label>
            <textarea name="content" class="form-control" rows="5" required>{{ old('content') }}</textarea>
            <small class="text-muted">Placeholders: <code>{first_name}</code> <code>{last_name}</code></small>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Create Script</button>
        </div>
      </form>

    </div>
  </div>
</div>

      </div>

    </div>
  </div>
</div>

@endsection