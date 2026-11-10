<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    // Display all plants created by the logged-in user.
    public function index()
    {
        $plants = auth()->user()
            ->plants()
            ->latest()
            ->paginate(10);

        return view('plants.index', compact('plants'));
    }

    // Display the form for adding a plant.
    public function create()
    {
        return view('plants.create');
    }

    // Save a new plant record.
    public function store(Request $request)
{
    // Validate all submitted plant information.
    $validated = $request->validate([
        'plant_name' => 'required|string|max:255',
        'category' => 'required|in:Ornamental,Flowering,Succulent,Herb',
        'unit_price' => 'required|numeric|min:0',
        'description' => 'required|string',
        'stock_status' => 'required|in:in_stock,out_of_stock',
    ], [
        'plant_name.required' => 'Please enter the plant name.',
        'category.required' => 'Please select a plant category.',
        'category.in' => 'Please select a valid plant category.',
        'unit_price.required' => 'Please enter the plant price.',
        'unit_price.numeric' => 'The plant price must be numeric.',
        'unit_price.min' => 'The plant price cannot be negative.',
        'description.required' => 'Please enter the plant description.',
        'stock_status.required' => 'Please select a stock status.',
        'stock_status.in' => 'Please select a valid stock status.',
    ]);

    // Save the plant under the currently authenticated user.
    auth()->user()->plants()->create($validated);

    return redirect()->route('plants.index')
        ->with('success', 'Plant added successfully!');
}

    // Display a specific plant.
    public function show(Plant $plant)
    {
        $plant = $this->findOwnedPlant($plant);

        return view('plants.show', compact('plant'));
    }

    // Display the edit form.
    public function edit(Plant $plant)
{
   

    $plant = $this->findOwnedPlant($plant);

    return view('plants.edit', compact('plant'));
}

    // Update an existing plant.
    
public function update(Request $request, Plant $plant)
{
    // Verify that the logged-in user owns this plant.
    $plant = $this->findOwnedPlant($plant);

    // Validate the submitted changes.
    $validated = $request->validate([
        'plant_name' => 'required|string|max:255',
        'category' => 'required|in:Ornamental,Flowering,Succulent,Herb',
        'unit_price' => 'required|numeric|min:0',
        'description' => 'required|string',
        'stock_status' => 'required|in:in_stock,out_of_stock',
    ], [
        'plant_name.required' => 'Please enter the plant name.',
        'category.required' => 'Please select a plant category.',
        'category.in' => 'Please select a valid plant category.',
        'unit_price.required' => 'Please enter the plant price.',
        'unit_price.numeric' => 'The plant price must be numeric.',
        'unit_price.min' => 'The plant price cannot be negative.',
        'description.required' => 'Please enter the plant description.',
        'stock_status.required' => 'Please select a stock status.',
        'stock_status.in' => 'Please select a valid stock status.',
    ]);

    // Update the existing database record.
    $plant->update($validated);

    return redirect()->route('plants.index')
        ->with('success', 'Plant updated successfully!');
}

    // Delete an existing plant.
    public function destroy(Plant $plant)
    {
        $plant = $this->findOwnedPlant($plant);

        $plant->delete();

        return redirect()->route('plants.index')
            ->with('success', 'Plant deleted successfully!');
    }

    // Ensure users can only access their own plant records.
    private function findOwnedPlant(Plant $plant): Plant
    {
        return auth()->user()->plants()
            ->findOrFail($plant->id);
    }
}
