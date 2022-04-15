<?php

namespace App\Http\Controllers;

use App\Models\likes;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    /**
     * @OA\Get(
     *      path="/likes",
     *      operationId="getLikesList",
     *      tags={"Likes"},
     *      summary="Get list of likes",
     *      description="Returns list of likes",
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
        return likes::all();
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
     *      path="/likes",
     *      operationId="storeLikes",
     *      tags={"Likes"},
     *      summary="Store new like",
     *      description="Returns like data",
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

        return likes::create($request->all());
    }

    /**
     * @OA\Get(
     *      path="/likes/{id}",
     *      operationId="getLikeById",
     *      tags={"Likes"},
     *      summary="Get like information",
     *      description="Returns like data",
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
        return likes::find($id);
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
     *      path="/likes/{id}",
     *      operationId="updateLike",
     *      tags={"Likes"},
     *      summary="Update existing like",
     *      description="Returns updated like data",
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
        $likes = likes::find($id);

        $likes->update($request->all());

        return $likes;
    }

    /**
     * @OA\Delete(
     *      path="/likes/{id}",
     *      operationId="deleteLike",
     *      tags={"Likes"},
     *      summary="Delete existing like",
     *      description="Deletes a record and returns no content",
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
        likes::destroy($id);
    }
}
