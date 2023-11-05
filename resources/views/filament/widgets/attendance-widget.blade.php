<x-filament::widget>
    <x-filament::card>
        <center>
            <div class="p-4 space-y-4">
                <table width="100%">
                    <tr>
                        <td width="50%" style="text-align: center">
                            <x-filament::button wire:click="button1Action"
                                style="background-color: #003596; color:white; width: 20%; height: 50px;">
                                <b>
                                    Clock In
                                </b>
                            </x-filament::button>
                        </td>
                        <td width="50%" style="text-align: center">
                            <x-filament::button wire:click="button2Action"
                                style="background-color: #873636; color:white; width: 20%; height: 50px;">
                                <b>
                                    Clock Out
                                </b>
                            </x-filament::button>
                        </td>
                    </tr>
                </table>
            </div>
        </center>
    </x-filament::card>
</x-filament::widget>
