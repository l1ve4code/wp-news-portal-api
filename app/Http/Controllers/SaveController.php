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
     *     )
     */
    public function index()
    {
        return save::all();
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
     *     security={{ "apiKey": {} }}
     * )
     */
    public function store(Request $request)
    {

        if(!auth("sanctum")->check()) return response()->json(["error" => "Unauthenticated"], 401);

        $user_id = auth("sanctum")->user()->id;

        $fields = $request->validate([
            "post_id" => "required",
        ]);

        $save = save::create([
            "user_id" => $user_id,
            "post_id" => $fields["post_id"],
        ]);

        return save::create($request->all());
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
        save::destroy($id);
    }
}
