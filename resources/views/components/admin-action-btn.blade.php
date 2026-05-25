{{--
  ╔══════════════════════════════════════════════════════════╗
  ║         SHARED ACTION BUTTON COMPONENT                   ║
  ║  Usage:                                                  ║
  ║  <x-admin-action-btn                                     ║
  ║      href="{{ route('admin.orders.show', $id) }}"        ║
  ║      icon="fas fa-eye"                                   ║
  ║      :label="trans('global.view')"                       ║
  ║      color="blue"                                        ║
  ║  />                                                      ║
  ║  colors: blue | green | orange | red | purple | cyan     ║
  ╚══════════════════════════════════════════════════════════╝
--}}

@props([
    'href'   => '#',
    'icon'   => 'fas fa-eye',
    'label'  => '',
    'color'  => 'blue',
    'method' => 'GET',  // GET or DELETE
])

@php
$gradients = [
    'blue'   => 'linear-gradient(135deg,#4f7cff,#7c4fff)',
    'green'  => 'linear-gradient(135deg,#22c55e,#16a34a)',
    'orange' => 'linear-gradient(135deg,#f97316,#ea580c)',
    'red'    => 'linear-gradient(135deg,#ef4444,#b91c1c)',
    'purple' => 'linear-gradient(135deg,#a855f7,#7c3aed)',
    'cyan'   => 'linear-gradient(135deg,#06b6d4,#0e7490)',
    'pink'   => 'linear-gradient(135deg,#ec4899,#be185d)',
    'indigo' => 'linear-gradient(135deg,#6366f1,#4338ca)',
];
$shadows = [
    'blue'   => 'rgba(79,124,255,0.25)',
    'green'  => 'rgba(34,197,94,0.25)',
    'orange' => 'rgba(249,115,22,0.25)',
    'red'    => 'rgba(239,68,68,0.25)',
    'purple' => 'rgba(168,85,247,0.25)',
    'cyan'   => 'rgba(6,182,212,0.25)',
    'pink'   => 'rgba(236,72,153,0.25)',
    'indigo' => 'rgba(99,102,241,0.25)',
];
$grad   = $gradients[$color] ?? $gradients['blue'];
$shadow = $shadows[$color]   ?? $shadows['blue'];
@endphp

@if(strtoupper($method) === 'DELETE')
    <form action="{{ $href }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit"
            onclick="return confirm('{{ trans('global.areYouSure') ?? 'Are you sure?' }}')"
            style="
                display:inline-flex;align-items:center;gap:5px;
                padding:5px 12px;
                background:{{ $grad }};
                color:#fff;
                border-radius:7px;
                font-size:0.78rem;
                font-weight:600;
                text-decoration:none;
                border:none;
                cursor:pointer;
                box-shadow:0 2px 8px {{ $shadow }};
                transition:opacity 0.2s,transform 0.15s;
            "
            onmouseover="this.style.opacity='0.85';this.style.transform='translateY(-1px)'"
            onmouseout="this.style.opacity='1';this.style.transform='translateY(0)'"
        >
            <i class="{{ $icon }}"></i>
            @if($label) {{ $label }} @endif
        </button>
    </form>
@else
    <a href="{{ $href }}"
        style="
            display:inline-flex;align-items:center;gap:5px;
            padding:5px 12px;
            background:{{ $grad }};
            color:#fff !important;
            border-radius:7px;
            font-size:0.78rem;
            font-weight:600;
            text-decoration:none;
            border:none;
            cursor:pointer;
            box-shadow:0 2px 8px {{ $shadow }};
            transition:opacity 0.2s,transform 0.15s;
        "
        onmouseover="this.style.opacity='0.85';this.style.transform='translateY(-1px)'"
        onmouseout="this.style.opacity='1';this.style.transform='translateY(0)'"
    >
        <i class="{{ $icon }}"></i>
        @if($label) {{ $label }} @endif
    </a>
@endif
