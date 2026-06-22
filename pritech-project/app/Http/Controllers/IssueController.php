<?php
namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Project;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    /**
     * Show all issues (optional global view)
     */
    public function index()
    {
        $issues = Issue::with('project')->latest()->get();

        return view('issues.index', compact('issues'));
    }

    /**
     * Show create form (IMPORTANT: needs project context)
     */
    public function create(Request $request)
    {
        $project = Project::findOrFail($request->project_id);
    
        return view('issues.create', compact('project'));
    }
    /**
     * Store issue
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'required|in:open,in_progress,closed',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
        ]);

        Issue::create([
            'project_id' => $request->project_id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('projects.show', $request->project_id);
    }

    /**
     * Show single issue
     */
    public function show(string $id)
    {
        $issue = Issue::with(['project', 'comments', 'tags'])->findOrFail($id);

        return view('issues.show', compact('issue'));
    }

    /**
     * Edit issue
     */
    public function edit(string $id)
    {
        $issue = Issue::findOrFail($id);

        return view('issues.edit', compact('issue'));
    }

    /**
     * Update issue
     */
    public function update(Request $request, string $id)
    {
        $issue = Issue::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'required|in:open,in_progress,closed',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
        ]);

        $issue->update($request->all());

        return redirect()->route('projects.show', $issue->project_id);
    }

    /**
     * Delete issue
     */
    public function destroy(string $id)
    {
        $issue = Issue::findOrFail($id);

        $projectId = $issue->project_id;

        $issue->delete();

        return redirect()->route('projects.show', $projectId);
    }
}