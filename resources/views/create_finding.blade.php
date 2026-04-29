@extends('layouts.app')

@section('content')
<div class="page-container fade-in">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg glow-border">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="bi bi-shield-plus text-green"></i> 
                    <span style="font-family:'JetBrains Mono', monospace; font-weight:700; text-transform:uppercase; letter-spacing:1px;">Report New Vulnerability</span>
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

                    <form method="POST" action="{{ route('findings.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label"><i class="bi bi-bug me-1"></i> Vulnerability Name</label>
                                <input type="text" name="name" class="form-control font-mono" placeholder="e.g., Cross-Site Scripting (XSS)" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label"><i class="bi bi-card-text me-1"></i> Description</label>
                                <textarea name="description" class="form-control" rows="5" placeholder="Describe the vulnerability, impact, and steps to reproduce..." required></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><i class="bi bi-fire me-1"></i> Severity</label>
                                <select name="severity" class="form-select font-mono" required>
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                    <option value="Critical">Critical</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><i class="bi bi-activity me-1"></i> Status</label>
                                <select name="status" class="form-select font-mono" required>
                                    <option value="Open">Open</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Fixed">Fixed</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="image" class="form-label"><i class="bi bi-image me-1"></i> Proof of Concept (Screenshot)</label>
                                <div class="p-3 border rounded" style="background:rgba(var(--navy-950-rgb),0.2); border-color:rgba(var(--green-400-rgb),0.1) !important;">
                                    <input type="file" name="image" id="image" class="form-control font-mono" accept="image/*" style="background:transparent !important; border:none !important; box-shadow:none !important; padding:0 !important;">
                                </div>
                            </div>

                            <div class="col-12 mt-4 d-flex justify-content-end gap-2">
                                <a href="{{ route('home') }}" class="btn-ghost text-decoration-none d-inline-flex align-items-center gap-2">
                                    <i class="bi bi-x-lg"></i> Cancel
                                </a>
                                <button type="submit" class="btn-green d-inline-flex align-items-center gap-2">
                                    <i class="bi bi-send-check"></i> Submit Finding
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
