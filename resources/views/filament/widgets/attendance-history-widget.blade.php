<x-filament::widget>
    <x-filament::card>
        @php
            $now = \Carbon\Carbon::now();
            $user = auth()->user();
            $data = \app\Models\Attendance::where('user_id', $user->id)
                ->whereMonth('date', $now->format('m'))
                ->orderBy('date', 'DESC')
                ->get();
        @endphp
        <table border="1" width="100%">
            <tr>
                <td style="text-align: left">
                    <b>Attendance History</b>
                </td>
                <td style="text-align: right">
                    {{ $now->format('M Y') }}
                </td>
            </tr>
        </table>
        <table border="1" width="100%">
            <tr>
                <th style="text-align: center">
                    Date
                </th>
                <th style="text-align: center">
                    Clock In
                </th>
                <th style="text-align: center">
                    Clock Out
                </th>
            </tr>
            @foreach ($data as $item)
                <tr>
                    <td style="text-align: center">{{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}</td>
                    <td style="text-align: center">{{ \Carbon\Carbon::parse($item->clock_in)->format('H:i') }}</td>
                    <td style="text-align: center">{{ $item->clock_out == null ? '' : \Carbon\Carbon::parse($item->clock_out)->format('H:i') }}</td>
                </tr>
            @endforeach
        </table>
    </x-filament::card>
</x-filament::widget>
