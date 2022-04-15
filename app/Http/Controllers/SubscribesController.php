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
     *      @OA\Parameter(
     *          name="id",
     *          description="Subscribe id",
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
     *          response=404,
     *          description="Not found"
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
        if (!auth("sanctum")->check()) return response()->json(["error" => "Unauthenticated"], 401);

        $group = groups::find($id);

        if(!$group) return response()->json(["error" => "Group doesn't exists"], 404);

        $created = subscribes::create(["group_id" => $id, auth('sanctum')->user()->id]);

        return response()->json($created, 201);
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
     *      ),
     *     security={{ "apiKey": {} }}
     * )
     */
    public function show($id)
    {
        if (!auth("sanctum")->check()) return response()->json(["error" => "Unauthenticated"], 401);

        $find = subscribes::find($id);

        if (!$find) return response()->json(["error" => "Not found"], 404);

        return response()->json($find, 200);
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
     *     security={{ "apiKey": {} }}
     * )
     */
    public function destroy($id)
    {
        if (!auth("sanctum")->check()) return response()->json(["error" => "Unauthenticated"], 401);

        $deleted = subscribes::destroy($id);

        if (!$deleted) return response()->json(["error" => "Bad Request"], 400);

        return response()->json($deleted, 200);
    }
}
