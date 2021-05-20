<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntryRequest;
use App\Models\Entry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $entries = $user->entries()->orderBy('date', 'desc')->get();
        $total = $user->entries()->sum('amount');
        return response()->json(['entries' => $entries, 'total' => $total]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EntryRequest $request)
    {
        $user = $request->user();
        try {
            $entry = DB::transaction(fn () => $user->entries()->create($request->validated()));
            return response()->json(['data' => $entry], 201);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Entry $entry)
    {
        $user = $request->user();
        if ($user->can('view', $entry)) {
            return response()->json(compact('entry'));
        }
        abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function update(EntryRequest $request, Entry $entry)
    {
        $user = $request->user();
        try {
            DB::transaction(fn () => $entry->update($request->validated()));
            $entry->refresh();
            return response()->json(compact('entry'));
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Entry $entry)
    {
        $user = $request->user();
        if ($user->can('delete', $entry)) {
            try {
                DB::transaction(fn () => $entry->delete());
                return response()->json([], 204);
            } catch (\Exception $e) {
                \Log::error($e);
                return response()->json(['message' => $e->getMessage()], 500);
            }
        }
        abort(403);
    }
}
