@props(['disabled' => false])

<!-- Dark-theme default for inputs to match site style -->
<input @disabled($disabled) {{ $attributes->merge(['class' => 'text-gray-100 bg-[#1f2124] placeholder-gray-400 ring-1 ring-white/5 focus:outline-none focus:ring-2 focus:ring-[#5865F2] rounded-md shadow-sm']) }}>
