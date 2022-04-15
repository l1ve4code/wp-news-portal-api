<?php

namespace App\Http\Controllers;

use App\Models\post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    /**
     * @OA\Post(
     *      path="/post",
     *      operationId="storePost",
     *      tags={"Посты"},
     *      summary="Создать новый пост",
     *     @OA\RequestBody(
     *          required=true,
     *              @OA\JsonContent(
     *                  required={"category_id","group_id","title","description","short_desc","like_amount","see_amount","comm_amount"},
     *                  @OA\Property(property="category_id", type="number", example="1"),
     *                  @OA\Property(property="group_id", type="number", example="1"),
     *                  @OA\Property(property="title", type="string", example="Заголовок"),
     *                  @OA\Property(property="description", type="string", example="Описание"),
     *                  @OA\Property(property="short_desc", type="string", example="Краткое описание"),
     *                  @OA\Property(property="like_amount", type="number", example="1"),
     *                  @OA\Property(property="see_amount", type="number", example="1"),
     *                  @OA\Property(property="comm_amount", type="number", example="1"),
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

        if(!auth("sanctum")->check()) return response()->json(["error" => "Unauthenticated"], 401);

        $user_id = auth("sanctum")->user()->id;

        $fields = $request->validate([
            "category_id" => "required",
            "group_id" => "required",
            "title" => "required",
            "description" => "required",
            "short_desc" => "required",
            "like_amount" => "required",
            "see_amount" => "required",
            "comm_amount" => "required",
        ]);

        $post = post::create([
            "category_id" => $fields["category_id"],
            "group_id" => $fields["group_id"],
            "user_id" => $user_id,
            "title" => $fields["title"],
            "description" => $fields["description"],
            "short_desc" => $fields["short_desc"],
            "like_amount" => $fields["like_amount"],
            "see_amount" => $fields["see_amount"],
            "comm_amount" => $fields["comm_amount"],
        ]);

        return post::create($request->all());
    }

    /**
     * @OA\Get(
     *      path="/post/{id}",
     *      operationId="getPostById",
     *      tags={"Посты"},
     *      summary="Получение поста по ID",
     *      @OA\Parameter(
     *          name="id",
     *          description="Post id",
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
        return post::find($id);
    }

    /**
     * @OA\Put(
     *      path="/post/{id}",
     *      operationId="updatePost",
     *      tags={"Посты"},
     *      summary="Обновление существующего поста",
     *      @OA\Parameter(
     *          name="id",
     *          description="Post id",
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
        $post = post::find($id);

        $post->update($request->all());

        return $post;
    }

    /**
     * @OA\Delete(
     *      path="/post/{id}",
     *      operationId="deletePost",
     *      tags={"Посты"},
     *      summary="Удаление существующего поста",
     *      @OA\Parameter(
     *          name="id",
     *          description="Post id",
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
        post::destroy($id);
    }
}
