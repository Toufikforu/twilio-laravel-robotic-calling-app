@extends('layouts.main')

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">

      <div class="card shadow-sm">

        {{-- HEADER --}}
        <div class="card-header bg-dark text-white">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 brand-text">Call Logs</h5>

            <div class="text-muted small">
              Total Calls: {{ \App\Models\CallLead::count() }}
            </div>
          </div>
        </div>

        {{-- BODY --}}
        <div class="card-body">

          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
              <thead>
                <tr>
                  <th style="width:15%;">First Name</th>
                  <th style="width:15%;">Last Name</th>
                  <th style="width:15%;">Phone</th>
                  <th style="width:15%;">Campaign</th>
                  <th style="width:10%;">Status</th>
                  <th style="width:10%;">Duration</th>
                  <th style="width:20%;">Call Date</th>
                </tr>
              </thead>

              <tbody>

                @forelse($logs as $log)
                  <tr>
                      <td>{{ $log->first_name }}</td>
                      <td>{{ $log->last_name }}</td>
                      <td>{{ $log->phone }}</td>
                      <td>{{ $log->campaign->name ?? '-' }}</td>

                      <td>
                          <span class="badge bg-primary">
                              {{ ucfirst($log->status ?? 'pending') }}
                          </span>
                      </td>

                      <td>
                          {{ $log->duration ?? '--' }}
                      </td>

                      <td>
                          {{ $log->call_date ? \Carbon\Carbon::parse($log->call_date)->format('Y-m-d h:i A') : '--' }}
                      </td>
                  </tr>
                  @empty
                  <tr>
                      <td colspan="7" class="text-center text-muted py-4">
                          No call logs yet. Start a campaign to generate call records.
                      </td>
                  </tr>
                  @endforelse

              </tbody>
            </table>
          </div>

          <div class="mt-3 text-muted small">
            MVP version — filtering, exporting, and search can be added in Phase 2.
          </div>

        </div>

      </div>

    </div>
  </div>
</div>

@endsection