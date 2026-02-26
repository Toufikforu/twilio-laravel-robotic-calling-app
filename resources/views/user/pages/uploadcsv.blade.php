@extends('layouts.main')

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">

      <div class="card shadow-sm">

{{-- HEADER --}}
<div class="card-header bg-dark text-white">
  <div class="d-flex flex-column flex-md-row justify-content-between gap-3">

    {{-- Left: Title + Upload Form --}}
    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3">
      <h5 class="mb-0 brand-text">Upload CSV</h5>

      <form method="POST"
            action="{{ route('call-leads.upload.store') }}"
            enctype="multipart/form-data"
            class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-2">
        @csrf

        <input type="file"
               name="csv"
               class="form-control form-control-sm"
               style="max-width:260px;"
               accept=".csv,text/csv"
               required>

        <button type="submit" class="btn btn-sm btn-success">
          Import
        </button>
      </form>
    </div>

    {{-- Right: Totals + Pagination --}}
    <div class="d-flex flex-column align-items-start align-items-md-end text-md-end">

      <span class="btn btn-sm brand-bg text-white mb-1">
        Total Contacts:
        <strong>{{ $total ?? ($leads->total() ?? 0) }}</strong>
      </span>

      @if(isset($leads) && $leads instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="small text-white-50">
          Showing <strong>{{ $leads->firstItem() ?? 0 }}</strong>
          to <strong>{{ $leads->lastItem() ?? 0 }}</strong>
          of <strong>{{ $leads->total() }}</strong> entries
        </div>
      @endif

    </div>

  </div>
</div>

        {{-- BODY --}}
        <div class="card-body">

          {{-- Success / Error Messages --}}
          @if (session('success'))
            <div class="alert alert-success">
              {{ session('success') }}
            </div>
          @endif

          @if (session('error'))
            <div class="alert alert-danger">
              {{ session('error') }}
            </div>
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

          {{-- TABLE --}}
          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
              <thead>
                <tr>
                  <th style="width:20%;">First Name</th>
                  <th style="width:20%;">Last Name</th>
                  <th style="width:20%;">Phone</th>
                  <th style="width:15%;">Status</th>
                  <th style="width:25%;">Call Date</th>
                </tr>
              </thead>

              <tbody>
                @if(isset($leads) && $leads->count())

                  @foreach($leads as $lead)
                    <tr>
                      <td>{{ $lead->first_name }}</td>
                      <td>{{ $lead->last_name }}</td>
                      <td>{{ $lead->phone }}</td>

                      <td>
                        @php $status = strtolower($lead->status ?? 'pending'); @endphp

                        @if($status === 'pending')
                          <span class="badge bg-secondary">Pending</span>

                        @elseif($status === 'queued')
                          <span class="badge bg-primary">Queued</span>

                        @elseif($status === 'calling')
                          <span class="badge bg-info text-dark">Calling</span>

                        @elseif($status === 'completed')
                          <span class="badge bg-success">Completed</span>

                        @elseif($status === 'failed')
                          <span class="badge bg-danger">Failed</span>

                        @elseif($status === 'no_answer')
                          <span class="badge bg-warning text-dark">No Answer</span>

                        @else
                          <span class="badge bg-dark">
                            {{ ucfirst($status) }}
                          </span>
                        @endif
                      </td>

                      <td>
                        {{ $lead->call_date
                            ? \Carbon\Carbon::parse($lead->call_date)->format('Y-m-d h:i A')
                            : '—'
                        }}
                      </td>
                    </tr>
                  @endforeach

                @else
                  <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                      No records found.
                    </td>
                  </tr>
                @endif
              </tbody>

            </table>

            @if(isset($leads) && $leads instanceof \Illuminate\Pagination\LengthAwarePaginator)
              <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mt-3 gap-2">

                <div class="small text-muted">
                  Showing
                  <strong>{{ $leads->firstItem() ?? 0 }}</strong>
                  to
                  <strong>{{ $leads->lastItem() ?? 0 }}</strong>
                  of
                  <strong>{{ $leads->total() }}</strong>
                  entries
                </div>

                <div>
                  {{ $leads->links() }}
                </div>

              </div>
            @endif
          </div>



        </div>

      </div>

    </div>
  </div>
</div>

@endsection