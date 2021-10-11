<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Employee;

class TodoController extends Controller
{
    /**
     * Instantiate a new TodoController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new Todo.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        
        $this->validate($request, [
            'description' => ['required', 'min:30'],
            'owner_id' => ['required'],
            'in_charge_id' => ['required']
        ]);

        try {

            $oTodo = new Todo;
            $oTodo->description = $request->input('description');
            $oTodo->in_charge_id = $request->input('in_charge_id');
            $oTodo->done = false;

            $oUser = Auth::user();

            $employee = $oUser->employee()->find($request->input('owner_id'));

            if (!$Todo = $employee->task()->save($oTodo)) throw new \Exception("Houve um erro na criação da tarefa", 500);

            return response()->json(['todo' => $Todo, 'message' => 'Tarefa criada com sucesso'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Update a Todo.
     *
     * @param  Request  $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        
        $this->validate($request, [
            'description' => ['required', 'min:30'],
            'in_charge_id' => ['required']
        ]);

        try {

            $oTodo = Todo::find($id);
            $oTodo->description = $request->input('description');
            $oTodo->in_charge_id = $request->input('in_charge_id');
            $oTodo->done = false;

            if (!$Todo = $oTodo->save()) throw new \Exception("Houve um erro na alteração do status da tarefa", 500);

            return response()->json(['todo' => $Todo, 'message' => 'Alteração de status feita  com sucesso'], 201);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }


    /**
     * todo status
     *
     * @param  Request  $request
     * @return Response
     */
    public function status(Request $request, $id)
    {
        
        $this->validate($request, [
            'done' => ['required']
        ]);

        try {

            $oTodo = Todo::find($id);
            $oTodo->done = $request->input('done');

            if (!$Todo = $oTodo->save()) throw new \Exception("Houve um erro na alteração do status da tarefa", 500);

            return response()->json(['todo' => $Todo, 'message' => 'Alteração de status feita  com sucesso'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

     /**
     * todo my tasks
     *
     * @param  Request  $request
     * @return Response
     */
    public function myTasks($id)
    {

        try {

            $oEmployee = Employee::find($id);

            $aTodo = $oEmployee->task()->all();

            if (!count($aTodo)) throw new \Exception("Não existem tarefas", 500);

            return response()->json(['todo' => $aTodo, 'message' => 'Tarefas criadas por você'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

   
     /**
     * todo my day
     *
     * @param  Request  $request
     * @return Response
     */
    public function myDay($id)
    {

        try {

            $oEmployee = Employee::find($id);

            $aTodo = array(); 
            foreach($oEmployee->todo as $todo){
                $aTodo[] = $todo;
            }
    
            if (!count($aTodo)) throw new \Exception("Não existem tarefas", 500);

            return response()->json(['todo' => $aTodo, 'message' => 'Tarefas criadas para você trabalhar'], 201);
        } catch (\Exception $e) {
   
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

}
