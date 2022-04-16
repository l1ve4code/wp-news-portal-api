<?php

namespace App\Http\Controllers;

use App\Models\likes;
use App\Models\post;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class LikesController extends Controller
{

    /**
     * @OA\Post(
     *      path="/likes",
     *      operationId="storeLikes",
     *      tags={"Лайки"},
     *      summary="Поставить лайк",
     *     @OA\RequestBody(
     *          required=true,
     *              @OA\JsonContent(
     *                  required={"post_id"},
     *                  @OA\Property(property="post_id", type="number", example="1"),
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
        ]);

        if (likes::where("user_id","=", $user_id)->where("post_id", "=", $fields["post_id"])->exists()) return response()->json(["error" => "Like exists"], 403);

        $created = likes::create([
            "user_id" => $user_id,
            "post_id" => $fields["post_id"]
        ]);

        $post_like = post::find($fields["post_id"])->like_amount + 1;

        post::find($fields["post_id"])->update(["like_amount" => $post_like]);

        if(!$created) return response()->json(["error" => "Bad request"], 400);

        return response()->json($created, 201);
    }

    /**
     * @OA\Delete(
     *      path="/likes/{id}",
     *      operationId="deleteLike",
     *      tags={"Лайки"},
     *      summary="Удалить лайк",
     *      @OA\Parameter(
     *          name="id",
     *          description="Like id",
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

        if(!likes::where("user_id","=", $user_id)->where("post_id", "=", $id)->exists()) return response()->json(["error" => "Not found"], 404);

        $like_id = likes::where("user_id","=", $user_id)->where("post_id", "=", $id)->get()[0]["id"];

        if (likes::find($like_id)->user_id != $user_id) return response()->json(["error" => "No access"], 403);

        $find = likes::find($like_id);

        $deleted = likes::destroy($like_id);

        $post_like = post::find($find->post_id)->like_amount - 1;

        post::find($find->post_id)->update(["like_amount" => $post_like]);

        if (!$deleted) return response()->json(["error" => "Bad Request"], 400);

        return response()->json($find, 200);
    }
}
