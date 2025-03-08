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
                    <div class="bg-white rounded-lg shadow mb-4">
                        <div class="p-4 border-b flex justify-between items-center">
                            <h1 class="text-xl font-semibold">Offres d'emploi</h1>
                            <a href="{{ route('job-offers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                Publier une offre
                            </a>
                        </div>
                        

                        
                        <!-- Job Listings -->
                        <div class="p-4">
                            @if($jobOffers->isEmpty())
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune offre d'emploi trouvée</h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Commencez par créer une nouvelle offre d'emploi.
                                    </p>
                                    <div class="mt-6">
                                        <a href="{{ route('job-offers.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Publier une offre
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="space-y-4">
                                    @foreach($jobOffers as $jobOffer)
                                        <div class="border rounded-lg p-4 hover:shadow-md transition">
                                            <div class="flex justify-between">
                                                <h2 class="text-lg font-medium text-gray-900">
                                                    <a href="{{ route('job-offers.show', $jobOffer) }}" class="hover:text-blue-600">
                                                        {{ $jobOffer->title }}
                                                    </a>
                                                </h2>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    {{ $jobOffer->employment_type === 'Full-time' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $jobOffer->employment_type === 'Part-time' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $jobOffer->employment_type === 'Contract' ? 'bg-purple-100 text-purple-800' : '' }}
                                                    {{ $jobOffer->employment_type === 'Freelance' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $jobOffer->employment_type === 'Internship' ? 'bg-gray-100 text-gray-800' : '' }}
                                                ">
                                                    {{ $jobOffer->employment_type }}
                                                </span>
                                            </div>
                                            
                                            <div class="mt-2 text-sm text-gray-500 flex items-center">
                                                <span class="font-medium text-gray-900">{{ $jobOffer->company_name }}</span>
                                                <span class="mx-2 text-gray-400">•</span>
                                                <span>{{ $jobOffer->location }}</span>
                                                @if($jobOffer->experience_level)
                                                    <span class="mx-2 text-gray-400">•</span>
                                                    <span>{{ $jobOffer->experience_level }}</span>
                                                @endif
                                            </div>
                                            
                                            <div class="mt-3 flex items-center text-sm">
                                                @if($jobOffer->salary_min || $jobOffer->salary_max)
                                                    <span class="text-green-600 font-medium">
                                                        @if($jobOffer->salary_min && $jobOffer->salary_max)
                                                            {{ number_format($jobOffer->salary_min, 0, ',', ' ') }} - {{ number_format($jobOffer->salary_max, 0, ',', ' ') }} {{ $jobOffer->currency }}
                                                        @elseif($jobOffer->salary_min)
                                                            À partir de {{ number_format($jobOffer->salary_min, 0, ',', ' ') }} {{ $jobOffer->currency }}
                                                        @elseif($jobOffer->salary_max)
                                                            Jusqu'à {{ number_format($jobOffer->salary_max, 0, ',', ' ') }} {{ $jobOffer->currency }}
                                                        @endif
                                                    </span>
                                                    <span class="mx-2 text-gray-400">•</span>
                                                @endif
                                                <span class="text-gray-500">
                                                    Publié par {{ $jobOffer->user->name }} - {{ $jobOffer->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            
                                            <div class="mt-4 truncate text-gray-600">
                                                {{ Str::limit($jobOffer->description, 150) }}
                                            </div>
                                            
                                            <div class="mt-4">
                                                <a href="{{ route('job-offers.show', $jobOffer) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                                    Voir plus
                                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Pagination -->
                                <div class="mt-6">
                                    {{ $jobOffers->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 