<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tracking Code: {{ $tracking->code }}
        </h2>
    </x-slot>
    @auth
        @if (Auth::user()->email === 'user1@user.com')
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                        <div class="mt-6">
                            <p class="mb-2">QR Code:</p>
                            {!! QrCode::size(200)->generate($trackingUrl) !!}
                        </div>
                        <form action="{{ url('/download-qr/' . $tracking->code) }}" method="GET">
                            <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Download QR Code as PDF
                            </button>
                        </form>


                    </div>
                </div>
            </div>
        @endif

        @if (Auth::user()->role === 'courier')
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        @if ($tracking->status1 === 'dalam pengiriman')
                            <p class="text-green-600 font-bold">Barang sudah diterima</p>
                        @else
                            <form action="{{ route('tracking.updateStatus1', $tracking->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Terima Barang
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        @if (Auth::user()->role === 'receiver')
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        @if ($tracking->status1 === 'gudang tujuan')
                            <p class="text-green-600 font-bold">Barang sudah diterima</p>
                        @else
                            <form action="{{ route('tracking.updateStatus2', $tracking->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Terima Barang
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    @endauth



</x-app-layout>