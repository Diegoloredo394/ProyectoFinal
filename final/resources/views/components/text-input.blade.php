@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[#463F1A] focus:ring-[#463F1A] rounded-md shadow-sm']) }}>
