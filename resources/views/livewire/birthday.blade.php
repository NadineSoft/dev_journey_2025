<div>
    @if ($birthdays)
        <div class="w-full p-4">
            @foreach ($birthdays as $bd)
                <div class="p-2 bg-gray-200 flex justify-between"><span>{{ $bd->name }}</span><span>{{  \Carbon\Carbon::parse($bd->date)->format('d M Y') }}</span></div>
            @endforeach
        </div>
    @endif
</div>
