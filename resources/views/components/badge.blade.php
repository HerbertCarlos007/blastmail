@props([
    'danger' => null,
    'warning' => null
])

<span {{$attributes->class([
    'w-fit rounded-md border px-2 py-1 text-xs font-medium text-white',
    'border-red-500 bg-red-500' => $danger,
    'border-amber-500 bg-amber-500' => $warning
])}}>
    {{$slot}}
</span>
