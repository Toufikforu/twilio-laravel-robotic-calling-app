@extends('layouts.main')

@section('content')

<div class="container">
<div class="row justify-content-center">
<div class="col-md-12">

<div class="card shadow-sm">

<div class="card-header bg-dark text-white d-flex justify-content-between">
    <h5 class="mb-0">Campaigns</h5>
    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#newCampaignModal">
        <i class="fa fa-plus"></i> New Campaign
    </button>
</div>

<div class="card-body">

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-striped">
<thead>
<tr>
<th>Name</th>
<th>Script</th>
<th>Status</th>
<th>Total</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
@forelse($campaigns as $campaign)
<tr>
<td>{{ $campaign->name }}</td>
<td>{{ $campaign->script->name ?? 'N/A' }}</td>
<td>
<span class="badge bg-{{ $campaign->status == 'running' ? 'success' : ($campaign->status == 'draft' ? 'secondary' : 'danger') }}">
{{ ucfirst($campaign->status) }}
</span>
</td>
<td>{{ $campaign->total_leads }}</td>
<td>

@if($campaign->status != 'running')
<form method="POST" action="{{ route('campaigns.start', $campaign->id) }}" class="d-inline">
@csrf
<button class="btn btn-sm btn-outline-success">
<i class="fa fa-play"></i>
</button>
</form>
@endif

@if($campaign->status == 'running')
<form method="POST" action="{{ route('campaigns.stop', $campaign->id) }}" class="d-inline">
@csrf
<button class="btn btn-sm btn-outline-danger">
<i class="fa fa-stop"></i>
</button>
</form>
@endif

</td>
</tr>
@empty
<tr>
<td colspan="5" class="text-center text-muted">No campaigns created.</td>
</tr>
@endforelse
</tbody>
</table>

</div>
</div>
</div>
</div>
</div>

{{-- New Campaign Modal --}}
<div class="modal fade" id="newCampaignModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST" action="{{ route('campaigns.store') }}">
@csrf
<div class="modal-header">
<h5 class="modal-title">Create Campaign</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<div class="mb-3">
<label>Campaign Name</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
<label>Select Script</label>
<select name="script_id" class="form-control" required>
<option value="">-- Select Script --</option>
@foreach($scripts as $script)
<option value="{{ $script->id }}">{{ $script->name ?? 'Script #' . $script->id }}</option>
@endforeach
</select>
</div>
</div>

<div class="modal-footer">
<button type="submit" class="btn btn-success">Create</button>
</div>

</form>
</div>
</div>
</div>

@endsection