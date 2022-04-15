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
     *      summary="Get list of saves",
     *      description="Returns list of saves",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
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
     *      summary="Store new save",
     *      description="Returns save data",
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
     *      summary="Delete existing save",
     *      description="Deletes a record and returns no content",
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
        save::destroy($id);
    }
}
