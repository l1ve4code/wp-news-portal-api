<?php

namespace App\Http\Controllers;

use App\Models\groups;
use App\Models\post;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class GroupsController extends Controller
{

    /**
     * @OA\Get(
     *      path="/groups",
     *      operationId="getGroupsList",
     *      tags={"Группы"},
     *      summary="Получение списка групп",
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *       )
     *     )
     */
    public function index()
    {
        return response()->json(groups::all(), 200);
    }

    /**
     * @OA\Post(
     *      path="/groups",
     *      operationId="storeGroups",
     *      tags={"Группы"},
     *      summary="Создание новой группы",
     *     @OA\RequestBody(
     *          required=true,
     *              @OA\JsonContent(
     *                  required={"category_id","post_id","title","description","subs_amount"},
     *                  @OA\Property(property="category_id", type="number", example="1"),
     *                  @OA\Property(property="post_id", type="number", example="5"),
     *                  @OA\Property(property="title", type="string", example="PolyNews"),
     *                  @OA\Property(property="description", type="string", example="Какое-то описание"),
     *                  @OA\Property(property="subs_amount", type="number", example="0"),
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
            "category_id" => "required",
            "post_id" => "required",
            "title" => "required",
            "description" => "required",
            "subs_amount" => "required",
        ]);

        $created = groups::create([
            "category_id" => $fields["category_id"],
            "post_id" => $fields["post_id"],
            "title" => $fields["title"],
            "description" => $fields["description"],
            "subs_amount" => $fields["subs_amount"],
            "admin_id" => $user_id,
        ]);

        if(!$created) return response()->json(["error" => "Bad request"], 400);

        return response()->json($created, 201);
    }

    /**
     * @OA\Get(
     *      path="/groups/{id}",
     *      operationId="getGroupsById",
     *      tags={"Группы"},
     *      summary="Получение информацию о группе по ID",
     *      @OA\Parameter(
     *          name="id",
     *          description="Groups id",
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
     *          description="Not Found"
     *      )
     * )
     */
    public function show($id)
    {
        $group = groups::find($id);

        if (!$group) return response()->json(["error" => "Group doesn't exists"], 404);

        $posts = post::where("group_id","=", $id)->orderBy("id", "desc")->get();

        return response()->json(["group" => $group, "posts" => $posts], 200);
    }

    /**
     * @OA\Get(
     *      path="/groups/category/{id}",
     *      operationId="getGroupsByCategoryID",
     *      tags={"Группы"},
     *      summary="Получение групп по ID категории",
     *      @OA\Parameter(
     *          name="id",
     *          description="Category id",
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
     *      )
     * )
     */
    public function show_groups_by_category($id){

        $groups = groups::where("category_id", "=", $id)->get();

        if(!$groups) return response()->json(["error" => "Not found"], 404);

        return response()->json(["group" => $groups], 200);
    }

    /**
     * @OA\Put(
     *      path="/groups/{id}",
     *      operationId="updateGroup",
     *      tags={"Группы"},
     *      summary="Обновление существующей группы",
     *      @OA\Parameter(
     *          name="id",
     *          description="Group id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody(
     *          required=true,
     *              @OA\JsonContent(
     *                  required={"category_id","post_id","title","description","subs_amount"},
     *                  @OA\Property(property="category_id", type="number", example="1"),
     *                  @OA\Property(property="post_id", type="number", example="5"),
     *                  @OA\Property(property="title", type="string", example="PolyNews"),
     *                  @OA\Property(property="description", type="string", example="Какое-то описание"),
     *                  @OA\Property(property="subs_amount", type="number", example="0"),
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
    public function update(Request $request, $id)
    {

        if(!auth("sanctum")->check()) return response()->json(["error" => "Unauthenticated"], 401);

        $user_id = auth("sanctum")->user()->id;

        $group = groups::find($id);

        $fields = $request->validate([
            "category_id" => "required",
            "post_id" => "required",
            "title" => "required",
            "description" => "required",
            "subs_amount" => "required",
        ]);

        $updated = $group->update([
            "category_id" => $fields["category_id"],
            "post_id" => $fields["post_id"],
            "title" => $fields["title"],
            "description" => $fields["description"],
            "subs_amount" => $fields["subs_amount"],
            "admin_id" => $user_id,
        ]);

        if (!$updated) return response()->json(["error" => "Bad Request"], 400);

        return response()->json($updated, 201);
    }

    /**
     * @OA\Delete(
     *      path="/groups/{id}",
     *      operationId="deleteGroup",
     *      tags={"Группы"},
     *      summary="Удаление существующей группы",
     *      @OA\Parameter(
     *          name="id",
     *          description="Group id",
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

        $deleted = groups::destroy($id);

        if (!$deleted) return response()->json(["error" => "Bad Request"], 400);

        return response()->json($deleted, 200);
    }
}
