<?php

namespace App\Http\Controllers;

use App\Models\groups;
use App\Models\subscribes;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class SubscribesController extends Controller
{

    /**
     * @OA\Post(
     *      path="/subscribes/group/{id}",
     *      operationId="storeSubscribesGroups",
     *      tags={"Подписки"},
     *      summary="Подписка пользователя на группу",
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
    public function store_group($id)
    {
        $group = groups::find($id);

        if(isEmpty($group)) return response()->json(["error" => "Group doesn't exists"], 500);

        $created = subscribes::create(["group_id" => $id, auth('sanctum')->user()->id]);

        return response()->json($created);
    }

    /**
     * @OA\Get(
     *      path="/subscribes/{id}",
     *      operationId="getSubscribesById",
     *      tags={"Подписки"},
     *      summary="Получение информации о подписке",
     *      @OA\Parameter(
     *          name="id",
     *          description="Subscribes id",
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
    public function show($id)
    {
        return subscribes::find($id);
    }

    /**
     * @OA\Delete(
     *      path="/subscribes/{id}",
     *      operationId="deleteSubscribes",
     *      tags={"Подписки"},
     *      summary="Удаление существующей подписки",
     *      @OA\Parameter(
     *          name="id",
     *          description="Subscribes id",
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
        $deleted = subscribes::destroy($id);
        return response()->json($deleted);
    }
}
