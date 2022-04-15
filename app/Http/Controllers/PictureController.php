<?php

namespace App\Http\Controllers;

use App\Models\user_picture;
use Illuminate\Http\Request;

class PictureController extends Controller
{
    /**
     * @OA\Get(
     *      path="/picture",
     *      operationId="getPictureList",
     *      tags={"Picture"},
     *      summary="Get list of pictures",
     *      description="Returns list of pictures",
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
        return user_picture::all();
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
     *      path="/picture",
     *      operationId="storePicture",
     *      tags={"Picture"},
     *      summary="Store new picture",
     *      description="Returns picture data",
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
            "url" => "required",
        ]);

        return user_picture::create($request->all());
    }

    /**
     * @OA\Get(
     *      path="/picture/{id}",
     *      operationId="getPictureById",
     *      tags={"Picture"},
     *      summary="Get picture information",
     *      description="Returns picture data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Picture id",
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
        return user_picture::find($id);
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
     *      path="/picture/{id}",
     *      operationId="updatePicture",
     *      tags={"Picture"},
     *      summary="Update existing picture",
     *      description="Returns updated picture data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Picture id",
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
        $picture = user_picture::find($id);

        $picture->update($request->all());

        return $picture;
    }

    /**
     * @OA\Delete(
     *      path="/picture/{id}",
     *      operationId="deletePicture",
     *      tags={"Picture"},
     *      summary="Delete existing picture",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Picture id",
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
        user_picture::destroy($id);
    }
}
