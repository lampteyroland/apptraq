<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ApplicationController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $query = Application::where('user_id', auth()->id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('company', 'like', "%$search%")
                    ->orWhere('position', 'like', "%$search%");
            });
        }

        $applications = $query->latest()->paginate(10)->appends($request->only(['status', 'search']));

        return view('applications.index', compact('applications'));
    }

    public function create()
    {
        return view('applications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'status' => 'required|string',
            'applied_on' => 'nullable|date',
            'deadline' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'job_link' => 'nullable|url',
            'resume_used' => 'required|file|mimes:pdf|max:2048',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('resume_used')) {
            $validated['resume_used'] = $request->file('resume_used')->store('resumes', 'public');
        }

        $validated['user_id'] = auth()->id();

        Application::create($validated);

        return redirect()->route('applications.index')->with('success', 'Application submitted.');
    }

    public function edit($id)
    {
        $application = Application::findOrFail($id);
        $this->authorize('update', $application);

        return view('applications.edit', compact('application'));
    }

    public function update(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $this->authorize('update', $application);

        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'status' => 'required|string',
            'applied_on' => 'nullable|date',
            'deadline' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'job_link' => 'nullable|url',
            'resume_used' => 'nullable|mimes:pdf|max:2048',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('resume_used')) {
            $validated['resume_used'] = $request->file('resume_used')->store('resumes', 'public');
        }

        $application->update($validated);

        return redirect()->route('applications.index')->with('success', 'Application updated!');
    }

    public function destroy($id)
    {
        $application = Application::findOrFail($id);
        $this->authorize('delete', $application);

        $application->delete();

        return redirect()->route('applications.index')->with('success', 'Application deleted.');
    }

    public function show($id)
    {
        $application = Application::findOrFail($id);
        $this->authorize('view', $application);

        return view('applications.show', compact('application'));
    }
}
