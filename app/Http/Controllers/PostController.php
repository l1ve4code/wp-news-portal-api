<?php

namespace App\Http\Controllers;

use App\Models\groups;
use App\Models\post;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

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
     *     security={{ "sanctum": {} }}
     * )
     */
    public function store(Request $request)
    {
        if (!auth("sanctum")->check()) return response()->json(["error" => "Unauthenticated"], 401);

        $user_id = auth("sanctum")->user()->id;

        $fields = $request->validate([
            "category_id" => "required",
            "group_id"    => "required",
            "title"       => "required",
            "description" => "required",
            "short_desc"  => "required",
        ]);

        if(groups::find($fields["group_id"])->admin_id != $user_id) return response()->json(["error" => "No access"], 403);

        $created = post::create([
            "category_id" => $fields["category_id"],
            "group_id"    => $fields["group_id"],
            "user_id"     => $user_id,
            "title"       => $fields["title"],
            "description" => $fields["description"],
            "short_desc"  => $fields["short_desc"],
            "like_amount" => 0,
            "see_amount"  => 0,
            "comm_amount" => 0,
        ]);

        if (!$created) return response()->json(["error" => "Bad request"], 400);

        return response()->json($created, 201);
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
     *          response=200,
     *          description="OK",
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function show($id)
    {
        $find = post::find($id);

        if (!$find) return response()->json(["error" => "Not found"], 404);

        return response()->json($find, 200);
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
     *     @OA\RequestBody(
     *          required=true,
     *              @OA\JsonContent(
     *                  required={"category_id","group_id","title","description","short_desc","like_amount","see_amount","comm_amount"},
     *                  @OA\Property(property="category_id", type="number", example="1"),
     *                  @OA\Property(property="group_id", type="number", example="1"),
     *                  @OA\Property(property="title", type="string", example="Заголовок"),
     *                  @OA\Property(property="description", type="string", example="Описание"),
     *                  @OA\Property(property="short_desc", type="string", example="Краткое описание"),
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
     *     security={{ "sanctum": {} }}
     * )
     */
    public function update(Request $request, $id)
    {
        if (!auth("sanctum")->check()) return response()->json(["error" => "Unauthenticated"], 401);

        $user_id = auth("sanctum")->user()->id;

        if (post::find($id)->user_id != $user_id) return response()->json(["error" => "No access"], 403);

        $post = post::find($id);

        $fields = $request->validate([
            "category_id" => "required",
            "group_id"    => "required",
            "title"       => "required",
            "description" => "required",
            "short_desc"  => "required",
        ]);

        $updated = $post->update([
            "category_id" => $fields["category_id"],
            "group_id"    => $fields["group_id"],
            "user_id"     => $user_id,
            "title"       => $fields["title"],
            "description" => $fields["description"],
            "short_desc"  => $fields["short_desc"],
        ]);

        if (!$updated) return response()->json(["error" => "Bad request"], 400);

        $updated = post::find($id);

        return response()->json($updated, 201);
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
     *     security={{ "sanctum": {} }}
     * )
     */
    public function destroy($id)
    {
        if (!auth("sanctum")->check()) return response()->json(["error" => "Unauthenticated"], 401);

        $user_id = auth("sanctum")->user()->id;

        if(!post::find($id)) return response()->json(["error" => "Not found"], 404);

        if (post::find($id)->user_id != $user_id) return response()->json(["error" => "No access"], 403);

        $find = post::find($id);

        $deleted = post::destroy($id);

        if (!$deleted) return response()->json(["error" => "Bad Request"], 400);

        return response()->json($find, 200);
    }
}
