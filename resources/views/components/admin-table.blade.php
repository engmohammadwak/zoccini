{{--
  ╔════════════════════════════════════════════════════════════╗
  ║         SHARED ADMIN TABLE COMPONENT                     ║
  ║  Usage:                                                  ║
  ║  <x-admin-table                                          ║
  ║      :title="trans('...')"                               ║
  ║      icon="fas fa-list"                                  ║
  ║      color="blue"                                        ║
  ║      datatableClass="datatable-Order"                    ║
  ║      :count="$items->count()"                            ║
  ║      createPermission="order_create"     ← NEW (optional)║
  ║      :createRoute="route('admin.orders.create')"         ║
  ║      createLabel="Add New"                               ║
  ║  >                                                       ║
  ║    <x-slot name="thead"> ... </x-slot>                   ║
  ║    <x-slot name="tbody"> ... </x-slot>                   ║
  ║  </x-admin-table>                                        ║
  ╚════════════════════════════════════════════════════════════╝
--}}

@props([
    'title'            => '',
    'icon'             => 'fas fa-table',
    'color'            => 'blue',
    'datatableClass'   => 'datatable-Default',
    'count'            => null,
    'countLabel'       => null,
    'createRoute'      => null,
    'createLabel'      => null,
    'createPermission' => null,
    'extraButtons'     => null,
])

@php
$palettes = [
    'blue'   => ['grad' => 'linear-gradient(135deg,#4f7cff 0%,#7c4fff 100%)', 'light' => '#eef1ff', 'text' => '#4f7cff', 'shadow' => 'rgba(79,124,255,0.3)', 'header_bg' => 'linear-gradient(135deg,#f7f9ff 0%,#f0f4ff 100%)', 'page_btn' => 'linear-gradient(135deg,#4f7cff,#7c4fff)', 'focus' => 'rgba(79,124,255,0.12)'],
    'green'  => ['grad' => 'linear-gradient(135deg,#22c55e 0%,#16a34a 100%)', 'light' => '#dcfce7', 'text' => '#16a34a', 'shadow' => 'rgba(34,197,94,0.3)',  'header_bg' => 'linear-gradient(135deg,#f0fff4 0%,#e6ffed 100%)', 'page_btn' => 'linear-gradient(135deg,#22c55e,#16a34a)', 'focus' => 'rgba(34,197,94,0.12)'],
    'orange' => ['grad' => 'linear-gradient(135deg,#f97316 0%,#ea580c 100%)', 'light' => '#ffedd5', 'text' => '#ea580c', 'shadow' => 'rgba(249,115,22,0.3)',  'header_bg' => 'linear-gradient(135deg,#fff7f0 0%,#fff0e6 100%)', 'page_btn' => 'linear-gradient(135deg,#f97316,#ea580c)', 'focus' => 'rgba(249,115,22,0.12)'],
    'purple' => ['grad' => 'linear-gradient(135deg,#a855f7 0%,#7c3aed 100%)', 'light' => '#f3e8ff', 'text' => '#7c3aed', 'shadow' => 'rgba(168,85,247,0.3)',  'header_bg' => 'linear-gradient(135deg,#faf5ff 0%,#f3e8ff 100%)', 'page_btn' => 'linear-gradient(135deg,#a855f7,#7c3aed)', 'focus' => 'rgba(168,85,247,0.12)'],
    'red'    => ['grad' => 'linear-gradient(135deg,#ef4444 0%,#b91c1c 100%)', 'light' => '#fee2e2', 'text' => '#b91c1c', 'shadow' => 'rgba(239,68,68,0.3)',   'header_bg' => 'linear-gradient(135deg,#fff5f5 0%,#fee2e2 100%)', 'page_btn' => 'linear-gradient(135deg,#ef4444,#b91c1c)', 'focus' => 'rgba(239,68,68,0.12)'],
    'cyan'   => ['grad' => 'linear-gradient(135deg,#06b6d4 0%,#0e7490 100%)', 'light' => '#e0f2fe', 'text' => '#0e7490', 'shadow' => 'rgba(6,182,212,0.3)',   'header_bg' => 'linear-gradient(135deg,#f0faff 0%,#e0f2fe 100%)', 'page_btn' => 'linear-gradient(135deg,#06b6d4,#0e7490)', 'focus' => 'rgba(6,182,212,0.12)'],
    'indigo' => ['grad' => 'linear-gradient(135deg,#6366f1 0%,#4338ca 100%)', 'light' => '#e0e7ff', 'text' => '#4338ca', 'shadow' => 'rgba(99,102,241,0.3)',  'header_bg' => 'linear-gradient(135deg,#f5f3ff 0%,#ede9fe 100%)', 'page_btn' => 'linear-gradient(135deg,#6366f1,#4338ca)', 'focus' => 'rgba(99,102,241,0.12)'],
    'teal'   => ['grad' => 'linear-gradient(135deg,#14b8a6 0%,#0f766e 100%)', 'light' => '#ccfbf1', 'text' => '#0f766e', 'shadow' => 'rgba(20,184,166,0.3)',  'header_bg' => 'linear-gradient(135deg,#f0fdfa 0%,#ccfbf1 100%)', 'page_btn' => 'linear-gradient(135deg,#14b8a6,#0f766e)', 'focus' => 'rgba(20,184,166,0.12)'],
    'pink'   => ['grad' => 'linear-gradient(135deg,#ec4899 0%,#be185d 100%)', 'light' => '#fce7f3', 'text' => '#be185d', 'shadow' => 'rgba(236,72,153,0.3)',  'header_bg' => 'linear-gradient(135deg,#fff0f8 0%,#fce7f3 100%)', 'page_btn' => 'linear-gradient(135deg,#ec4899,#be185d)', 'focus' => 'rgba(236,72,153,0.12)'],
];
$p = $palettes[$color] ?? $palettes['blue'];
$uid = 'tbl_'.Str::random(6);

// حساب صلاحية زر الإضافة:
// إذا تم تمرير createPermission نتحقق منه، وإلا نعرض الزر مباشرة إذا createRoute موجود.
$showCreateBtn = false;
if ($createRoute) {
    if ($createPermission) {
        $showCreateBtn = \Illuminate\Support\Facades\Gate::allows($createPermission);
    } else {
        $showCreateBtn = true;
    }
}
@endphp

<style>
/* ── admin-table component ────────────────────────────────────── */
.adm-tbl-card {
    background:#fff;
    border-radius:14px;
    border:1px solid #e8ecf4;
    box-shadow:0 2px 12px rgba(0,0,0,0.06);
    overflow:hidden;
    margin-bottom:24px;
    width:100%;
}
.adm-tbl-header {
    background: {{ $p['header_bg'] }};
    border-bottom:1px solid #e8ecf4;
    padding:16px 20px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    flex-wrap:wrap;
}
.adm-tbl-header-title {
    font-size:0.92rem;
    font-weight:700;
    color:#1a1f2e;
    display:flex;
    align-items:center;
    gap:8px;
}
.adm-tbl-header-title i { color: {{ $p['text'] }}; }
.adm-tbl-header-actions { display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
.adm-tbl-body { padding:20px; }

.adm-tbl-wrap {
    width:100%;
    overflow-x:auto;
    border-radius:10px;
    border:1px solid #eef0f8;
}

.adm-tbl-table {
    width:100% !important;
    min-width:100%;
    border-collapse:collapse;
    font-size:0.84rem;
    table-layout:auto;
}
.adm-tbl-table thead tr:first-child th {
    background:#f5f7ff;
    color:#4a5080;
    font-weight:700;
    font-size:0.78rem;
    text-transform:uppercase;
    letter-spacing:0.5px;
    padding:12px 14px;
    border-bottom:2px solid #e2e7f4;
    white-space:nowrap;
}
.adm-tbl-table thead tr:nth-child(2) td {
    background:#fafbff;
    padding:8px 10px;
    border-bottom:1px solid #e8ecf4;
}
.adm-tbl-table thead tr:nth-child(2) select {
    width:100%;
    border:1px solid #dde2f0;
    border-radius:7px;
    padding:5px 8px;
    font-size:0.78rem;
    color:#4a5080;
    background:#fff;
    outline:none;
    cursor:pointer;
    transition:border-color 0.2s;
}
.adm-tbl-table thead tr:nth-child(2) select:focus {
    border-color: {{ $p['text'] }};
    box-shadow:0 0 0 3px {{ $p['focus'] }};
}
.adm-tbl-table tbody tr {
    border-bottom:1px solid #f0f2fa;
    transition:background 0.15s;
}
.adm-tbl-table tbody tr:last-child { border-bottom:none; }
.adm-tbl-table tbody tr:hover { background:#f7f9ff; }
.adm-tbl-table tbody td {
    padding:13px 14px;
    color:#2d3250;
    vertical-align:middle;
}

.adm-count-chip {
    display:inline-flex;
    align-items:center;
    gap:7px;
    background:#fff;
    border:1px solid #e8ecf4;
    border-radius:10px;
    padding:7px 14px;
    font-size:0.82rem;
    font-weight:600;
    color:#3a4060;
    box-shadow:0 1px 4px rgba(0,0,0,0.05);
    margin-bottom:16px;
}
.adm-count-chip .dot {
    width:8px;height:8px;border-radius:50%;
    background: {{ $p['text'] }};
}

.adm-btn-create {
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:7px 16px;
    background: {{ $p['grad'] }};
    color:#fff !important;
    border-radius:9px;
    font-size:0.82rem;
    font-weight:600;
    text-decoration:none;
    border:none;
    cursor:pointer;
    box-shadow:0 3px 10px {{ $p['shadow'] }};
    transition:opacity 0.2s, transform 0.15s;
    white-space:nowrap;
}
.adm-btn-create:hover { opacity:0.88; transform:translateY(-1px); color:#fff !important; text-decoration:none; }

.adm-title-icon {
    width:36px;height:36px;
    border-radius:10px;
    background: {{ $p['grad'] }};
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    font-size:0.9rem;
    box-shadow:0 4px 10px {{ $p['shadow'] }};
    flex-shrink:0;
}

#{{ $uid }}_wrapper { width:100% !important; }
#{{ $uid }}_wrapper .dataTables_filter input {
    border:1px solid #dde2f0 !important;
    border-radius:8px !important;
    padding:6px 12px !important;
    font-size:0.83rem !important;
    outline:none !important;
}
#{{ $uid }}_wrapper .dataTables_filter input:focus {
    border-color: {{ $p['text'] }} !important;
    box-shadow:0 0 0 3px {{ $p['focus'] }} !important;
}
#{{ $uid }}_wrapper .dataTables_length select {
    border:1px solid #dde2f0 !important;
    border-radius:8px !important;
    padding:4px 8px !important;
    font-size:0.83rem !important;
}
#{{ $uid }}_wrapper .dataTables_info,
#{{ $uid }}_wrapper .dataTables_paginate {
    font-size:0.82rem !important;
    margin-top:14px !important;
    color:#7a80a0 !important;
}
#{{ $uid }}_wrapper .paginate_button { border-radius:7px !important; font-size:0.8rem !important; }
#{{ $uid }}_wrapper .paginate_button.current,
#{{ $uid }}_wrapper .paginate_button.current:hover {
    background: {{ $p['page_btn'] }} !important;
    color:#fff !important;
    border:none !important;
}
#{{ $uid }}_wrapper .dt-buttons {
    float:none !important;
    display:flex !important;
    flex-wrap:wrap !important;
    gap:6px !important;
    margin-bottom:10px !important;
}
#{{ $uid }}_wrapper .dataTables_length,
#{{ $uid }}_wrapper .dataTables_filter {
    display:inline-flex !important;
    align-items:center !important;
    gap:6px !important;
}
#{{ $uid }}_wrapper > .row,
#{{ $uid }}_wrapper > div { width:100% !important; }
</style>

{{-- Count chip --}}
@if(!is_null($count))
<div class="adm-count-chip">
    <div class="dot"></div>
    {{ $countLabel ?? trans('global.total') ?? 'Total' }}: <strong>{{ $count }}</strong>
</div>
@endif

{{-- Card --}}
<div class="adm-tbl-card">
    <div class="adm-tbl-header">
        <div class="adm-tbl-header-title">
            <div class="adm-title-icon"><i class="{{ $icon }}"></i></div>
            {{ $title }}
        </div>
        <div class="adm-tbl-header-actions">
            {{ $extraButtons ?? '' }}
            @if($showCreateBtn)
                <a href="{{ $createRoute }}" class="adm-btn-create">
                    <i class="fas fa-plus"></i>
                    {{ $createLabel ?? trans('global.add') ?? 'Add' }}
                </a>
            @endif
            <span style="font-size:0.78rem;color:#9aa0c0;">
                <i class="fas fa-sync-alt" style="margin-inline-start:4px;"></i>
                {{ now()->translatedFormat('d/m/Y H:i') }}
            </span>
        </div>
    </div>

    <div class="adm-tbl-body">
        <div class="adm-tbl-wrap">
            <table id="{{ $uid }}" class="adm-tbl-table table datatable {{ $datatableClass }}">
                <thead>{{ $thead }}</thead>
                <tbody>{{ $tbody }}</tbody>
            </table>
        </div>
    </div>
</div>

<script>
(function(){
    function fixTbl(){
        var tbl = $('#{{ $uid }}');
        if(!tbl.length) return;
        var dt = tbl.DataTable ? tbl.DataTable() : null;
        if(dt){
            dt.settings()[0].oInit.autoWidth = false;
            dt.columns.adjust();
        }
        $('#{{ $uid }}_wrapper').css('width','100%');
        tbl.css('width','100%');
    }
    if(document.readyState === 'loading'){
        document.addEventListener('DOMContentLoaded', function(){setTimeout(fixTbl,300);});
    } else {
        setTimeout(fixTbl,300);
    }
})();
</script>

{{ $scripts ?? '' }}
