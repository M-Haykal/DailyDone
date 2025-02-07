<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskList;

class ListController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'list_items'  => 'required|string',
            'detail_list' => 'nullable|string',
            'status'      => 'required|string',
            'priority'    => 'nullable|string',
            'tag'         => 'nullable|string',
            'note'        => 'nullable|string',
            'project_id'  => 'required|exists:projects,id',
        ]);

        // Simpan data ke database
        $task = TaskList::create($request->all());

        return response()->json([
            'message' => 'Task berhasil dibuat!',
            'data' => $task
        ], 201);

    }
}
