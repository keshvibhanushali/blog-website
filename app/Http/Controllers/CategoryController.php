<?php

namespace App\Http\Controllers;

use App\DataTables\CategoriesDataTable;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(CategoriesDataTable $dataTable)
    {
        return $dataTable->render('admin.category.index');
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(CategoryRequest $request)
    {
        try {
            $validated = $request->validated();
            $category = new Category();
            $category->name = $request->name;
            $category->slug = strtolower(str_replace(" ", "_", $request->name));
            $category->status = $request->status;
            $category->save();

            $data = response()->json(
                [
                    "status" => "true",
                    "message" => "Success",
                ]
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    "status" => "false",
                    "message" => $e->getMessage(),
                ]
            );
        }
    }

    public function edit(Category $category)
    {

        return view('admin.category.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $validated = $request->validated();
            $data = $request->all();
            $category->update($data);
            $data = response()->json(
                [
                    "status" => "true",
                    "message" => "Success",
                ]
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    "status" => "false",
                    "message" => $e->getMessage(),
                ]
            );
        }
    }

    public function delete($id)
    {
        Category::where('id', $id)->delete();
        $response = response()->json(
            [
                "message" => "success",
                "status" => 200,
            ]
        );
        return $response;
    }

    public function removeAll(Request $request)
    {
        // $ids=$request->ids;
        Category::whereIn('id', $request->ids)->delete();
    }

    public function editAll(Request $request)
    {
        // dd($request->status);
        Category::whereIn('id', $request->ids)->update(['status' => $request->status]);
    }

    public function catDropdown(Category $category)
    {
        $posts = Post::where('category_id', $category->id)->paginate(10);
        return view('frontend.index', compact('posts'));
    }
}
