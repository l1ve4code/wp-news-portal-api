<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use function PHPUnit\Framework\isEmpty;

class CategoryController extends Controller
{

    /**
     * @OA\Get(
     *      path="/category",
     *      operationId="getCategoryList",
     *      tags={"Категории"},
     *      summary="Получение списка категорий",
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *       )
     *     )
     */
    public function index()
    {
        return response()->json(category::all(), 200);
    }

    /**
     * @OA\Post(
     *      path="/category",
     *      operationId="storeCategory",
     *      tags={"Категории"},
     *      summary="Создание новой категории",
     *     @OA\RequestBody(
     *          required=true,
     *              @OA\JsonContent(
     *                  required={"name"},
     *                  @OA\Property(property="name", type="string", example="Новости"),
     *              ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     security={{ "apiKey": {} }}
     * )
     */
    public function store(Request $request)
    {

        if (!auth("sanctum")->check()) return response()->json(["error" => "Unauthenticated"], 401);

        $request->validate([
            "name" => "required"
        ]);

        $created = category::create($request->all());

        if (!$created) return response()->json(["error" => "Bad request"], 400);

        return response()->json($created, 201);
    }

    /**
     * @OA\Get(
     *      path="/category/{id}",
     *      operationId="getCategoryById",
     *      tags={"Категории"},
     *      summary="Получение категории по ID",
     *      @OA\Parameter(
     *          name="id",
     *          description="Category id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found"
     *      )
     * )
     */
    public function show($id)
    {
        $find = category::find($id);

        if (isEmpty($find)) return response()->json(["error" => "Not found"], 404);

        return response()->json($find, 200);
    }

    /**
     * @OA\Put(
     *      path="/category/{id}",
     *      operationId="updateCategory",
     *      tags={"Категории"},
     *      summary="Обновление существующей категории",
     *      @OA\Parameter(
     *          name="id",
     *          description="Category id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody(
     *          required=true,
     *              @OA\JsonContent(
     *                  required={"name"},
     *                  @OA\Property(property="name", type="string", example="Новости"),
     *              ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     security={{ "apiKey": {} }}
     * )
     */
    public function update(Request $request, $id)
    {
        if (!auth("sanctum")->check()) return response()->json(["error" => "Unauthenticated"], 401);

        $fields = $request->validate([
            "name" => "required"
        ]);

        $category = category::find($id);

        $updated = $category->update($fields["name"]);

        if (!$updated) return response()->json(["error" => "Bad Request"], 400);

        return response()->json($updated, 201);
    }

    /**
     * @OA\Delete(
     *      path="/category/{id}",
     *      operationId="deleteCategory",
     *      tags={"Категории"},
     *      summary="Удаление существующей категории",
     *      @OA\Parameter(
     *          name="id",
     *          description="Category id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     security={{ "apiKey": {} }}
     * )
     */
    public function destroy($id)
    {

        if (!auth("sanctum")->check()) return response()->json(["error" => "Unauthenticated"], 401);

        $deleted = category::destroy($id);

        if (!$deleted) return response()->json(["error" => "Bad Request"], 400);

        return response()->json($deleted, 200);
        
    }

    /**
     * Search for a name
     *
     * @param string $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return response()->json(category::where("name", "like", "%" . $name)->get());
    }
}
