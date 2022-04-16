<?php

namespace App\Http\Controllers;

use App\Models\groups;
use App\Models\subscribes;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class SubscribesController extends Controller
{

    /**
     * @OA\Get(
     *      path="/subscribes",
     *      operationId="getSubscribes",
     *      tags={"Подписки"},
     *      summary="Получение списка подписок пользователя",
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

        return response()->json(subscribes::where("user_id", "=", $user_id)->get(), 200);
    }

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
     *     security={{ "sanctum": {} }}
     * )
     */
    public function store_group($id)
    {
        if (!auth("sanctum")->check()) return response()->json(["error" => "Unauthenticated"], 401);

        $user_id = auth("sanctum")->user()->id;

        $group = groups::find($id);

        if (subscribes::where("user_id", "=", $user_id)->where("group_id", "=", $id)->exists()) return response()->json(["error" => "Subscribe exists"], 403);

        if (!$group) return response()->json(["error" => "Group doesn't exists"], 404);

        $created = subscribes::create([
            "user_id"  => $user_id,
            "group_id" => $id
        ]);

        $group_subs = $group->subs_amount + 1;

        groups::find($id)->update([
            "subs_amount" => $group_subs
        ]);

        return response()->json($created, 201);
    }

    /**
     * @OA\Delete(
     *      path="/subscribes/group/{id}",
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
     *     security={{ "sanctum": {} }}
     * )
     */
    public function destroy($id)
    {
        if (!auth("sanctum")->check()) return response()->json(["error" => "Unauthenticated"], 401);

        $user_id = auth("sanctum")->user()->id;

        if(!subscribes::where("user_id","=", $user_id)->where("group_id", "=", $id)->exists()) return response()->json(["error" => "Not found"], 404);

        $subscribe_id = subscribes::where("user_id","=", $user_id)->where("group_id", "=", $id)->get()[0]["id"];

        $find = subscribes::find($subscribe_id);

        $deleted = subscribes::destroy($subscribe_id);

        if (!$deleted) return response()->json(["error" => "Bad Request"], 400);

        $group_subs = groups::find($find->group_id)->subs_amount - 1;

        groups::find($find->group_id)->update([
            "subs_amount" => $group_subs
        ]);

        return response()->json($find, 200);
    }
}
