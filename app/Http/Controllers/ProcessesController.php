<?php

namespace App\Http\Controllers;

use App\Http\Requests\Processes\CreateProcessesRequests;
use App\Http\Requests\Processes\UpdateProcessesRequests;
use App\Services\Process\ProcessService;

class ProcessesController extends Controller
{
    public function __construct(protected ProcessService $processService) {}

    public function index()
    {
        $processes = $this->processService->getAll();
        return view('admin.processes', compact('processes'));
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $process = $this->processService->find($id);

        return view('admin.processes', compact('process'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProcessesRequests $request)
    {
        $this->processService->create($request->validated());

        return redirect()->route('admin.processes')->with('message', 'Proceso creado correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $process = $this->processService->find($id);

        return view('admin.processes', compact('process'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProcessesRequests $request, int $id)
    {
        $this->processService->update($id, $request->validated());

        return redirect()->route('admin.processes')->with('message', 'Proceso actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->processService->delete($id);

        return redirect()->route('admin.processes')->with('message', 'Proceso eliminado correctamente.');
    }
}
