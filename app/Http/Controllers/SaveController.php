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
            "post_id" => "required",
            "user_id" => "required"
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
