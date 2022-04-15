<?php

namespace App\Http\Controllers;

use App\Models\comment;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class CommentController extends Controller
{
    /**
     * @OA\Get(
     *      path="/comment",
     *      operationId="getCommentList",
     *      tags={"Комментарии"},
     *      summary="Получение списка комментариев",
     *      description="Возвращает список комментариев",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index()
    {
        return response()->json(comment::all());
    }

    /**
     * @OA\Post(
     *      path="/comment",
     *      operationId="storeComment",
     *      tags={"Комментарии"},
     *      summary="Создание нового комментария",
     *      description="Возвращает данные комментария",
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
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            "user_id" => "required",
            "post_id" => "required",
            "text" => "required",
            "date" => "required",
        ]);

        $created = comment::create($request->all());

        if(!$created) return response()->json(["Error" => "Bad request"], 500);

        return response()->json($created);
    }

    /**
     * @OA\Get(
     *      path="/comment/{id}",
     *      operationId="getCommentById",
     *      tags={"Комментарии"},
     *      summary="Получение комментария по id поста",
     *      description="Возвращает данные о комментарии",
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
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function show($id)
    {
        $comments = comment::where("post_id", "=", $id)->orderBy("id", "desc")->get();

        if(isEmpty($comments)) return response()->json(["error" => "Comments doesn't exists"], 400);

        return response()->json($comments);

    }

    /**
     * @OA\Delete(
     *      path="/comment/{id}",
     *      operationId="deleteComment",
     *      tags={"Комментарии"},
     *      summary="Удаляет существующий комментарий",
     *      description="Возвращает удаленный комментарий",
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
     *          response=204,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function destroy($id)
    {
        comment::destroy($id);
    }
}
