@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 dark:border-navy-700 dark:bg-navy-900 dark:text-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-xl shadow-sm transition-all']) }}>
