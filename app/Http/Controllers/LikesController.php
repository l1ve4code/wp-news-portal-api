<?php

namespace App\Http\Controllers;

use App\Models\likes;
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

        $created = likes::create([
            "user_id" => $user_id,
            "post_id" => $fields["post_id"]
        ]);

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

        $deleted = likes::destroy($id);

        if (!$deleted) return response()->json(["error" => "Bad Request"], 400);

        return response()->json($deleted, 200);
    }
}
