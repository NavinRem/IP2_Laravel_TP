<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
    

class CategoryController extends Controller
{
        public function index()
    {
        $categories = Category::all();

        return response()->json([
            'message' => 'success',
            'data' => $categories
        ]);
    }

    public function update(Request $request, $id)
    {
        // Find the category by its ID
        $category = Category::findOrFail($id);

        // Update the category's name or other fields
        $category->update([
            'name' => $request->input('name'),
        ]);

        // Return the updated category
        return response()->json($category, 200);
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create the category
        $category = Category::create($validated);

        // Return a JSON response with the created category and status code 201
        return response()->json($category, 201);
    }

    // --- Get /api/categories
    public function getCategories() {
        return response()->json(Category::all());
    }

    // --- Post /api/categories
    public function createCategory(Request $request) {
        $category = Category::create($request->all());
        return response()->json(["message" => "Creating 1 new category", "category" => $category], 201);
    }
    
    // --- Get /api/categories/{categoryId}
    public function getCategory($categoryId) {
        $category = Category::find($categoryId);
        if(!$categoryId) {
            return response()->json(["message" => "Category not found","category" => $category], 404); 
        }
        return response()->json($category);
    }

    // --- Patch /api/categories/{categoryId}
    public function updateCategory(Request $request, $categoryId) {
        $category = Category::find($categoryId);
        if(!$category){
            return response()->json(["message" => "Category not found","category" => $category], 404); 
        }
        $category->update($request->all());
        return response()->json(["message" => "Updating 1 category base on given categoryId", "category" => $category]);
    }

    // --- Delete /api/categories/{categoryId}
    public function deleteCategory($categoryId) {
        $category = Category::find($categoryId);
        if(!$category){
            return response()->json(["message" => "Category not found","category" => $category], 404); 
        }
        $category->delete();
        return response()->json(['message' => "Category deleted successfully"], 204);
    }
}

// class CategoryController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      */
//     public function index()
//     {
//         //
//     }

//     /**
//      * Show the form for creating a new resource.
//      */
//     public function create()
//     {
//         //
//     }

//     /**
//      * Store a newly created resource in storage.
//      */
//     public function store(Request $request)
//     {
//         //
//     }

//     /**
//      * Display the specified resource.
//      */
//     public function show(string $id)
//     {
//         //
//     }

//     /**
//      * Show the form for editing the specified resource.
//      */
//     public function edit(string $id)
//     {
//         //
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(Request $request, string $id)
//     {
//         //
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(string $id)
//     {
//         //
//     }
// }
