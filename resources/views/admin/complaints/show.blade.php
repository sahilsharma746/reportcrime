@extends('layouts.app')

@section('title', 'Report Details')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h1 class="mb-4">Report Details</h1>
        <button id="printButton" class="btn btn-secondary mb-3">Print</button>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Report #{{ $complaint->complaint_number }}</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p class="card-text"><strong>Status:</strong> {{ \Illuminate\Support\Str::headline($complaint->status) }}</p>
                        <p class="card-text"><strong>Type:</strong> {{ \Illuminate\Support\Str::headline($complaint->complaint_type) }}</p>
                        @if($complaint->status === 'completed')
                            <p class="card-text"><strong>Closed Date:</strong> {{ $complaint->updated_at }}</p>
                        @endif
                        <p class="card-text"><strong>Created By:</strong> {{ $complaint->user->name ?? 'Anonymous' }}</p>
                        <p class="card-text"><strong>Address:</strong> {{ $complaint->user->address ?? '' }}</p>
                        <p class="card-text"><strong>City:</strong> {{ $complaint->user->city ?? '' }}</p>
                        <p class="card-text"><strong>State:</strong> {{ $complaint->user->state ?? '' }}</p>
                        <p class="card-text"><strong>Zip:</strong> {{ $complaint->user->zip ?? '' }}</p>
                        @if(!is_null($complaint->assignedTo))
                            <p class="card-text"><strong>Assigned to:</strong> {{ $complaint->assignedTo->name }}</p>
                        @endif
                        <p class="card-text"><strong>Description:</strong> {{ $complaint->description }}</p>
                        <p class="card-text"><strong>Incident Date:</strong> {{ $complaint->incident_date }}</p>
                        @if(!is_null($complaint->city))
                            <p class="card-text"><strong>Incident Location:</strong> {{ $complaint->city->name }}, {{ $complaint->city->state->name }}</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6 class="mt-4">Accused Information</h6>
                        <p class="card-text"><strong>Name:</strong> {{ $complaint->officer->name ?? '' }}</p>
                        <p class="card-text"><strong>Location:</strong> {{ $complaint->officer->division ?? '' }}</p>
                    </div>
                </div>

                <h6 class="mt-5">Attachments</h6>
                @if($complaint->attachments->count() > 0)
                    <ul class="list-group mb-3">
                        @foreach($complaint->attachments as $attachment)
                            <li class="list-group-item">
                                <a href="{{ Storage::url($attachment->file_path) }}"
                                   target="_blank">{{ $attachment->file_name }}</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No attachments for this complaint.</p>
                @endif
            </div>
        </div>

        @if(auth()->user()->role == "admin" && $complaint->status !== 'completed')
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title mb-3">Assign Report</h2>
                    <form action="{{ route('admin.complaints.assign', $complaint) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="assigned_to" class="form-label">Assign to Subadmin</label>
                            <select class="form-control" id="assigned_to" name="assigned_to" required>
                                <option value="">Select Subadmin</option>
                                @foreach($subadmins as $subadmin)
                                    <option value="{{ $subadmin->id }}" {{ $complaint->assigned_to == $subadmin->id ? 'selected' : '' }}>
                                        {{ $subadmin->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Assign Report</button>
                    </form>
                </div>
            </div>
        @endif

        @if($complaint->status !== 'completed')
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title mb-3">Update Status</h2>
                        <form action="{{ route('admin.complaints.update-status', $complaint) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status" required {{ $complaint->status === 'completed' ? 'disabled' : '' }}>
                                    <option value="pending" {{ $complaint->status === 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="in_progress" {{ $complaint->status === 'in_progress' ? 'selected' : '' }}>In
                                        Progress
                                    </option>
                                    <option value="submitted" {{ $complaint->status === 'submitted' ? 'selected' : '' }}>Submitted
                                    </option>
                                    <option value="under_review" {{ $complaint->status === 'under_review' ? 'selected' : '' }}>
                                        Under Review
                                    </option>
                                    <option value="completed" {{ $complaint->status === 'completed' ? 'selected' : '' }}>
                                        Completed
                                    </option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Update Status
                            </button>
                        </form>
                </div>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title mb-3">Internal Notes</h2>
                @foreach($complaint->notes as $note)
                    <div class="card mb-2">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">{{ $note->user->name }}
                                - {{ $note->created_at->format('M d, Y H:i') }}</h6>
                            <p class="card-text">{{ $note->content }}</p>
                            @if($note->attachments->count() > 0)
                                <h6>Attachments</h6>
                                <ul class="list-group mb-3">
                                    @foreach($note->attachments as $attachment)
                                        <li class="list-group-item">
                                            <a href="{{ Storage::url($attachment->file_path) }}" target="_blank">{{ $attachment->file_name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endforeach

                @if($complaint->status !== 'completed')
                    <form action="{{ route('complaints.add-note', $complaint) }}" method="POST" class="mt-3" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="note_content" class="form-label">New Note</label>
                            <textarea class="form-control" id="note_content" name="content" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="note_attachments" class="form-label">Attachments</label>
                            <input type="file" class="form-control" id="note_attachments" name="attachments[]" multiple>
                        </div>
                            <button type="submit" class="btn btn-primary">Add Note</button>
                    </form>
                @endif
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title mb-3">Messages</h2>
                @foreach($complaint->messages as $message)
                    <div class="card mb-2">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">{{ $message->sender->name }}
                                - {{ $message->created_at->format('M d, Y H:i') }}</h6>
                            <p class="card-text">{{ $message->content }}</p>
                        </div>
                    </div>
                @endforeach

                @if($complaint->status !== 'completed')
                    <form action="{{ route('messages.store', $complaint) }}" method="POST" class="mt-3">
                        @csrf
                        <div class="mb-3">
                            <label for="message_content" class="form-label">New Message</label>
                            <textarea class="form-control" id="message_content" name="content" rows="3" required></textarea>
                        </div>
                            <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var statusSelect = document.getElementById('status');
    var form = statusSelect.closest('form');

    function updateFields() {
      var status = statusSelect.value;
      var outcomeField = document.getElementById('outcomeField');
      var actionTakenField = document.getElementById('actionTakenField');

      if (status === 'completed') {

        if (!actionTakenField) {
          actionTakenField = document.createElement('div');
          actionTakenField.className = 'mb-3';
          actionTakenField.id = 'actionTakenField';
          actionTakenField.innerHTML = `
                            <label for="action_taken" class="form-label">Action Taken</label>
                            <textarea class="form-control" id="action_taken" name="action_taken" rows="3"></textarea>
                        `;
          form.insertBefore(actionTakenField, form.querySelector('button'));
        }
      } else {
        if (actionTakenField) {
          actionTakenField.remove();
        }
      }
    }

    statusSelect.addEventListener('change', updateFields);

    // Call updateFields initially to set the correct state
    updateFields();
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // when clicked printButton it will trigger print dialog
    document.getElementById('printButton').addEventListener('click', function() {
      window.print();
    });
  });
</script>
