{{--
  ╔══════════════════════════════════════════════════════════╗
  ║         SHARED ADMIN PAGE HEADER COMPONENT               ║
  ║  Usage:                                                  ║
  ║  <x-admin-page-header                                    ║
  ║      :title="trans('cruds.order.title')"                 ║
  ║      icon="fas fa-receipt"                               ║
  ║      color="blue"                                        ║
  ║      :breadcrumbs="[                                     ║
  ║          ['label'=>'Dashboard','url'=>route('admin.home')],║
  ║          ['label'=>'Orders'],                            ║
  ║      ]"                                                  ║
  ║  />                                                      ║
  ╚══════════════════════════════════════════════════════════╝
--}}

@props([
    'title'       => '',
    'icon'        => 'fas fa-tachometer-alt',
    'color'       => 'blue',
    'breadcrumbs' => [],
])

@php
$palettes = [
    'blue'   => ['grad' => 'linear-gradient(135deg,#4f7cff 0%,#7c4fff 100%)', 'shadow' => 'rgba(79,124,255,0.3)',   'link' => '#4f7cff'],
    'green'  => ['grad' => 'linear-gradient(135deg,#22c55e 0%,#16a34a 100%)', 'shadow' => 'rgba(34,197,94,0.3)',    'link' => '#16a34a'],
    'orange' => ['grad' => 'linear-gradient(135deg,#f97316 0%,#ea580c 100%)', 'shadow' => 'rgba(249,115,22,0.3)',   'link' => '#ea580c'],
    'purple' => ['grad' => 'linear-gradient(135deg,#a855f7 0%,#7c3aed 100%)', 'shadow' => 'rgba(168,85,247,0.3)',   'link' => '#7c3aed'],
    'red'    => ['grad' => 'linear-gradient(135deg,#ef4444 0%,#b91c1c 100%)', 'shadow' => 'rgba(239,68,68,0.3)',    'link' => '#b91c1c'],
    'cyan'   => ['grad' => 'linear-gradient(135deg,#06b6d4 0%,#0e7490 100%)', 'shadow' => 'rgba(6,182,212,0.3)',    'link' => '#0e7490'],
    'indigo' => ['grad' => 'linear-gradient(135deg,#6366f1 0%,#4338ca 100%)', 'shadow' => 'rgba(99,102,241,0.3)',   'link' => '#4338ca'],
    'teal'   => ['grad' => 'linear-gradient(135deg,#14b8a6 0%,#0f766e 100%)', 'shadow' => 'rgba(20,184,166,0.3)',   'link' => '#0f766e'],
    'pink'   => ['grad' => 'linear-gradient(135deg,#ec4899 0%,#be185d 100%)', 'shadow' => 'rgba(236,72,153,0.3)',   'link' => '#be185d'],
];
$p = $palettes[$color] ?? $palettes['blue'];
@endphp

<style>
.adm-ph {
    display:flex;
    align-items:center;
    justify-content:space-between;
    flex-wrap:wrap;
    gap:12px;
    margin-bottom:24px;
}
.adm-ph-title {
    font-size:1.35rem;
    font-weight:700;
    color:#1a1f2e;
    display:flex;
    align-items:center;
    gap:10px;
}
.adm-ph-icon {
    width:38px;height:38px;
    border-radius:10px;
    background: {{ $p['grad'] }};
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    font-size:1rem;
    box-shadow:0 4px 12px {{ $p['shadow'] }};
    flex-shrink:0;
}
.adm-ph-bc .breadcrumb { background:transparent; padding:0; margin:0; font-size:0.8rem; }
.adm-ph-bc .breadcrumb-item a { color: {{ $p['link'] }}; text-decoration:none; }
.adm-ph-bc .breadcrumb-item.active { color:#7a80a0; }
</style>

<div class="adm-ph">
    <div class="adm-ph-title">
        <div class="adm-ph-icon"><i class="{{ $icon }}"></i></div>
        {{ $title }}
    </div>
    @if(count($breadcrumbs))
    <nav class="adm-ph-bc" aria-label="breadcrumb">
        <ol class="breadcrumb">
            @foreach($breadcrumbs as $crumb)
                @if(!$loop->last)
                    <li class="breadcrumb-item">
                        <a href="{{ $crumb['url'] ?? '#' }}">{{ $crumb['label'] }}</a>
                    </li>
                @else
                    <li class="breadcrumb-item active">{{ $crumb['label'] }}</li>
                @endif
            @endforeach
        </ol>
    </nav>
    @endif
</div>
