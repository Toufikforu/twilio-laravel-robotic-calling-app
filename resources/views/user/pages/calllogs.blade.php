<tbody>

@forelse($logs as $log)
<tr>
    <td>{{ $log->first_name }}</td>
    <td>{{ $log->last_name }}</td>
    <td>{{ $log->phone }}</td>
    <td>{{ $log->campaign->name ?? '-' }}</td>

    <td>
        @if($log->status == 'completed')
            <span class="badge bg-success">Completed</span>
        @elseif($log->status == 'calling')
            <span class="badge bg-primary">Calling</span>
        @elseif($log->status == 'failed')
            <span class="badge bg-danger">Failed</span>
        @elseif($log->status == 'no-answer')
            <span class="badge bg-warning text-dark">No Answer</span>
        @else
            <span class="badge bg-secondary">{{ ucfirst($log->status) }}</span>
        @endif
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
        No call logs available.
    </td>
</tr>
@endforelse

</tbody>