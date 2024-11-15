@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5>Todo Details</h5>
        </div>
        <div class="card-body">
            <p><strong>Title:</strong> {{ $todo->title }}</p>
            <p><strong>Description:</strong> {{ $todo->description }}</p>
            <p><strong>Priority:</strong> 
                @if ($todo->priority == 1)
                    <span class="badge bg-danger">High</span>
                @elseif ($todo->priority == 2)
                    <span class="badge bg-warning">Medium</span>
                @else
                    <span class="badge bg-info">Low</span>
                @endif
            </p>
            <p><strong>Status:</strong> 
                @if ($todo->status)
                    <span class="badge bg-success">Completed</span>
                @else
                    <span class="badge bg-danger">Not Completed</span>
                @endif
            </p>
            <p><strong>Created At:</strong> {{ $todo->created_at->format('d M Y, h:i A') }}</p>
            <p><strong>Updated At:</strong> {{ $todo->updated_at->format('d M Y, h:i A') }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('todos.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection
