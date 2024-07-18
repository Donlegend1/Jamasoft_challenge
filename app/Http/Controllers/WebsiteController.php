<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\CategoryWebsite;
use App\Http\Requests\StoreWebsiteRequest;
use App\Http\Requests\UpdateWebsiteRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $websites = Website::with('categories', 'votes')
        ->withCount('votes')
        ->orderBy('votes_count', 'desc')
        ->get();
        return response()->json($websites);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate incoming request data
            $request->validate([
                'name' => 'required|string|max:255',
                'url' => 'required|url',
                'description' => 'nullable|string',
                'categories' => 'required|array',
                'categories.*' => 'integer|exists:categories,id'
            ]);

            $request->merge(['user_id' => $request->user()->id]);
            DB::beginTransaction();

            $website = Website::create($request->only('name', 'url', 'description', 'user_id'));
            $website->categories()->sync($request->categories);
            foreach ($request->categories as $category_id) {
                CategoryWebsite::create([
                    'website_id' => $website->id,
                    'category_id' => $category_id,
                ]);
            }

            DB::commit();

            return response()->json($website, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to create website.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $website = Website::with('categories', 'votes')->withCount('votes')->findOrFail($id);
        return response()->json($website);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Website $website)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWebsiteRequest $request, Website $website)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Check if the authenticated user is an admin
            $user = Auth::user();
            if (!$user || !$user->isAdmin()) {
                return response()->json(['message' => 'Only Admin can delete this'], 403);
            }

            // Find the website and delete it
            $website = Website::findOrFail($id);
            $website->delete();

            return response()->json(['message' => 'Website deleted'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // If the website is not found, return a 404 response
            return response()->json(['message' => 'Website not found'], 404);
        } catch (\Exception $e) {
            // If an unexpected error occurs, return a 500 response
            return response()->json(['message' => 'Failed to delete website.', 'error' => $e->getMessage()], 500);
        }
    }
}