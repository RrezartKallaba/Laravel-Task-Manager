@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success" id="message">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('todos.create') }}" class="btn btn-primary">Create New Todo</a>
        
        <div>
            <!-- Filter for completed/uncompleted tasks -->
            <a href="{{ route('todos.index') }}" 
               class="btn btn-outline-primary {{ !request('filter') ? 'active' : '' }}">
                All
            </a>
            <a href="{{ route('todos.index', ['filter' => 'uncompleted']) }}" 
               class="btn btn-outline-danger {{ request('filter') == 'uncompleted' ? 'active' : '' }}">
                Show Uncompleted
            </a>
            <a href="{{ route('todos.index', ['filter' => 'completed']) }}" 
               class="btn btn-outline-success {{ request('filter') == 'completed' ? 'active' : '' }}">
                Show Completed
            </a>
        </div>
    </div>

    <div class="d-flex justify-content-end align-items-center mb-3">
        <!-- Filter for priority -->
        <form action="{{ route('todos.index') }}" method="GET" class="d-flex align-items-center">
            <label class="me-2 mb-0">Filter by Priority:</label>
            <div class="d-flex">
                <div class="form-check me-3">
                    <input type="checkbox" name="priority[]" value="1" 
                           class="form-check-input"
                           {{ in_array('1', request('priority', [])) ? 'checked' : '' }}>
                    <label class="form-check-label">High</label>
                </div>
                <div class="form-check me-3">
                    <input type="checkbox" name="priority[]" value="2" 
                           class="form-check-input"
                           {{ in_array('2', request('priority', [])) ? 'checked' : '' }}>
                    <label class="form-check-label">Medium</label>
                </div>
                <div class="form-check me-3">
                    <input type="checkbox" name="priority[]" value="3" 
                           class="form-check-input"
                           {{ in_array('3', request('priority', [])) ? 'checked' : '' }}>
                    <label class="form-check-label">Low</label>
                </div>
            </div>
            <button type="submit" class="btn btn-sm btn-outline-primary ms-2 mt-2">Apply Filter</button>
        </form>
    </div>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Todo ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @php
                $filteredTodos = $todos->filter(function ($todo) {
                    // Filter by completed status
                    if (request('filter') == 'completed' && !$todo->status) return false;
                    if (request('filter') == 'uncompleted' && $todo->status) return false;
                    
                    // Filter by priority
                    $priorities = request('priority', []);
                    if (!empty($priorities) && !in_array($todo->priority, $priorities)) {
                        return false;
                    }

                    return true;
                });

                // Sort by priority (descending) and then by created_at (descending)
                $filteredTodos = $filteredTodos->sortByDesc(function ($todo) {
                    return $todo->priority; // High priority first
                })->sortByDesc('created_at'); // Then sort by created_at (most recent first)
            @endphp

            @forelse ($filteredTodos as $todo)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $todo->id }}</td>
                    <td>
                        <!-- Apply strikethrough for completed tasks -->
                        @if ($todo->status)
                            <del>{{ $todo->title }}</del> <!-- Strikethrough for completed task -->
                        @else
                            {{ $todo->title }}
                        @endif
                    </td>
                    <td>
                        <!-- Apply strikethrough for completed tasks -->
                        @if ($todo->status)
                            <del>{{ $todo->description }}</del> <!-- Strikethrough for completed task -->
                        @else
                            @if (strlen($todo->description) > 30)
                                {{ substr($todo->description, 0, 30) }}...
                            @else
                                {{ $todo->description }}
                            @endif
                        @endif
                    </td>
                    <td>
                        @if ($todo->priority == 1)
                            <span class="badge bg-danger">High</span>
                        @elseif ($todo->priority == 2)
                            <span class="badge bg-warning">Medium</span>
                        @else
                            <span class="badge bg-info">Low</span>
                        @endif
                    </td>
                    <td>
                        @if ($todo->status)
                            <span class="badge bg-success">Completed</span>
                        @else
                            <span class="badge bg-danger">Not Completed</span>
                        @endif
                    </td>
                    <td>{{ $todo->created_at->format('d M Y, h:i A') }}</td>
                    <td>
                        <a href="{{ route('todos.show', $todo->id) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('todos.edit', $todo->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No todos found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var message = document.getElementById('message');

        if (message) {
            setTimeout(function() {
                message.style.display = 'none';
            }, 3000); //3 seconds
        }
    });
</script>
@endsection
