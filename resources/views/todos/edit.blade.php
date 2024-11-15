@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Todo</div>
                    <div class="card-body">
                        <form action="{{ route('todos.update', $todo->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ $todo->title }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="5" cols="5" required>{{ $todo->description }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="0" {{ !$todo->status ? 'selected' : '' }}>Not Completed</option>
                                    <option value="1" {{ $todo->status ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="priority" class="form-label">Priority</label>
                                <select class="form-select" id="priority" name="priority" required>
                                    <option value="1" {{ $todo->priority == 1 ? 'selected' : '' }}>High</option>
                                    <option value="2" {{ $todo->priority == 2 ? 'selected' : '' }}>Medium</option>
                                    <option value="3" {{ $todo->priority == 3 ? 'selected' : '' }}>Low</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Todo</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
