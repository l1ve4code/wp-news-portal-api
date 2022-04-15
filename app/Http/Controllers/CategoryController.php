<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class CategoryController extends Controller
{

    /**
     * @OA\Get(
     *      path="/category",
     *      operationId="getCategoryList",
     *      tags={"Категории"},
     *      summary="Получение списка категорий",
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
     *      )
     *     )
     */
    public function index()
    {
        return category::all();
    }

    /**
     * @OA\Post(
     *      path="/category",
     *      operationId="storeCategory",
     *      tags={"Категории"},
     *      summary="Создание новой категории",
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
        $request->validate([
            "name" => "required"
        ]);

       return category::create($request->all());
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
     *      )
     * )
     */
    public function show($id)
    {
        return category::find($id);
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
        $category = category::find($id);

        $category->update($request->all());

        return $category;
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
    public function destroy($id)
    {
        category::destroy($id);
    }

    /**
     * Search for a name
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return category::where("name", "like", "%".$name)->get();
    }
}
