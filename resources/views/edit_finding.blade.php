@extends('layouts.app')

@section('content')
<div class="page-container fade-in">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg glow-border">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-pencil-square text-green"></i> 
                        <span style="font-family:'JetBrains Mono', monospace; font-weight:700; text-transform:uppercase; letter-spacing:1px;">Edit Vulnerability</span>
                    </div>
                    <span class="id-badge">ID: #{{ $finding->id }}</span>
                </div>

                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger d-flex align-items-start gap-2">
                            <i class="bi bi-exclamation-triangle-fill mt-1"></i>
                            <div>
                                <strong>System Error!</strong> Please correct the following inputs:
                                <ul class="mb-0 mt-1" style="font-family:'JetBrains Mono', monospace; font-size:0.8rem;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('findings.update', $finding->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label"><i class="bi bi-bug me-1"></i> Vulnerability Name</label>
                                <input type="text" name="name" class="form-control font-mono" value="{{ $finding->title ?? $finding->name }}" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label"><i class="bi bi-card-text me-1"></i> Description</label>
                                <textarea name="description" class="form-control" rows="5" required>{{ $finding->description }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><i class="bi bi-fire me-1"></i> Severity</label>
                                <select name="severity" class="form-select font-mono" required>
                                    <option value="Low" {{ $finding->severity == 'Low' ? 'selected' : '' }}>Low</option>
                                    <option value="Medium" {{ $finding->severity == 'Medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="High" {{ $finding->severity == 'High' ? 'selected' : '' }}>High</option>
                                    <option value="Critical" {{ $finding->severity == 'Critical' ? 'selected' : '' }}>Critical</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><i class="bi bi-activity me-1"></i> Status</label>
                                <select name="status" class="form-select font-mono" required>
                                    <option value="Open" {{ $finding->status == 'Open' ? 'selected' : '' }}>Open</option>
                                    <option value="In Progress" {{ $finding->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="Fixed" {{ $finding->status == 'Fixed' ? 'selected' : '' }}>Fixed</option>
                                </select>
                            </div>

                            <div class="col-12 mt-4 d-flex justify-content-end gap-2">
                                <a href="{{ route('home') }}" class="btn-ghost text-decoration-none d-inline-flex align-items-center gap-2">
                                    <i class="bi bi-x-lg"></i> Cancel
                                </a>
                                <button type="submit" class="btn-green d-inline-flex align-items-center gap-2">
                                    <i class="bi bi-save"></i> Update Finding
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
