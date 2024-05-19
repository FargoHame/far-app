<button {{ $attributes->merge(['type' => 'submit', 'class' => 'md:w-auto w-full min-w-200 font-semibold px-6 py-2 bg-far-green-dark hover:opacity-75 text-black']) }}>
    {{ $slot }}
</button>
