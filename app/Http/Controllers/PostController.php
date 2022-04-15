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
            "category_id" => "required",
            "user_id" => "required",
            "group_id" => "required",
            "title" => "required",
            "description" => "required",
            "short_desc" => "required",
            "like_amount" => "required",
            "see_amount" => "required",
            "comm_amount" => "required",
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
