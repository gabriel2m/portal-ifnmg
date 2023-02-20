<div>
    @php
        $flash = [
            'success' => [
                'label' => 'Sucesso!',
                'icon' => 'checkmark',
                'color' => 'green',
            ],
            'warning' => [
                'label' => 'Atenção!',
                'icon' => 'warning',
                'color' => 'yellow',
            ],
            'danger' => [
                'label' => 'Atenção!',
                'icon' => 'warning',
                'color' => 'red',
            ],
            'status' => [
                'label' => 'Status',
                'icon' => 'info',
                'color' => 'blue',
            ],
        ];
        // Avoid classes prune:
        // bg-green-100  border-green-800  text-green-900  text-green-500
        // bg-yellow-100 border-yellow-800 text-yellow-900 text-yellow-500
        // bg-blue-100   border-blue-800   text-blue-900   text-blue-500
        // bg-red-100    border-red-800    text-red-900    text-red-500
    @endphp
    @foreach (session()->all() as $type => $flashMessage)
        @if (Arr::has($flash, $type))
            <div class="bg-{{ $flash[$type]['color'] }}-100 border-t-2 border-{{ $flash[$type]['color'] }}-800 text-{{ $flash[$type]['color'] }}-900 px-4 py-3 shadow-md mt-3 mx-auto max-w-screen-lg close-target"
                role="alert">
                <div class="flex">
                    <div class="py-1">
                        <i
                            class="icon-{{ $flash[$type]['icon'] }} text-{{ $flash[$type]['color'] }}-500 mr-4 text-2xl"></i>
                    </div>
                    <div>
                        <p class="font-bold">{{ $flash[$type]['label'] }}</p>
                        <p class="text-sm">{{ __($flashMessage) }}</p>
                    </div>
                    <div class="ml-auto">
                        <button class="close-btn text-xs text-gray-500 hover:text-gray-700">
                            <i class="icon-cross"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>