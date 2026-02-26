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
              Total Calls: 124
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

                {{-- Demo Row 1 --}}
                <tr>
                  <td>Maria</td>
                  <td>Lopez</td>
                  <td>+1 954-555-1234</td>
                  <td>Early Vote Reminder</td>
                  <td>
                    <span class="badge bg-success">Completed</span>
                  </td>
                  <td>00:42</td>
                  <td>2026-02-20 09:42 AM</td>
                </tr>

                {{-- Demo Row 2 --}}
                <tr>
                  <td>John</td>
                  <td>Smith</td>
                  <td>+1 407-555-7788</td>
                  <td>GOTV Push</td>
                  <td>
                    <span class="badge bg-warning text-dark">No Answer</span>
                  </td>
                  <td>00:00</td>
                  <td>2026-02-20 10:15 AM</td>
                </tr>

                {{-- Demo Row 3 --}}
                <tr>
                  <td>Angela</td>
                  <td>Davis</td>
                  <td>+1 305-555-9090</td>
                  <td>Follow-Up Calls</td>
                  <td>
                    <span class="badge bg-danger">Failed</span>
                  </td>
                  <td>00:05</td>
                  <td>2026-02-19 05:18 PM</td>
                </tr>

                {{-- Demo Row 4 --}}
                <tr>
                  <td>Robert</td>
                  <td>Green</td>
                  <td>+1 561-555-2222</td>
                  <td>GOTV Push</td>
                  <td>
                    <span class="badge bg-primary">In Progress</span>
                  </td>
                  <td>--</td>
                  <td>2026-02-20 11:02 AM</td>
                </tr>

                {{-- Optional Empty State --}}
                {{--
                <tr>
                  <td colspan="7" class="text-center text-muted py-4">
                    No call logs available.
                  </td>
                </tr>
                --}}

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