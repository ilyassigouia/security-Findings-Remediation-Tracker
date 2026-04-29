@extends('layouts.app')

@section('content')
<div class="page-container fade-in">

    {{-- ── Hero Banner ── --}}
    <div class="home-hero">
        <img src="{{ asset('images/hero_hacker_bg.png') }}" alt="Security" class="home-hero-img">
        <div class="home-hero-overlay">
            <div class="home-hero-title"><i class="bi bi-shield-lock-fill me-2"></i>Vulnerability Tracker</div>
            <p class="home-hero-sub">Monitor, triage, and remediate security findings — all in one place.</p>
            <div class="d-flex align-items-center gap-2 mt-3">
                <a href="{{ route('findings.create') }}" class="btn-green d-inline-flex align-items-center gap-2 text-decoration-none px-3 py-2" style="border-radius:0.5rem;font-size:0.88rem;font-weight:700;">
                    <i class="bi bi-plus-circle-fill"></i> New Finding
                </a>
                <a href="{{ route('export.csv') }}" class="btn-outline-green d-inline-flex align-items-center gap-2 text-decoration-none px-3 py-2" style="border-radius:0.5rem;font-size:0.85rem;">
                    <i class="bi bi-filetype-csv"></i> CSV
                </a>
                <a href="{{ route('export.pdf') }}" class="btn-outline-green d-inline-flex align-items-center gap-2 text-decoration-none px-3 py-2" style="border-radius:0.5rem;font-size:0.85rem;">
                    <i class="bi bi-filetype-pdf"></i> PDF
                </a>
            </div>
        </div>
    </div>

    {{-- ── Stat Cards ── --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3"><div class="stat-card stat-total"><div class="stat-glow"></div><div class="stat-icon"><i class="bi bi-collection-fill"></i></div><div class="stat-value">{{ $totalFindings }}</div><div class="stat-label">Total Findings</div></div></div>
        <div class="col-6 col-md-3"><div class="stat-card stat-open"><div class="stat-glow"></div><div class="stat-icon"><i class="bi bi-exclamation-triangle-fill"></i></div><div class="stat-value">{{ $openFindings }}</div><div class="stat-label">Open Bugs</div></div></div>
        <div class="col-6 col-md-3"><div class="stat-card stat-crit"><div class="stat-glow"></div><div class="stat-icon"><i class="bi bi-fire"></i></div><div class="stat-value">{{ $criticalFindings }}</div><div class="stat-label">Critical</div></div></div>
        <div class="col-6 col-md-3"><div class="stat-card stat-fixed"><div class="stat-glow"></div><div class="stat-icon"><i class="bi bi-patch-check-fill"></i></div><div class="stat-value">{{ $fixedFindings }}</div><div class="stat-label">Fixed</div></div></div>
    </div>

    {{-- ── Chart + Search ── --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="chart-card h-100">
                <div class="section-title mb-3">Severity Breakdown</div>
                <canvas id="severityChart" style="max-height:220px;"></canvas>
            </div>
        </div>
        <div class="col-md-8">
            <div class="chart-card h-100">
                <div class="section-title mb-3">Search &amp; Filter</div>
                <form method="GET" action="{{ route('home') }}">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="terminal-label">Search</div>
                            <div class="input-group">
                                <span class="input-group-text" style="border-radius:0.5rem 0 0 0.5rem;"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" class="form-control" placeholder="Vulnerability name..." value="{{ request('search') }}" style="border-radius:0 0.5rem 0.5rem 0;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="terminal-label">Status</div>
                            <select name="status" class="form-select">
                                <option value="">All Statuses</option>
                                <option value="Open"        {{ request('status')=='Open'        ?'selected':'' }}>Open</option>
                                <option value="In Progress" {{ request('status')=='In Progress' ?'selected':'' }}>In Progress</option>
                                <option value="Fixed"       {{ request('status')=='Fixed'       ?'selected':'' }}>Fixed</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn-green w-100" style="border-radius:0.5rem;padding:0.65rem 0;font-size:0.88rem;font-weight:700;border:none;cursor:pointer;">
                                <i class="bi bi-funnel-fill"></i>
                            </button>
                        </div>
                        @if(request('search') || request('status'))
                        <div class="col-12">
                            <a href="{{ route('home') }}" class="btn-ghost d-inline-flex align-items-center gap-1 text-decoration-none mt-1" style="font-size:0.82rem;">
                                <i class="bi bi-x-circle"></i> Clear filters
                            </a>
                        </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ── Findings Table ── --}}
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="section-title">Security Findings</div>
            <span class="font-mono" style="font-size:0.78rem;color:var(--slate-500);">{{ $findings->total() }} record(s)</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="sec-table">
                    <thead>
                        <tr>
                            <th>ID</th><th>Vulnerability</th><th>Severity</th><th>Status</th><th>Proof</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($findings as $finding)
                        <tr>
                            <td><span class="id-badge">#{{ $finding->id }}</span></td>
                            <td><span style="font-weight:500;color:var(--slate-100);">{{ $finding->name }}</span></td>
                            <td>
                                @php $sevClass = match($finding->severity){'Critical'=>'sev-critical','High'=>'sev-high','Medium'=>'sev-medium',default=>'sev-low'}; @endphp
                                <span class="badge-severity {{ $sevClass }}">{{ $finding->severity }}</span>
                            </td>
                            <td>
                                @php $stClass = match($finding->status){'Open'=>'status-open','In Progress'=>'status-in-progress','Fixed'=>'status-fixed',default=>'status-open'}; @endphp
                                <span class="badge-status {{ $stClass }}">{{ $finding->status }}</span>
                            </td>
                            <td>
                                @if($finding->image_path)
                                    <a href="{{ asset('storage/'.$finding->image_path) }}" target="_blank">
                                        <img src="{{ asset('storage/'.$finding->image_path) }}" class="proof-thumb" alt="PoC">
                                    </a>
                                @else
                                    <span style="font-size:0.8rem;color:var(--slate-500);">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-1 flex-wrap">
                                    <a href="{{ route('findings.show',$finding->id) }}" class="btn-ghost btn-sm-action text-decoration-none d-inline-flex align-items-center gap-1"><i class="bi bi-eye"></i> View</a>
                                    <a href="{{ route('findings.edit',$finding->id) }}" class="btn-warning-ghost btn-sm-action text-decoration-none d-inline-flex align-items-center gap-1"><i class="bi bi-pencil"></i> Edit</a>
                                    @if($finding->status !== 'Fixed')
                                    <form action="{{ route('findings.resolve',$finding->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn-success-ghost btn-sm-action d-inline-flex align-items-center gap-1"><i class="bi bi-check2-circle"></i> Fix</button>
                                    </form>
                                    @endif
                                    <form action="{{ route('findings.destroy',$finding->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this finding?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-danger-ghost btn-sm-action d-inline-flex align-items-center gap-1"><i class="bi bi-trash3"></i> Del</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6"><div class="empty-state"><div class="empty-icon">🔍</div><p>// no findings match your query</p></div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($findings->hasPages())
            <div class="d-flex justify-content-center py-3 px-4">{{ $findings->links('pagination::bootstrap-5') }}</div>
            @endif
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded",function(){
    const ctx=document.getElementById('severityChart').getContext('2d');
    new Chart(ctx,{
        type:'doughnut',
        data:{
            labels:['Critical','High','Medium','Low'],
            datasets:[{
                data:[{{ $findings->where('severity','Critical')->count() }},{{ $findings->where('severity','High')->count() }},{{ $findings->where('severity','Medium')->count() }},{{ $findings->where('severity','Low')->count() }}],
                backgroundColor:['rgba(255,71,87,0.85)','rgba(255,165,2,0.85)','rgba(236,204,104,0.85)','rgba(46,213,115,0.85)'],
                borderWidth:2,borderColor:'#112240',hoverOffset:6
            }]
        },
        options:{
            responsive:true,maintainAspectRatio:false,cutout:'65%',
            plugins:{legend:{position:'bottom',labels:{color:'#8892b0',font:{family:'JetBrains Mono',size:11},padding:14,usePointStyle:true}}}
        }
    });
});
</script>
@endsection
