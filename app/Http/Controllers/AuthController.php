<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * @OA\Post(
     *      path="/register",
     *      operationId="register",
     *      tags={"Auth"},
     *      summary="Register new user",
     *      description="Returns registered user",
     *      @OA\RequestBody(
     *          required=true,
     *          description="Register credentials",
     *              @OA\JsonContent(
     *                  required={"name", "email","password"},
     *                  @OA\Property(property="name", type="string", example="Ivan Ivanov"),
     *                  @OA\Property(property="email", type="string", format="email", example="example@mail.com"),
     *                  @OA\Property(property="password", type="string", format="password", example="1sd@a32jNSFM"),
     *              ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      )
     * )
     *
     */
    public function register(Request $request)
    {
        $fields = $request->validate([
            "name"     => "required|string",
            "email"    => "required|string|unique:users,email",
            "password" => "required|string"
        ]);

        $user = User::create([
            "name"     => $fields["name"],
            "email"    => $fields["email"],
            "password" => bcrypt($fields["password"])
        ]);

        $token = $user->createToken("token")->plainTextToken;

        $response = [
            "user"  => $user,
            "token" => $token
        ];

        return response($response, 201);
    }

    /**
     * @OA\Post(
     *      path="/login",
     *      operationId="login",
     *      tags={"Auth"},
     *      summary="Login user",
     *      description="Returns authorized user",
     *     @OA\RequestBody(
     *          required=true,
     *          description="Login credentials",
     *              @OA\JsonContent(
     *                  required={"email","password"},
     *                  @OA\Property(property="email", type="string", format="email", example="example@mail.com"),
     *                  @OA\Property(property="password", type="string", format="password", example="1sd@a32jNSFM"),
     *              ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      )
     * )
     */
    public function login(Request $request)
    {

        $fields = $request->validate([
            "email"    => "required|string",
            "password" => "required|string"
        ]);

        $user = User::where("email", "=", $fields["email"])->first();

        if (!$user || !Hash::check($fields["password"], $user->password)) {
            return response([
                "message" => "Bad credentials"
            ], 401);
        }

        $token = $user->createToken("token")->plainTextToken;

        $response = [
            "user"  => $user,
            "token" => $token
        ];

        return response($response, 201);
    }

    /**
     * @OA\Post(
     *      path="/logout",
     *      operationId="logout",
     *      tags={"Auth"},
     *      summary="Logout",
     *      description="Returns nothing",
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *     security={{ "apiKey": {} }}
     * )
     */
    public function logout()
    {

//        auth()->user()->tokens()->delete();

        return response()->json([
            "message" => "Logged out"
        ]);
    }

}
