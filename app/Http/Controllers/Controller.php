<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API - Новостного портала",
 *      description="Участники: Веденин Иван, Тишкина Алина, Федор Пережогин, Александр Сергеев",
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="API"
 * )
 *
 * @OA\Tag(
 *     name="Category",
 *     description="API Endpoints of Category"
 * )
 * @OA\Tag(
 *     name="Comment",
 *     description="API Endpoints of Comment"
 * )
 * @OA\Tag(
 *     name="Groups",
 *     description="API Endpoints of Groups"
 * )
 * @OA\Tag(
 *     name="Likes",
 *     description="API Endpoints of Likes"
 * )
 * @OA\Tag(
 *     name="Picture",
 *     description="API Endpoints of Picture"
 * )
 * @OA\Tag(
 *     name="Post",
 *     description="API Endpoints of Post"
 * )
 * @OA\Tag(
 *     name="Save",
 *     description="API Endpoints of Save"
 * )
 * @OA\Tag(
 *     name="Subscribes",
 *     description="API Endpoints of Subscribes"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
