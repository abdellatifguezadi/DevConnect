<x-app-layout>
    <div class="bg-[#f3f2ef] min-h-screen pt-24">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-5">
                <!-- Sidebar - Left -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="relative h-24 bg-[#a0b4b7]">
                            <img src="{{ $user->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                                class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 w-20 h-20 rounded-full border-4 border-white"
                                alt="{{ $user->name }}">
                        </div>
                        <div class="pt-14 p-4 text-center">
                            <h2 class="text-xl font-semibold">{{ $user->name }}</h2>
                            <p class="text-sm text-gray-600 mt-1">{{ $user->profile?->title ?? 'Développeur' }}</p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach($user->skills as $skill)
                                <span class="px-2 py-1 bg-{{ $skill->category }}-100 text-{{ $skill->category }}-800 rounded-full text-xs">
                                    {{ $skill->name }}
                                </span>
                                @endforeach
                            </div>
                            <div class="mt-4 pt-4 border-t">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Connections</span>
                                    <span class="text-blue-600 font-medium">{{ $connectionsCount }}</span>
                                </div>
                                <div class="flex justify-between text-sm mt-2">
                                    <span class="text-gray-500">Posts</span>
                                    <span class="text-blue-600 font-medium">{{ $postsCount }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Trending Section -->
                    <div class="bg-white rounded-lg shadow mt-4 p-4">
                        <h3 class="text-base font-semibold mb-3">Tendances pour vous</h3>
                        <div class="space-y-2">
                            @foreach($trendingTags as $tag)
                            <a href="#" class="flex items-center justify-between hover:bg-gray-50 p-2 rounded">
                                <span class="text-gray-600">#{{ $tag->name }}</span>
                                <span class="text-gray-400 text-sm">{{ number_format($tag->posts_count) }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Main Content - Center + Right -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-4 border-b flex justify-between items-center">
                            <div>
                                <a href="{{ route('job-offers.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-2">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Retour aux offres
                                </a>
                                <h1 class="text-xl font-semibold">{{ $jobOffer->title }}</h1>
                            </div>
                            
                            @if(auth()->id() === $jobOffer->user_id)
                            <div class="flex space-x-2">
                                <a href="{{ route('job-offers.edit', $jobOffer) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Modifier
                                </a>
                                
                                <form action="{{ route('job-offers.destroy', $jobOffer) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette offre?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-red-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                        
                        <div class="p-6">
                            <div class="flex flex-wrap gap-3 mb-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    {{ $jobOffer->employment_type === 'Full-time' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $jobOffer->employment_type === 'Part-time' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $jobOffer->employment_type === 'Contract' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $jobOffer->employment_type === 'Freelance' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $jobOffer->employment_type === 'Internship' ? 'bg-gray-100 text-gray-800' : '' }}
                                ">
                                    {{ $jobOffer->employment_type }}
                                </span>
                                
                                @if($jobOffer->experience_level)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    {{ $jobOffer->experience_level }}
                                </span>
                                @endif
                                
                                @if($jobOffer->status === 'active')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                                @elseif($jobOffer->status === 'closed')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    Fermée
                                </span>
                                @elseif($jobOffer->status === 'filled')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    Pourvue
                                </span>
                                @endif
                                
                                @if($jobOffer->expiry_date)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $jobOffer->expiry_date < now() ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800' }}">
                                    Expire le {{ $jobOffer->expiry_date->format('d/m/Y') }}
                                </span>
                                @endif
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <h2 class="text-lg font-medium text-gray-900 mb-2">Informations sur l'entreprise</h2>
                                    <div class="space-y-2">
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            <span class="text-gray-700">{{ $jobOffer->company_name }}</span>
                                        </div>
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span class="text-gray-700">{{ $jobOffer->location }}</span>
                                        </div>
                                        @if($jobOffer->salary_min || $jobOffer->salary_max)
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-gray-700">
                                                @if($jobOffer->salary_min && $jobOffer->salary_max)
                                                    {{ number_format($jobOffer->salary_min, 0, ',', ' ') }} - {{ number_format($jobOffer->salary_max, 0, ',', ' ') }} {{ $jobOffer->currency }}
                                                @elseif($jobOffer->salary_min)
                                                    À partir de {{ number_format($jobOffer->salary_min, 0, ',', ' ') }} {{ $jobOffer->currency }}
                                                @elseif($jobOffer->salary_max)
                                                    Jusqu'à {{ number_format($jobOffer->salary_max, 0, ',', ' ') }} {{ $jobOffer->currency }}
                                                @endif
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div>
                                    <h2 class="text-lg font-medium text-gray-900 mb-2">À propos du recruteur</h2>
                                    <div class="flex items-center p-3 border rounded-lg">
                                        <div class="flex-shrink-0">
                                            <img src="{{ $jobOffer->user->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}" 
                                                class="w-12 h-12 rounded-full" alt="{{ $jobOffer->user->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-sm font-medium text-gray-900">{{ $jobOffer->user->name }}</h3>
                                            <p class="text-sm text-gray-500">{{ $jobOffer->user->profile?->title ?? 'Développeur' }}</p>
                                            <a href="{{ route('profile.show', $jobOffer->user) }}" class="mt-1 text-xs text-blue-600 hover:text-blue-800">
                                                Voir le profil
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-t pt-6">
                                <h2 class="text-lg font-medium text-gray-900 mb-4">Description du poste</h2>
                                <div class="prose max-w-none text-gray-700">
                                    {!! nl2br(e($jobOffer->description)) !!}
                                </div>
                            </div>
                            
                            @if($jobOffer->requirements)
                            <div class="border-t pt-6 mt-6">
                                <h2 class="text-lg font-medium text-gray-900 mb-4">Prérequis</h2>
                                <div class="prose max-w-none text-gray-700">
                                    {!! nl2br(e($jobOffer->requirements)) !!}
                                </div>
                            </div>
                            @endif
                            
                            @if($jobOffer->benefits)
                            <div class="border-t pt-6 mt-6">
                                <h2 class="text-lg font-medium text-gray-900 mb-4">Avantages</h2>
                                <div class="prose max-w-none text-gray-700">
                                    {!! nl2br(e($jobOffer->benefits)) !!}
                                </div>
                            </div>
                            @endif
                            
                            <div class="border-t pt-6 mt-6">
                                <p class="text-sm text-gray-500">
                                    Publié le {{ $jobOffer->created_at->format('d/m/Y') }} 
                                    @if($jobOffer->created_at != $jobOffer->updated_at)
                                    (Mis à jour le {{ $jobOffer->updated_at->format('d/m/Y') }})
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 