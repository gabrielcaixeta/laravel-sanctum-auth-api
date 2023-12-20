<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Task as TaskResource;
use App\Models\Task;
use Validator;


class TaskController extends BaseController
{

    /**
     * @OA\Get(
     *  tags={"Task"},
     *  summary="Lista todas as tasks",
     *  description="Lista todas as tasks",
     *  path="/api/v1/tasks",
     *  @OA\Response(
     *    response=200,
     *    description="Retorna uma array de tasks",
     *    @OA\JsonContent(
     *      @OA\Property(
     *          property="message",
     *          description="Retona a mensagem de erro ou sucesso",
     *          type="string",
     *          example="Tasks have been retrieved!"
     *       ),
     *    @OA\Property(
     *         property="success",
     *         description="Retorna o status os sucesso",
     *         type="bool",
     *         example=true
     *      ),
     *      @OA\Property(property="data", type="array",
     *         @OA\Items(
     *            type="array",
     *            description="Retorna o vetor de tasks",
     *            @OA\Items(
     *               @OA\Property(
     *                  property="id",
     *                  description="ID",
     *                  type="int",
     *                  example=1
     *               ),
     *               @OA\Property(
     *                  property="name",
     *                  description="título da tarefa",
     *                  type="string",
     *                  example="tarefa 1"
     *               ),
     *               @OA\Property(
     *                  property="done",
     *                  description="status",
     *                  type="bool",
     *                  example=false
     *               ),
     *               @OA\Property(
     *                  property="created_at",
     *                  description="status",
     *                  type="string",
     *                  example="20/12/2023"
     *               ),
     *               @OA\Property(
     *                  property="updated_at",
     *                  description="status",
     *                  type="string",
     *                  example="20/12/2023"
     *               ),
     *
     *            )
     *         ),
     *      )
     *    )
     *  ),
     *  @OA\Response(
     *    response=401,
     *    description="Não autorizado",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Unauthenticated.")
     *    ),
     *  )
     * )
     */
    public function index()
    {
        $tasks = Task::all();
        return $this->handleResponse(TaskResource::collection($tasks), 'Tasks have been retrieved!');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->handleError($validator->errors());
        }
        $task = Task::create($input);
        return $this->handleResponse(new TaskResource($task), 'Task created!');
    }


    /**
     * @OA\Get(
     *  tags={"Task"},
     *  summary="Lista todas as tasks",
     *  description="Lista todas as tasks",
     *  path="/api/v1/tasks/{id}",
     *  @OA\Parameter(
     *     name="id",
     *     in="path"
     *  ),
     *  @OA\Response(
     *    response=200,
     *    description="Retorna os dados de uma task",
     *    @OA\JsonContent(
     *      @OA\Property(
     *          property="message",
     *          description="Retona a mensagem de erro ou sucesso",
     *          type="string",
     *          example="Task retrieved!"
     *       ),
     *    @OA\Property(
     *         property="success",
     *         description="Retorna o status os sucesso",
     *         type="bool",
     *         example=true
     *      ),
     *      @OA\Property(property="data", type="object",
     *          example=@OA\Schema(
     *               schema="task",
     *               @OA\Property(
     *                  property="id",
     *                  description="ID",
     *                  type="int",
     *                  example=1
     *               ),
     *               @OA\Property(
     *                  property="name",
     *                  description="título da tarefa",
     *                  type="string",
     *                  example="tarefa 1"
     *               ),
     *               @OA\Property(
     *                  property="done",
     *                  description="status",
     *                  type="bool",
     *                  example=false
     *               ),
     *               @OA\Property(
     *                  property="created_at",
     *                  description="status",
     *                  type="string",
     *                  example="20/12/2023"
     *               ),
     *               @OA\Property(
     *                  property="updated_at",
     *                  description="status",
     *                  type="string",
     *                  example="20/12/2023"
     *               ),
     *         ),
     *      )
     *    )
     *  ),
     *  @OA\Response(
     *    response=401,
     *    description="Não autorizado",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Unauthenticated.")
     *    ),
     *  ),
     *  @OA\Response(
     *    response=404,
     *    description="Não encontrado",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Not found")
     *    ),
     *  )
     * )
     */
    public function show($id)
    {
        $task = Task::find($id);
        if (is_null($task)) {
            return $this->handleError('Task not found!');
        }
        return $this->handleResponse(new TaskResource($task), 'Task retrieved.');
    }

    /**
     * @OA\Put(
     *  tags={"Task"},
     *  summary="Lista todas as tasks",
     *  description="Lista todas as tasks",
     *  path="/api/v1/tasks/{id}",
     *  @OA\Parameter(
     *     name="id",
     *     in="path"
     *  ),
     * @OA\Parameter(
     *     name="name",
     *     in="query"
     *  ),
     * @OA\Parameter(
     *     name="done",
     *     in="query"
     *  ),
     *  @OA\Response(
     *    response=200,
     *    description="Retorna os dados de uma task",
     *    @OA\JsonContent(
     *      @OA\Property(
     *          property="message",
     *          description="Retona a mensagem de erro ou sucesso",
     *          type="string",
     *          example="Task retrieved!"
     *       ),
     *    @OA\Property(
     *         property="success",
     *         description="Retorna o status os sucesso",
     *         type="bool",
     *         example=true
     *      ),
     *      @OA\Property(property="data", type="object",
     *          example=@OA\Schema(
     *               schema="task1",
     *               @OA\Property(
     *                  property="id",
     *                  description="ID",
     *                  type="int",
     *                  example=1
     *               ),
     *               @OA\Property(
     *                  property="name",
     *                  description="título da tarefa",
     *                  type="string",
     *                  example="tarefa 1"
     *               ),
     *               @OA\Property(
     *                  property="done",
     *                  description="status",
     *                  type="bool",
     *                  example=false
     *               ),
     *               @OA\Property(
     *                  property="created_at",
     *                  description="status",
     *                  type="string",
     *                  example="20/12/2023"
     *               ),
     *               @OA\Property(
     *                  property="updated_at",
     *                  description="status",
     *                  type="string",
     *                  example="20/12/2023"
     *               ),
     *         ),
     *      )
     *    )
     *  ),
     *  @OA\Response(
     *    response=401,
     *    description="Não autorizado",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Unauthenticated.")
     *    ),
     *  ),
     *  @OA\Response(
     *    response=404,
     *    description="Não encontrado",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Not found")
     *    ),
     *  )
     * )
     */
    public function update(Request $request, Task $task)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            // 'done' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->handleError($validator->errors());
        }

        $task->name = $input['name'];
        $task->done = $request->boolean('done', false);
        $task->save();

        return $this->handleResponse(new TaskResource($task), 'Task successfully updated!');
    }

    /**
     * @OA\Delete(
     *  tags={"Task"},
     *  summary="Lista todas as tasks",
     *  description="Lista todas as tasks",
     *  path="/api/v1/tasks/{id}",
     *  @OA\Parameter(
     *     name="id",
     *     in="path"
     *  ),
     *  @OA\Response(
     *    response=200,
     *    description="Retorna os dados de uma task",
     *    @OA\JsonContent(
     *      @OA\Property(
     *          property="message",
     *          description="Retona a mensagem de erro ou sucesso",
     *          type="string",
     *          example="Task retrieved!"
     *       ),
     *    @OA\Property(
     *         property="success",
     *         description="Retorna o status os sucesso",
     *         type="bool",
     *         example=true
     *      ),
     *      @OA\Property(property="data", type="object",
     *          example=@OA\Schema(
     *               schema="empty",
     *         ),
     *      )
     *    )
     *  ),
     *  @OA\Response(
     *    response=401,
     *    description="Não autorizado",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Unauthenticated.")
     *    ),
     *  ),
     *  @OA\Response(
     *    response=404,
     *    description="Não encontrado",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Not found")
     *    ),
     *  )
     * )
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return $this->handleResponse([], 'Task deleted!');
    }
}
