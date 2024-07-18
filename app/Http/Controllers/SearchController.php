<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Website;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        try {
            $query = $request->input('query');
            if (!$query) {
                return response()->json(['message' => 'Query parameter is required'], 400);
            }

            // Search websites by name, category, or number of votes
            $websites = Website::where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'LIKE', "%{$query}%")
                ->orWhere('url', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%");
            })
                ->orWhereHas('categories', function ($queryCategories) use ($query) {
                    $queryCategories->where('name', 'LIKE', "%{$query}%");
                })
                ->with('categories')
                ->withCount('votes')
                ->orderByDesc('votes_count') 
                ->get();

            return response()->json($websites, 200);
        } catch (\Exception $e) {
            // If an unexpected error occurs, return an error response
            Log::error('Error during search', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to perform search.', 'error' => $e->getMessage()], 500);
        }
    }
}