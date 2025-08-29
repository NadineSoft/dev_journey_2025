<div>
    @if ($birthdays)
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-blue-400 border text-center px-8 py-4">
                        <th class="py-2 px-4 bg-gray-100 border-b border-gray-200 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                        <th class="py-2 px-4 bg-gray-100 border-b border-gray-200 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Birthday</th>
                        <th class="py-2 px-4 bg-gray-100 border-b border-gray-200 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Notes</th></tr>
                </thead>
                <tbody>
                    @foreach ($birthdays as $bd)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-gray-800">{{ $bd->name }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-gray-800">{{  \Carbon\Carbon::parse($bd->date)->format('d M Y') }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-gray-800">{{ $bd->notes ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
