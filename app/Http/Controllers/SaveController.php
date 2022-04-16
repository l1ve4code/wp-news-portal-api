<?php

namespace App\Http\Controllers;

use App\Models\save;
use Illuminate\Http\Request;

class SaveController extends Controller
{

    /**
     * @OA\Get(
     *      path="/save",
     *      operationId="getSaveList",
     *      tags={"Сохраненные группы"},
     *      summary="Получение списка сохраненных групп пользователя",
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     security={{ "sanctum": {} }}
     *     )
     */
    public function index()
    {
        if (!auth("sanctum")->check()) return response()->json(["error" => "Unauthenticated"], 401);

        $user_id = auth("sanctum")->user()->id;

        return response()->json(save::where("user_id", "=", $user_id)->get(), 200);
    }

    /**
     * @OA\Post(
     *      path="/save",
     *      operationId="storeSave",
     *      tags={"Сохраненные группы"},
     *      summary="Добавление группы в сохранения пользователя",
     *     @OA\RequestBody(
     *          required=true,
     *              @OA\JsonContent(
     *                  required={"post_id"},
     *                  @OA\Property(property="post_id", type="number", example="3"),
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

        if (save::where("user_id","=", $user_id)->where("post_id", "=", $fields["post_id"])->exists()) return response()->json(["error" => "Save exists"], 403);

        $created = save::create([
            "user_id" => $user_id,
            "post_id" => $fields["post_id"],
        ]);

        if (!$created) return response()->json(["error" => "Bad Request"], 400);

        return response()->json($created, 201);
    }

    /**
     * @OA\Delete(
     *      path="/save/{id}",
     *      operationId="deleteSave",
     *      tags={"Сохраненные группы"},
     *      summary="Удаление сохраненной группы",
     *      @OA\Parameter(
     *          name="id",
     *          description="Save id",
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

        if(!save::where("post_id", "=", $id)->where("user_id", "=", $user_id)->exists()) return response()->json(["error" => "Not found"], 404);

        $save_id = save::where("user_id","=", $user_id)->where("post_id", "=", $id)->get()[0]["id"];

        if (save::find($save_id)->user_id != $user_id) return response()->json(["error" => "No access"], 403);

        $find = save::find($save_id);

        $deleted = save::destroy($save_id);

        if (!$deleted) return response()->json(["error" => "Bad Request"], 400);

        return response()->json($find, 200);
    }
}
