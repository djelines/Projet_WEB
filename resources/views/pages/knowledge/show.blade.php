<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold">{{ __('Bilan de compétence généré') }}</h1>
    </x-slot>

    <div class="container mx-auto my-8">
        @if(isset($qcm) && is_array($qcm) && !empty($qcm))
            @foreach($qcm as $question)
                <div class="question mb-4">
                    <p><strong>{{ $question['question'] }}</strong></p>
                    <ul>
                        @foreach($question['choices'] as $choice)
                            <li>{{ $choice }}</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        @else
            <p>Aucune question générée.</p>
        @endif
    </div>
</x-app-layout>
