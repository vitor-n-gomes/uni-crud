<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    /**
     * Instantiate a new EmployeeController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new Employee.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        
        $this->validate($request, [
            'occupation' => ['required', 'max:128']
        ]);

        try {

            $oEmployee = new Employee;
            $oEmployee->occupation = $request->input('occupation');
            $oEmployee->status = true;

            $oUser = Auth::user();

            if (!$employee = $oUser->employee()->save($oEmployee)) throw new \Exception("Houve um erro na criação do colaborador", 500);

            return response()->json(['employee' => $employee, 'message' => 'Colaborador criado com sucesso'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Update a employee.
     *
     * @param  Request  $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        
        $this->validate($request, [
            'occupation' => ['required', 'max:128']
        ]);

        try {

            $oEmployee = Employee::find($id);
            $oEmployee->occupation = $request->input('occupation');
            $oEmployee->status = true;

            if (!$oEmployee->save()) throw new \Exception("Houve um erro na alteração do colaborador", 500);

            return response()->json(['employee' => $oEmployee, 'message' => 'Colaborador alterado com sucesso'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
