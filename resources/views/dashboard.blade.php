<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @auth
        @if (Auth::user()->role === 'sender')

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                        <div class="flex flex-col mt-4 mb-4">
                            <a href="{{ route(name: 'tracking.generate') }}"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Generate Tracking Code
                            </a>
                            @if (isset($trackings) && $trackings->isNotEmpty())
                                <div class="mt-6">
                                    <h3 class="text-lg font-semibold mb-2 text-center">Pending Tracking Codes</h3>
                                    <div class="flex justify-center overflow-x-auto">
                                        <table class=" min-w-full bg-white border border-gray-200 rounded">
                                            <thead>
                                                <tr class="bg-gray-100 text-left">

                                                    <th class="px-4 py-2 border">Link</th>
                                                    <th class="px-4 py-2 border">Admin</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($trackings as $tracking)
                                                    <tr>

                                                        <td class="px-4 py-2 border">
                                                            <a href="{{ route('tracking.show', $tracking->code) }}"
                                                                class="text-blue-600 hover:underline">
                                                                {{$tracking->code }}
                                                            </a>
                                                        </td>
                                                        <td class="px-4 py-2 border">{{ $tracking->sender }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <p class="text-center mt-6 text-gray-500">No pending tracking codes found.</p>
                            @endif
                        </div>
                    </div>
                </div>



        @endif

            @if (Auth::user()->role === 'manager')
                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-2 text-center">Pending Tracking Codes</h3>
                    <div class="flex justify-center overflow-x-auto">
                        <table class=" min-w-full bg-white border border-gray-200 rounded">
                            <thead>
                                <tr class="bg-gray-100 text-left">

                                    <th class="px-4 py-2 border">kode</th>
                                    <th class="px-4 py-2 border">deskripsi 1</th>
                                    <th class="px-4 py-2 border">deskripsi 2</th>
                                    <th class="px-4 py-2 border">deskripsi 3</th>
                                    <th class="px-4 py-2 border">gudang asal</th>
                                    <th class="px-4 py-2 border">gudang tujuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trackings as $tracking)
                                    <tr>

                                        <td class="px-4 py-2 border">{{$tracking->code }}
                                        </td>
                                        <td class="px-4 py-2 border">{{ $tracking->description_1 }}
                                        </td>
                                        <td class="px-4 py-2 border">{{ $tracking->description_2 }}
                                        </td>
                                        <td class="px-4 py-2 border">{{ $tracking->description_3 }}
                                        </td>
                                        <td class="px-4 py-2 border">{{ $tracking->time2 }}
                                        </td>
                                        <td class="px-4 py-2 border">{{ $tracking->time3 }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
    @endauth


</x-app-layout>