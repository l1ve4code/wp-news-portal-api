<?php

namespace App\Http\Controllers;

use App\Models\comment;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class CommentController extends Controller
{

    /**
     * @OA\Post(
     *      path="/comment",
     *      operationId="storeComment",
     *      tags={"Комментарии"},
     *      summary="Создание нового комментария",
     *     @OA\RequestBody(
     *          required=true,
     *              @OA\JsonContent(
     *                  required={"post_id","text","date"},
     *                  @OA\Property(property="post_id", type="number", example="3"),
     *                  @OA\Property(property="text", type="string", example="Классный пост"),
     *                  @OA\Property(property="date", type="string", example="2020-01-03"),
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
        if(!auth("sanctum")->check()) return response()->json(["error" => "Unauthenticated"], 401);

        $user_id = auth("sanctum")->user()->id;

        $fields = $request->validate([
            "post_id" => "required",
            "text" => "required",
            "date" => "required",
        ]);

        $created = comment::create([
            "user_id" => $user_id,
            "post_id" => $fields["post_id"],
            "text" => $fields["text"],
            "date" => $fields["date"],
        ]);

        if(!$created) return response()->json(["error" => "Bad request"], 400);

        return response()->json($created, 201);
    }

    /**
     * @OA\Get(
     *      path="/comment/{id}",
     *      operationId="getCommentById",
     *      tags={"Комментарии"},
     *      summary="Получение комментария по ID поста",
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
     *          description="Not Found"
     *      )
     * )
     */
    public function show($id)
    {
        $comments = comment::where("post_id", "=", $id)->orderBy("id", "desc")->get();

        if($comments) return response()->json(["error" => "Comments doesn't exists"], 404);

        return response()->json($comments, 200);
    }

    /**
     * @OA\Delete(
     *      path="/comment/{id}",
     *      operationId="deleteComment",
     *      tags={"Комментарии"},
     *      summary="Удаление существующего комментария",
     *      @OA\Parameter(
     *          name="id",
     *          description="Comment id",
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

        if (comment::find($id)->user_id != $user_id) return response()->json(["error" => "No access"], 403);

        $deleted = comment::destroy($id);

        if (!$deleted) return response()->json(["error" => "Bad Request"], 400);

        return response()->json($deleted, 200);
    }
}
