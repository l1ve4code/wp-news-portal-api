<?php

namespace App\Http\Controllers;

use App\Models\subscribes;
use Illuminate\Http\Request;

class SubscribesController extends Controller
{
    /**
     * @OA\Get(
     *      path="/subscribes",
     *      operationId="getSubscribesList",
     *      tags={"Subscribes"},
     *      summary="Get list of subscribes",
     *      description="Returns list of subscribes",
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
        return subscribes::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *      path="/subscribes",
     *      operationId="storeSubscribes",
     *      tags={"Subscribes"},
     *      summary="Store new subscribes",
     *      description="Returns subscribes data",
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
            "group_id" => "required",
        ]);

        return subscribes::create($request->all());
    }

    /**
     * @OA\Get(
     *      path="/subscribes/{id}",
     *      operationId="getSubscribesById",
     *      tags={"Subscribes"},
     *      summary="Get subscribes information",
     *      description="Returns subscribes data",
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
    public function show($id)
    {
        return subscribes::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @OA\Put(
     *      path="/subscribes/{id}",
     *      operationId="updateSubscribes",
     *      tags={"Subscribes"},
     *      summary="Update existing subscribes",
     *      description="Returns updated subscribes data",
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
     *          response=202,
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
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function update(Request $request, $id)
    {
        $subscribes = subscribes::find($id);

        $subscribes->update($request->all());

        return $subscribes;
    }

    /**
     * @OA\Delete(
     *      path="/subscribes/{id}",
     *      operationId="deleteSubscribes",
     *      tags={"Subscribes"},
     *      summary="Delete existing subscribes",
     *      description="Deletes a record and returns no content",
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
        subscribes::destroy($id);
    }
}
