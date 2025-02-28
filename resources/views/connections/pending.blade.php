<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-purple-50 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden border border-gray-100 p-8">
                <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent mb-8">Demandes de connexion en attente</h2>

                @if($pendingRequests->isEmpty())
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p class="mt-4 text-xl text-gray-500">Aucune demande de connexion en attente</p>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($pendingRequests as $request)
                            <div class="bg-white rounded-2xl shadow-lg p-6 flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="relative group">
                                        <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full opacity-75 group-hover:opacity-100 transition duration-200 blur"></div>
                                        <img src="{{ $request->requester->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                                            class="relative w-16 h-16 rounded-full object-cover border-2 border-white"
                                            alt="{{ $request->requester->name }}">
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-900">{{ $request->requester->name }}</h3>
                                        <p class="text-gray-500">{{ $request->requester->profile?->title ?? 'Développeur' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <form action="{{ route('connections.accept', $request) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="px-6 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-full hover:shadow-lg transition duration-200">
                                            Accepter
                                        </button>
                                    </form>
                                    <form action="{{ route('connections.reject', $request) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-6 py-2 border-2 border-red-500 text-red-500 rounded-full hover:bg-red-50 transition duration-200">
                                            Refuser
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout> 