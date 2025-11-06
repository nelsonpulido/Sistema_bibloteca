<?php

namespace App\Services;

use App\Models\Empleado;

class EmpleadoService
{
    public function getAll()
    {
        return Empleado::all();
    }

    public function create(array $data)
    {
        return Empleado::create($data);
    }

    public function update($id, array $data)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->update($data);
        return $empleado;
    }

    public function delete($id)
    {
        $empleado = Empleado::findOrFail($id);
        return $empleado->delete();
    }
}

}
