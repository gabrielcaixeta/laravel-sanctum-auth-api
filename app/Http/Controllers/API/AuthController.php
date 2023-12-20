<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Validator;

// * @OA\Server(url="http://127.0.0.1:8000")
/**
 * @OA\Info(
 *   title="Task API Documentation",
 *   version="0.0.1",
 * )
 * @OA\Server(url="https://laravel-sanctum-auth.azurewebsites.net/")
 * @OA\SecurityScheme(
 *  type="http",
 *  description="Acess token obtido na autenticação",
 *  name="Authorization",
 *  in="header",
 *  scheme="bearer",
 *  bearerFormat="JWT",
 *  securityScheme="bearerToken"
 * )
 */

class AuthController extends BaseController
{

    /**
     * @OA\Post(
     *  tags={"Sanctum Authentication"},
     *  summary="Realiza o login e retorna um token de sessão",
     *  description="retorna um token para acesso a rotas protegidas",
     *  path="/api/v1/auth/login",
     *  @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="body",
     *          @OA\Schema(
     *              required={"email","password"},
     *              @OA\Property(property="email", type="string", example="gabriel@example.org"),
     *              @OA\Property(property="password", type="string", example="#sdasd$ssdaAA@")
     *          )
     *      ),
     *  ),
     *  @OA\Response(
     *    response=200,
     *    description="User logged-in!",
     *    @OA\JsonContent(
     *       @OA\Property(property="plainTextToken", type="string", example="2|MZEBxLy1zulPtND6brlf8GOPy57Q4DwYunlibXGj")
     *    )
     *  ),
     *  @OA\Response(
     *    response=404,
     *    description="Incorrect credentials",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="bool", example=false),
     *       @OA\Property(property="message", type="string", example="Unauthorised."),
     *    )
     *  )
     * )
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $auth = Auth::user();
            $success['token'] =  $auth->createToken('LaravelSanctumAuth')->plainTextToken;
            $success['name'] =  $auth->name;

            return $this->handleResponse($success, 'User logged-in!');
        } else {
            return $this->handleError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    /**
     * @OA\Post(
     *  tags={"Sanctum Authentication"},
     *  summary="Cadastra um novo usuário",
     *  description="Cadastra um novo usuário para se autenticar na aplicação",
     *  path="/api/v1/auth/register",
     *  @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="body",
     *          @OA\Schema(
     *              required={"name","email","password","confirm_password"},
     *              @OA\Property(property="name", type="string", example="João da Silva"),
     *              @OA\Property(property="email", type="string", example="gabriel@example.org"),
     *              @OA\Property(property="password", type="string", example="ksdasd9ssdaAA"),
     *              @OA\Property(property="confirm_password", type="string", example="ksdasd9ssdaAA")
     *          )
     *      ),
     *  ),
     *  @OA\Response(
     *    response=200,
     *    description="User logged-in!",
     *    @OA\JsonContent(
     *       @OA\Property(property="plainTextToken", type="string", example="2|MZEBxLy1zulPtND6brlf8GOPy57Q4DwYunlibXGj")
     *    )
     *  ),
     *  @OA\Response(
     *    response=404,
     *    description="Campos obrigatórios não foram informados ou os campos desenha não batem",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="bool", example=false),
     *       @OA\Property(property="message", type="object", example="{'confirm_password':'The confirm password and password must match.'}"),
     *    ),
     *  )
     * )
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->handleError($validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('LaravelSanctumAuth')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->handleResponse($success, 'User successfully registered!');
    }

    /**
     * @OA\Post(
     *  tags={"Sanctum Authentication"},
     *  summary="Encerra a seção do usuário",
     *  description="Encerra a seção do usuário logado",
     *  path="/api/v1/auth/logout",
     *  @OA\Response(
     *    response=200,
     *    description="User logged-out!",
     *  ),
     * )
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return $this->handleResponse([], 'User successfully logout!');
    }
}
