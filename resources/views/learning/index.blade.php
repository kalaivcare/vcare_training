@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Daily Learning Progress Entry</h3>

    {{-- Success & Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Entry Form --}}
    <form method="POST" action="{{ route('learning.store') }}" id="learningForm">
        @csrf
        <div class="mb-3">
            <label for="learning_date" class="form-label">Select Date</label>
            <input type="date" name="learning_date" id="learning_date" class="form-control" required 
                   max="{{ now()->toDateString() }}">
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">What did you learn today?</label>
            <textarea name="content" id="content" class="form-control" rows="6" required></textarea>
            <small id="wordCount" class="text-muted">0 words</small>
        </div>

        <button type="submit" class="btn btn-primary">Save Entry</button>
    </form>

    <hr class="my-4">

    {{-- Entries Table --}}
    <h4>Your Previous Entries</h4>
    <table class="table table-bordered mt-3">
        <thead class="table-light">
            <tr>
                <th>Date</th>
                <th>Content</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($entries as $entry)
                <tr>
                    <td>{{ $entry->learning_date }}</td>
                    {{-- <td>{{ Str::limit($entry->content, 100) }}</td> --}}
                    <td>{{ \Illuminate\Support\Str::limit($entry->content, 100) }}</td>
                    <td>
                        @if($entry->learning_date == now()->toDateString())
                            <span class="badge bg-success">Editable Today</span>
                        @else
                            <span class="badge bg-secondary">Locked</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center">No entries yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- JS Validation --}}
<script>
document.getElementById('content').addEventListener('input', function() {
    let text = this.value.trim();
    let wordCount = text.split(/\s+/).filter(word => word.length > 0).length;
    document.getElementById('wordCount').innerText = wordCount + " words";

    if (wordCount < 100) {
        this.setCustomValidity("Minimum 100 words required.");
    } else {
        this.setCustomValidity("");
    }
});
</script>
@endsection
