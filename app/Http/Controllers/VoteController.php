<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Http\Requests\StoreVoteRequest;
use App\Http\Requests\UpdateVoteRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request )
    {
    
        try {
            $request->validate([
                'website_id' => 'required|exists:websites,id',
            ]);
            
            $userId = $request->user()->id;            
            if (!$userId) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            $vote = Vote::firstOrCreate([
                'user_id' => $userId,
                'website_id' => $request->website_id,
            ]);

            return response()->json($vote, 201);
        } catch (ValidationException $e) {
            // If validation fails, return the validation errors
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // If an unexpected error occurs, return an error response
            return response()->json(['message' => 'Failed to store vote.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Vote $vote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vote $vote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVoteRequest $request, Vote $vote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $vote = Vote::where('user_id', auth()->id())->where('website_id', $id)->firstOrFail();
        $vote->delete();

        return response()->json(['message' => 'Vote removed'], 200);
    }
}