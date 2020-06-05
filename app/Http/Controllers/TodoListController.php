<?php

namespace App\Http\Controllers;

use App\TodoList;
use Illuminate\Http\Request;

class TodoListController extends Controller
{
    public function index()
    {
        $todos = TodoList::where('is_completed', false)
            ->orderBy('created_at', 'desc')
            ->withCount(['tasks' => function ($query) {
                $query->where('is_completed', false);
            }])
            ->get();

        return $todos->toJson();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required'
        ]);

        $todos = TodoList::create([
            'name' => $validatedData['name'],
        ]);

        return response()->json('TodoList created!');
    }

    public function show($id)
    {
        $todos = TodoList::with(['todo' => function ($query) {
            $query->where('is_completed', false);
        }])->find($id);

        return $todos->toJson();
    }
}