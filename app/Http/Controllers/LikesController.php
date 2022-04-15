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
     *      description="Возвращает информацию о лайке",
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
        ]);

        $created = likes::create($request->all());

        if(isEmpty($created)) return response()->json(["error" => "Bad request"], 500);

        return response()->json($created);
    }

    /**
     * @OA\Delete(
     *      path="/likes/{id}",
     *      operationId="deleteLike",
     *      tags={"Лайки"},
     *      summary="Удаление существующего лайка",
     *      description="Возвращает удаленный лайк",
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
        $deleted = likes::destroy($id);
        return response()->json($deleted);
    }
}
