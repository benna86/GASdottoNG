<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $reference_class;
    private $endpoint;

    protected function commonInit($parameters)
    {
        $this->reference_class = $parameters['reference_class'];
        if (isset($parameters['endpoint']))
            $this->endpoint = $parameters['endpoint'];
    }

    protected function errorResponse($message, $target = '')
    {
        $ret = (object)[
            'status' => 'error',
            'target' => $target,
            'message' => $message,
        ];

        DB::rollback();

        return json_encode($ret);
    }

    protected function successResponse($data = [])
    {
        $data['status'] = 'success';
        DB::commit();
        return json_encode((object)$data);
    }

    protected function commonSuccessResponse($obj)
    {
        return $this->successResponse([
            'id' => $obj->id,
            'name' => $obj->printableName(),
            'header' => $obj->printableHeader(),
            'url' => url($this->endpoint . '/' . $obj->id),
        ]);
    }

    protected function handleDirectFileUpload($request, $field, $obj)
    {
        if ($request->hasFile($field)) {
            $file = $request->file($field);
            $filename = str_random(30);
            $file->move(gas_storage_path('app'), $filename);
            $obj->$field = sprintf('app/%s', $filename);
        }
    }

    public function objhead(Request $request, $id)
    {
        $class = $this->reference_class;
        $subject = $class::findOrFail($id);
        return response()->json([
            'id' => $subject->id,
            'header' => $subject->printableHeader(),
            'url' => $subject->getShowURL()
        ]);
    }
}
