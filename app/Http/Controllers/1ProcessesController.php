<?php

namespace App\Http\Controllers;

use App\Models\OrganizationProcess;
use Illuminate\Http\Request;

class ProcessesController extends Controller
{
    public function __invoke()
    {
        $processes = OrganizationProcess::all();
        return view('admin.processes', compact('processes'));
    }

    public function show($id)
    {
        $process = OrganizationProcess::find($id);
        return view('admin.processes', compact('process'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        OrganizationProcess::create([
            'name' => $request->name,
            'description' => $request->description,
            'activo' => true
        ]);

        return redirect()->route('admin.processes')->with('success', 'Proceso creado correctamente.');
    }
    public function update(Request $request, $id)
    {
        $process = OrganizationProcess::find($id);
        $process->name = $request->name;
        $process->description = $request->description;
        $process->save();
        return redirect()->route('admin.processes')->with('success', 'Proceso actualizado correctamente.');
    }

    public function destroy($id)
    {
        $process = OrganizationProcess::find($id);
        $process->delete();
        return redirect()->route('admin.processes')->with('success', 'Proceso eliminado correctamente.');
    }
}
