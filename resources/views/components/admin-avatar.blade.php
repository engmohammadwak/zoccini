{{--
  ╔══════════════════════════════════════════════════════════╗
  ║         SHARED AVATAR COMPONENT                          ║
  ║  Usage:                                                  ║
  ║  <x-admin-avatar :name="$user->name" color="blue" />     ║
  ║  <x-admin-avatar :name="$user->name" :image="$user->avatar" />║
  ╚══════════════════════════════════════════════════════════╝
--}}

@props([
    'name'  => '',
    'image' => null,
    'color' => 'blue',
    'size'  => '28px',
])

@php
$gradients = [
    'blue'   => 'linear-gradient(135deg,#4f7cff,#7c4fff)',
    'green'  => 'linear-gradient(135deg,#22c55e,#16a34a)',
    'orange' => 'linear-gradient(135deg,#f97316,#ea580c)',
    'red'    => 'linear-gradient(135deg,#ef4444,#b91c1c)',
    'purple' => 'linear-gradient(135deg,#a855f7,#7c3aed)',
    'cyan'   => 'linear-gradient(135deg,#06b6d4,#0e7490)',
];
$grad   = $gradients[$color] ?? $gradients['blue'];
$letter = strtoupper(substr($name ?? 'U', 0, 1));
@endphp

@if($image)
    <img src="{{ $image }}" alt="{{ $name }}"
        style="width:{{ $size }};height:{{ $size }};border-radius:50%;object-fit:cover;flex-shrink:0;">
@else
    <span style="
        width:{{ $size }};height:{{ $size }};
        border-radius:50%;
        background:{{ $grad }};
        display:inline-flex;
        align-items:center;
        justify-content:center;
        color:#fff;
        font-size:0.7rem;
        font-weight:700;
        flex-shrink:0;
    ">{{ $letter }}</span>
@endif
