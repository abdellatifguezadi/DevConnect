<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-purple-50 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden border border-gray-100 p-8">
                <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent mb-8">Mes connexions</h2>

                @if($connections->isEmpty())
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <p class="mt-4 text-xl text-gray-500">Vous n'avez pas encore de connexions</p>
                </div>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($connections as $user)
                    <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-200">
                        <div class="flex items-center space-x-4">
                            <div class="relative group">
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full opacity-75 group-hover:opacity-100 transition duration-200 blur"></div>
                                <a href="{{ route('profile.show', $user) }}">
                                    <img src="{{ $user->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                                        class="relative w-16 h-16 rounded-full object-cover border-2 border-white"
                                        alt="{{ $user->name }}">
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('profile.show', $user) }}" class="hover:text-purple-600 transition-colors">
                                    <h3 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h3>
                                </a>
                                <p class="text-gray-500">{{ $user->profile?->title ?? 'Développeur' }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-gray-600 line-clamp-2">{{ $user->profile?->bio ?? 'Aucune bio disponible' }}</p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100 flex justify-end">
                            <form action="{{ route('connections.remove', $user->getConnectionStatus(auth()->user())) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Retirer la connexion
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