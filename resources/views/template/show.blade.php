<x-layouts.app>
    <x-slot name="header">
        <x-h2>
            {{ __('Templates') }}
        </x-h2>
    </x-slot>

    <x-card class="space-y-4">
        <div>
            <div class="flex justify-between items-center mb-5">
                <div><span class="opacity-70">{{__('Name')}}:</span>{{$template->name}}</div>
                <x-button.link :href="route('template.index')" secondary>
                    {{ __('Back to list') }}
                </x-button.link>
            </div>
            <div class="p-20 border-2 border-gray-400 rounded flex justify-center">{!! $template->body !!}</div>
        </div>
    </x-card>
</x-layouts.app>
