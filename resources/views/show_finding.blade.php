@extends('layouts.app')

@section('content')
<div class="page-container fade-in">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg glow-border mb-4">
                <div class="card-header d-flex justify-content-between align-items-center p-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-code text-green"></i>
                        <h5 class="mb-0 font-mono text-uppercase" style="letter-spacing:1px;">Vulnerability Report</h5>
                    </div>
                    <span class="id-badge px-3 py-2 fs-6">ID: #{{ $finding->id }}</span>
                </div>

                <div class="card-body p-4 p-md-5">
                    
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <h2 class="mb-0 text-white font-mono" style="font-size:2rem; font-weight:700;">{{ $finding->title ?? $finding->name }}</h2>
                        
                        <div class="d-flex flex-column gap-2 text-end">
                            <div>
                                @php
                                    $stClass = match($finding->status) {
                                        'Open'        => 'status-open',
                                        'In Progress' => 'status-in-progress',
                                        'Fixed'       => 'status-fixed',
                                        default       => 'status-open',
                                    };
                                @endphp
                                <span class="badge-status {{ $stClass }} px-3 py-2 fs-6">{{ $finding->status }}</span>
                            </div>
                            <div>
                                @php
                                    $sevClass = match($finding->severity) {
                                        'Critical' => 'sev-critical',
                                        'High'     => 'sev-high',
                                        'Medium'   => 'sev-medium',
                                        default    => 'sev-low',
                                    };
                                @endphp
                                <span class="badge-severity {{ $sevClass }} px-3 py-2 fs-6">{{ $finding->severity }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="divider mt-0 mb-4" style="height:1px; background:rgba(var(--green-400-rgb),0.1);"></div>

                    <div class="row g-4 mb-4">
                        <div class="col-12">
                            <div class="detail-field-label"><i class="bi bi-info-circle me-1"></i> Technical Description</div>
                            <div class="detail-field-value" style="white-space: pre-wrap; font-family:'Inter', sans-serif; line-height:1.8;">{{ $finding->description }}</div>
                        </div>
                    </div>

                    @if($finding->image_path)
                    <div class="row g-4 mb-4">
                        <div class="col-12">
                            <div class="detail-field-label"><i class="bi bi-image me-1"></i> Proof of Concept</div>
                            <div class="p-2 border rounded" style="background:rgba(var(--navy-950-rgb),0.3); border-color:rgba(var(--green-400-rgb),0.1) !important;">
                                <img src="{{ asset('storage/' . $finding->image_path) }}" alt="Proof of Concept" class="img-fluid rounded" style="max-height: 500px; width: 100%; object-fit: contain;">
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="divider mt-4 mb-4" style="height:1px; background:rgba(var(--green-400-rgb),0.1);"></div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('home') }}" class="btn-ghost text-decoration-none d-inline-flex align-items-center gap-2">
                            <i class="bi bi-arrow-left"></i> Back to Engine
                        </a>

                        <div class="d-flex gap-2">
                            <a href="{{ route('findings.edit', $finding->id) }}" class="btn-warning-ghost text-decoration-none d-inline-flex align-items-center gap-2 px-3 py-2">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            
                            @if($finding->status !== 'Fixed')
                                <form action="{{ route('findings.resolve', $finding->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-success-ghost d-inline-flex align-items-center gap-2 px-3 py-2">
                                        <i class="bi bi-check2-circle"></i> Mark Fixed
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
