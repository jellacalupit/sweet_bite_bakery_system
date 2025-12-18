<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Get all categories
     * Auto-creates default categories if none exist
     */
    public function index()
    {
        // Ensure default categories exist (idempotent)
        $defaultCategories = [
            ['name' => 'Cake'],
            ['name' => 'Bread'],
            ['name' => 'Pastry'],
            ['name' => 'Cupcake'],
            ['name' => 'Cookies'],
        ];

        foreach ($defaultCategories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                $category
            );
        }

        return response()->json(Category::all());
    }

    /**
     * Find or create a category by name
     */
    public function findOrCreate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = Category::firstOrCreate(
            ['name' => $request->name],
            ['name' => $request->name]
        );

        return response()->json($category);
    }
}

