{{--
  ╔════════════════════════════════════════════════════════════╗
  ║  SHARED ADMIN TABLE COMPONENT                              ║
  ║  Props:                                                    ║
  ║    title, icon, color, datatableClass, count, countLabel  ║
  ║    createPermission (optional - gate key e.g. order_create)║
  ║    createRoute, createLabel, extraButtons                  ║
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
$accents = [
    'blue'   => ['grad'=>'linear-gradient(135deg,#4f7cff,#7c4fff)','text'=>'#4f7cff','shadow'=>'rgba(79,124,255,.3)','focus'=>'rgba(79,124,255,.12)','page'=>'linear-gradient(135deg,#4f7cff,#7c4fff)'],
    'green'  => ['grad'=>'linear-gradient(135deg,#22c55e,#16a34a)','text'=>'#16a34a','shadow'=>'rgba(34,197,94,.3)','focus'=>'rgba(34,197,94,.12)','page'=>'linear-gradient(135deg,#22c55e,#16a34a)'],
    'orange' => ['grad'=>'linear-gradient(135deg,#f97316,#ea580c)','text'=>'#ea580c','shadow'=>'rgba(249,115,22,.3)','focus'=>'rgba(249,115,22,.12)','page'=>'linear-gradient(135deg,#f97316,#ea580c)'],
    'purple' => ['grad'=>'linear-gradient(135deg,#a855f7,#7c3aed)','text'=>'#7c3aed','shadow'=>'rgba(168,85,247,.3)','focus'=>'rgba(168,85,247,.12)','page'=>'linear-gradient(135deg,#a855f7,#7c3aed)'],
    'red'    => ['grad'=>'linear-gradient(135deg,#ef4444,#b91c1c)','text'=>'#b91c1c','shadow'=>'rgba(239,68,68,.3)','focus'=>'rgba(239,68,68,.12)','page'=>'linear-gradient(135deg,#ef4444,#b91c1c)'],
    'cyan'   => ['grad'=>'linear-gradient(135deg,#06b6d4,#0e7490)','text'=>'#0e7490','shadow'=>'rgba(6,182,212,.3)','focus'=>'rgba(6,182,212,.12)','page'=>'linear-gradient(135deg,#06b6d4,#0e7490)'],
    'indigo' => ['grad'=>'linear-gradient(135deg,#6366f1,#4338ca)','text'=>'#4338ca','shadow'=>'rgba(99,102,241,.3)','focus'=>'rgba(99,102,241,.12)','page'=>'linear-gradient(135deg,#6366f1,#4338ca)'],
    'teal'   => ['grad'=>'linear-gradient(135deg,#14b8a6,#0f766e)','text'=>'#0f766e','shadow'=>'rgba(20,184,166,.3)','focus'=>'rgba(20,184,166,.12)','page'=>'linear-gradient(135deg,#14b8a6,#0f766e)'],
    'pink'   => ['grad'=>'linear-gradient(135deg,#ec4899,#be185d)','text'=>'#be185d','shadow'=>'rgba(236,72,153,.3)','focus'=>'rgba(236,72,153,.12)','page'=>'linear-gradient(135deg,#ec4899,#be185d)'],
];
$a   = $accents[$color] ?? $accents['blue'];
$uid = 'tbl_'.Str::random(6);

$showCreateBtn = false;
if ($createRoute) {
    $showCreateBtn = $createPermission
        ? \Illuminate\Support\Facades\Gate::allows($createPermission)
        : true;
}
@endphp

<style>
/* ===== admin-table component ===== */
.adm-tbl-card {
    background: var(--z-card-bg, #fff);
    border: 1px solid var(--z-card-border, #e8ecf4);
    border-radius: 14px;
    box-shadow: var(--z-card-shadow, 0 2px 12px rgba(0,0,0,.06));
    overflow: hidden;
    width: 100%;
}
.adm-tbl-header {
    border-bottom: 1px solid var(--z-border, #e8ecf4);
    padding: 14px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    flex-wrap: wrap;
    background: var(--z-surface-2, #f7f9ff);
}
.adm-tbl-header-title {
    font-size: .9rem;
    font-weight: 700;
    color: var(--z-text, #1a1f2e);
    display: flex;
    align-items: center;
    gap: 8px;
}
.adm-tbl-header-title i { color: {{ $a['text'] }}; }
.adm-tbl-header-actions { display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
.adm-title-icon {
    width:34px; height:34px;
    border-radius:9px;
    background: {{ $a['grad'] }};
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-size:.85rem;
    box-shadow:0 3px 8px {{ $a['shadow'] }};
    flex-shrink:0;
}
.adm-tbl-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
    padding: 12px 18px;
    border-bottom: 1px solid var(--z-border, #eef0f8);
}
.adm-tbl-wrap { width: 100%; overflow-x: auto; }
.adm-tbl-table {
    width: 100% !important;
    border-collapse: collapse;
    font-size: .84rem;
    table-layout: auto;
}
.adm-tbl-table thead tr:first-child th {
    background: var(--z-surface-2, #f5f7ff);
    color: var(--z-text-muted, #4a5080);
    font-weight: 700;
    font-size: .75rem;
    text-transform: uppercase;
    letter-spacing: .5px;
    padding: 11px 14px;
    border-bottom: 2px solid var(--z-border, #e2e7f4);
    white-space: nowrap;
}
.adm-tbl-table tbody tr {
    border-bottom: 1px solid var(--z-border, #f0f2fa);
    transition: background .15s;
}
.adm-tbl-table tbody tr:last-child { border-bottom: none; }
.adm-tbl-table tbody tr:hover { background: var(--z-surface-2, #f7f9ff); }
.adm-tbl-table tbody td {
    padding: 12px 14px;
    color: var(--z-text, #2d3250);
    vertical-align: middle;
}
.adm-btn-create {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 15px;
    background: {{ $a['grad'] }};
    color: #fff !important;
    border-radius: 8px;
    font-size: .81rem; font-weight: 600;
    text-decoration: none; border: none; cursor: pointer;
    box-shadow: 0 3px 10px {{ $a['shadow'] }};
    transition: opacity .2s, transform .15s;
    white-space: nowrap;
}
.adm-btn-create:hover { opacity:.87; transform:translateY(-1px); color:#fff !important; text-decoration:none; }

/* ─── DataTables overrides ─── */
#{{ $uid }}_wrapper { width: 100% !important; }

/* إلغاء الارتفاع الثابت من scrollY: السبب الجذري للمسافة الفارغة */
#{{ $uid }}_wrapper .dataTables_scrollBody {
    height: auto !important;
    max-height: none !important;
    overflow-y: visible !important;
    overflow-x: auto !important;
}
#{{ $uid }}_wrapper .dataTables_scrollHead {
    overflow: visible !important;
    height: auto !important;
}
#{{ $uid }}_wrapper .dataTables_scrollHeadInner {
    width: 100% !important;
    padding-right: 0 !important;
    padding-left: 0 !important;
    box-sizing: border-box !important;
}
#{{ $uid }}_wrapper .dataTables_scrollHeadInner > table,
#{{ $uid }}_wrapper .dataTables_scrollBody  > table {
    width: 100% !important;
    margin: 0 !important;
}
#{{ $uid }}_wrapper .dataTables_scroll { width: 100% !important; }

#{{ $uid }}_wrapper .dataTables_filter input {
    border: 1px solid var(--z-border, #dde2f0) !important;
    border-radius: 7px !important;
    padding: 5px 11px !important;
    font-size: .82rem !important;
    outline: none !important;
    background: var(--z-card-bg,#fff) !important;
    color: var(--z-text,#222) !important;
}
#{{ $uid }}_wrapper .dataTables_filter input:focus {
    border-color: {{ $a['text'] }} !important;
    box-shadow: 0 0 0 3px {{ $a['focus'] }} !important;
}
#{{ $uid }}_wrapper .dataTables_length select {
    border: 1px solid var(--z-border,#dde2f0) !important;
    border-radius: 7px !important;
    padding: 4px 8px !important;
    font-size: .82rem !important;
    background: var(--z-card-bg,#fff) !important;
    color: var(--z-text,#222) !important;
}
#{{ $uid }}_wrapper .dataTables_info,
#{{ $uid }}_wrapper .dataTables_paginate {
    font-size: .81rem !important;
    padding: 10px 18px !important;
    color: var(--z-text-muted,#7a80a0) !important;
}
#{{ $uid }}_wrapper .paginate_button { border-radius: 6px !important; font-size: .79rem !important; }
#{{ $uid }}_wrapper .paginate_button.current,
#{{ $uid }}_wrapper .paginate_button.current:hover {
    background: {{ $a['page'] }} !important;
    color: #fff !important;
    border: none !important;
}
#{{ $uid }}_wrapper .dt-buttons {
    float: none !important;
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 5px !important;
}
#{{ $uid }}_wrapper .dataTables_filter,
#{{ $uid }}_wrapper .dataTables_length { margin: 0 !important; }
#{{ $uid }}_wrapper > .row,
#{{ $uid }}_wrapper > div { width: 100% !important; }
</style>

<div class="adm-tbl-card">

    {{-- Header --}}
    <div class="adm-tbl-header">
        <div class="adm-tbl-header-title">
            <div class="adm-title-icon"><i class="{{ $icon }}"></i></div>
            {{ $title }}
            @if(!is_null($count))
            <span style="background:var(--z-surface-offset,#eef0f8);color:var(--z-text-muted,#5a6080);border-radius:999px;padding:2px 9px;font-size:.73rem;font-weight:700;margin-inline-start:2px;">{{ $count }}</span>
            @endif
        </div>
        <div class="adm-tbl-header-actions">
            {{ $extraButtons ?? '' }}
            @if($showCreateBtn)
                <a href="{{ $createRoute }}" class="adm-btn-create">
                    <i class="fas fa-plus"></i>
                    {{ $createLabel ?? trans('global.add') ?? 'Add' }}
                </a>
            @endif
        </div>
    </div>

    {{-- DataTables topbar --}}
    <div id="{{ $uid }}-topbar" class="adm-tbl-topbar" style="display:none;"></div>

    {{-- Table --}}
    <div class="adm-tbl-wrap">
        <table id="{{ $uid }}" class="adm-tbl-table table datatable {{ $datatableClass }}">
            <thead>{{ $thead }}</thead>
            <tbody>{{ $tbody }}</tbody>
        </table>
    </div>

</div>

<script>
(function(){
    var tblId  = '#{{ $uid }}';
    var wrapId = '#{{ $uid }}_wrapper';

    function fixScroll() {
        /* إلغاء الارتفاع الثابت من scrollY */
        $(wrapId + ' .dataTables_scrollBody').css({
            height    : 'auto',
            maxHeight : 'none',
            overflowY : 'visible',
            overflowX : 'auto'
        });
        $(wrapId + ' .dataTables_scrollHead').css({ overflow:'visible', height:'auto' });
        $(wrapId + ' .dataTables_scrollHeadInner').css({ width:'100%', paddingLeft:'0', paddingRight:'0' });
        $(wrapId + ' .dataTables_scrollHeadInner > table').css({ width:'100%', margin:'0' });
        $(wrapId + ' .dataTables_scrollBody > table').css({ width:'100%', margin:'0' });
        /* columns.adjust بعد تصحيح العرض */
        if ($.fn.DataTable && $.fn.DataTable.isDataTable(tblId)) {
            $(tblId).DataTable().columns.adjust();
        }
    }

    function initTbl() {
        if (!$(tblId).length) return;
        fixScroll();
        $(wrapId).css('width', '100%');

        /* ── سحب controls إلى topbar ── */
        var $topbar = $('#{{ $uid }}-topbar');
        var $filter = $(wrapId + ' .dataTables_filter');
        var $length = $(wrapId + ' .dataTables_length');
        var $btns   = $(wrapId + ' .dt-buttons');

        if ($filter.length || $length.length || $btns.length) {
            $topbar.show();
            var $left  = $('<div>').css({'display':'flex','align-items':'center','gap':'6px'});
            var $right = $('<div>').css({'display':'flex','align-items':'center','gap':'8px'});
            if ($btns.length)   $left.append($btns);
            if ($length.length) $right.append($length);
            if ($filter.length) $right.append($filter);
            $topbar.empty().append($left).append($right);
        }

        /* إعادة تطبيق fixScroll بعد render النهائي للجدول */
        setTimeout(fixScroll, 100);
        setTimeout(fixScroll, 600);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function(){ setTimeout(initTbl, 350); });
    } else {
        setTimeout(initTbl, 350);
    }
})();
</script>

{{ $slots['scripts'] ?? '' }}
