<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Models\Hashtag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobOffer::with('user.profile')
            ->active()
            ->orderBy('created_at', 'desc');
            
        // Filtre par expérience
        if ($request->has('experience_level')) {
            $query->where('experience_level', $request->experience_level);
        }
        
        // Filtre par type d'emploi
        if ($request->has('employment_type')) {
            $query->where('employment_type', $request->employment_type);
        }
        
        // Recherche par titre ou entreprise
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }
        
        $jobOffers = $query->paginate(10);
        
        // Récupérer les tendances pour la sidebar
        $trendingTags = Hashtag::where('posts_count', '>', 0)
            ->orderBy('posts_count', 'desc')
            ->take(5)
            ->get();
            
        $user = auth()->user();
        $postsCount = $user->posts()->count();
        $connectionsCount = $user->connections()->count();
        
        return view('job-offers.index', compact('jobOffers', 'trendingTags', 'user', 'postsCount', 'connectionsCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('job-offers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'employment_type' => 'required|string|in:Full-time,Part-time,Contract,Freelance,Internship',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'currency' => 'nullable|string|size:3',
            'expiry_date' => 'nullable|date|after:today',
            'experience_level' => 'nullable|string|in:Junior,Mid-level,Senior,Lead',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
        ]);
        
        $jobOffer = auth()->user()->jobOffers()->create($validated);
        
        return redirect()->route('job-offers.show', $jobOffer)
            ->with('success', 'Offre d\'emploi créée avec succès!');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobOffer $jobOffer)
    {
        $jobOffer->load('user.profile');
        
        // Récupérer les tendances pour la sidebar
        $trendingTags = Hashtag::where('posts_count', '>', 0)
            ->orderBy('posts_count', 'desc')
            ->take(5)
            ->get();
            
        $user = auth()->user();
        $postsCount = $user->posts()->count();
        $connectionsCount = $user->connections()->count();
        
        return view('job-offers.show', compact('jobOffer', 'trendingTags', 'user', 'postsCount', 'connectionsCount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobOffer $jobOffer)
    {
        // Vérifier manuellement que l'utilisateur est le propriétaire
        if (auth()->id() !== $jobOffer->user_id) {
            return redirect()->route('job-offers.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier cette offre d\'emploi.');
        }
        
        return view('job-offers.edit', compact('jobOffer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobOffer $jobOffer)
    {
        // Vérifier manuellement que l'utilisateur est le propriétaire
        if (auth()->id() !== $jobOffer->user_id) {
            return redirect()->route('job-offers.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier cette offre d\'emploi.');
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'employment_type' => 'required|string|in:Full-time,Part-time,Contract,Freelance,Internship',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'currency' => 'nullable|string|size:3',
            'expiry_date' => 'nullable|date|after:today',
            'experience_level' => 'nullable|string|in:Junior,Mid-level,Senior,Lead',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'status' => 'nullable|string|in:active,closed,filled',
        ]);
        
        $jobOffer->update($validated);
        
        return redirect()->route('job-offers.show', $jobOffer)
            ->with('success', 'Offre d\'emploi mise à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobOffer $jobOffer)
    {
        // Vérifier manuellement que l'utilisateur est le propriétaire
        if (auth()->id() !== $jobOffer->user_id) {
            return redirect()->route('job-offers.index')
                ->with('error', 'Vous n\'êtes pas autorisé à supprimer cette offre d\'emploi.');
        }
        
        $jobOffer->delete();
        
        return redirect()->route('job-offers.index')
            ->with('success', 'Offre d\'emploi supprimée avec succès!');
    }
}
