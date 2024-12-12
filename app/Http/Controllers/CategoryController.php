<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Response;

class CategoryController extends Controller
{
	public function index(): Response
	{
		return inertia('Categories/Index', [
			'categories' => CategoryResource::collection(Category::with(['articles', 'articles.author', 'articles.category'])->orderBy('name', 'ASC')->paginate(5))
		]);
	}

	public function create(): Response
	{
		return inertia('Categories/Create');
	}

	public function store(Request $request)
	{
		//
	}

	public function show(Category $category): Response
	{
		$category->load(['articles', 'articles.author', 'articles.category']);

		return inertia('Categories/Show', [
			'category' => CategoryResource::make($category)
		]);
	}

	public function edit(Category $category): Response
	{
		$category->load(['articles', 'articles.author', 'articles.category']);

		return inertia('Categories/Edit', [
			'category' => CategoryResource::make($category)
		]);
	}

	public function update(Request $request, Category $category)
	{
		//
	}

	public function destroy(Category $category)
	{
		//
	}
}
