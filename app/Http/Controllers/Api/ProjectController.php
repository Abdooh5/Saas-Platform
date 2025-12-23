<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    public function store(StoreProjectRequest $request)
    { 
      
         if (! Gate::allows('create', Project::class)) {
        return response()->json([
            'success' => false,
            'message' => 'Company has reached the maximum number of projects'
        ], 403);
    }
    
       
        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'company_id' => $request->user()->company_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Project created successfully',
                'data' => new ProjectResource($project)
            ], 201);
        
    }
    public function index(Request $request)
    {
        $query = Project::where('company_id', $request->user()->company_id);
    
        // 🔍 Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
    
        // 🔃 Sorting (secure)
        $allowedSorts = ['name', 'created_at'];
        $sortBy = in_array($request->get('sort_by'), $allowedSorts)
            ? $request->get('sort_by')
            : 'created_at';
    
        $sortDirection = $request->get('sort_direction') === 'asc'
            ? 'asc'
            : 'desc';
    
        $projects = $query
            ->orderBy($sortBy, $sortDirection)
            ->paginate($request->get('per_page', 10));
    
        return response()->json([
            'success' => true,
            'message' => 'Projects fetched successfully',
            'data' => ProjectResource::collection($projects),
            'meta' => [
                'current_page' => $projects->currentPage(),
                'last_page'    => $projects->lastPage(),
                'per_page'     => $projects->perPage(),
                'total'        => $projects->total(),
            ]
        ]);
    }
    
    public function show(Request $request, Project $project)
{
    // Ownership check
   Gate::authorize('view',$project);

    return response()->json([
        'success' => true,
        'message' => 'Project fetched successfully',
        'data' => new ProjectResource($project)
    ]);
}
public function update(UpdateProjectRequest $request, Project $project)
{
    Gate::authorize('update',$project);
    
        $project->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    
    return response()->json([
        'success' => true,
        'message' => 'Project updated successfully',
        'data' => new ProjectResource($project)
    ], 200);
}
public function destroy(Request $request, Project $project)
{
     Gate::authorize('delete',$project);
    
  
    // Soft Delete
    $project->delete();

    return response()->json([
        'success' => true,
        'message' => 'Project deleted successfully'
    ]);
}


public function restore(Request $request, $id)
{
    $project = Project::withTrashed()
        ->where('id', $id)
        ->first();

    if (! $project) {
        return response()->json([
            'success' => false,
            'message' => 'Project not found'
        ], 404);
    }

    Gate::authorize('restore', $project);

    $project->restore();

    return response()->json([
        'success' => true,
        'message' => 'Project restored successfully',
        'data' => new ProjectResource($project)
    ]);
}
public function trashed()
{$user=Auth::user();
    $projects = Project::onlyTrashed()
        ->where('company_id', $user->company_id)
        ->get();

    return ProjectResource::collection($projects);
}


}