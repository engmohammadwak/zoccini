{{--
  ╔══════════════════════════════════════════════════════════╗
  ║         SHARED STATUS BADGE COMPONENT                    ║
  ║  Usage:                                                  ║
  ║  <x-admin-status-badge :label="$status->name" type="success" />║
  ║  types: success | warning | danger | info |              ║
  ║         primary | secondary | purple | cyan | default    ║
  ╚══════════════════════════════════════════════════════════╝
--}}

@props([
    'label' => '',
    'type'  => 'default',
])

@php
$types = [
    'success'   => ['bg' => '#d4f5e2', 'color' => '#0d6b35'],
    'warning'   => ['bg' => '#fff8e6', 'color' => '#c47f00'],
    'danger'    => ['bg' => '#ffe6e6', 'color' => '#c42b2b'],
    'info'      => ['bg' => '#e8f4ff', 'color' => '#1a6fc4'],
    'primary'   => ['bg' => '#eef1ff', 'color' => '#4f7cff'],
    'secondary' => ['bg' => '#f0f2fa', 'color' => '#4a5080'],
    'purple'    => ['bg' => '#f3e8ff', 'color' => '#7c3aed'],
    'cyan'      => ['bg' => '#e0f2fe', 'color' => '#0e7490'],
    'orange'    => ['bg' => '#ffedd5', 'color' => '#ea580c'],
    'pink'      => ['bg' => '#fce7f3', 'color' => '#be185d'],
    'default'   => ['bg' => '#f0f2fa', 'color' => '#4a5080'],
];
$t = $types[$type] ?? $types['default'];
@endphp

<span style="
    display:inline-flex;
    align-items:center;
    gap:5px;
    padding:4px 10px;
    border-radius:20px;
    font-size:0.75rem;
    font-weight:600;
    white-space:nowrap;
    background:{{ $t['bg'] }};
    color:{{ $t['color'] }};
">
    <span style="width:6px;height:6px;border-radius:50%;background:{{ $t['color'] }};opacity:0.7;display:inline-block;"></span>
    {{ $label }}
</span>
