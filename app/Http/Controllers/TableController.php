<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\TableResource;
use App\Http\Requests\TableAvailRequest;
use App\Http\Requests\TableCreateRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TableController extends Controller
{
    public function store(TableCreateRequest $request): JsonResponse
    {
        $data = $request->validated();

        if(Table::where('name', $data['name'])->count() > 0){
            throw new HttpResponseException(response([
                "errors" => [
                    "name" => [
                        "the table name already exists."
                    ]
                ]
            ], 400));
        }
        $table = new Table($data);
        $table->save();

        return (new TableResource($table))->response()->setStatusCode(201);
    }

    public function getAll(Request $request):JsonResponse {
        $tables = Table::get();
        if($tables->count() < 1){
            throw new HttpResponseException(response()->json([
                "errors" => [
                    "message" => [
                        "The table list does not exist."
                    ]
                ]
            ])->setStatusCode(404));
        }

        return (TableResource::collection($tables))->response()->setStatusCode(200);
    }

    public function availability(TableAvailRequest $request):JsonResponse {
        $data = $request->validated();
        $reservations = Reservation::where('start_time', '<=', $data['end_time'])
            ->where('end_time', '>=', $data['start_time'])
            ->get();

        $tables = Table::whereNotIn('id', $reservations->pluck('table_id'))
            ->where('capacity', '>=', $data['guest_count'])
            ->get();

        $response = [
            'available' => count($tables) > 0,
            'tables' => $tables,
        ];

        return response()->json($response, 200);
    }
}
