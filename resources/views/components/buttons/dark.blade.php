<div>
    <button {{ $attributes->merge(['type' => 'submit', 'class' => 'flex space-x-2 items-center justify-center bg-secondary hover:bg-secondary-dark rounded-sm px-6 py-3 text-gray-100 hover:shadow-xl transition duration-150']) }}>
        {{ $slot }}
    </button>
</div>