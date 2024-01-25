<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ReservationResource;
use App\Http\Requests\ReservationCreateRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ReservationController extends Controller
{
    public function create(ReservationCreateRequest $request): JsonResponse {
        $data = $request->validated();
        $reservation = new Reservation();
        $reservation->fill($data);

        try {
            $table = Table::findOrFail($data['table_id']);
        } catch (ModelNotFoundException $e) {
            throw new HttpResponseException(response()->json([
                "errors" => [
                    "message" => [
                        "Sorry, table is not available!"
                    ]
                ]
            ])->setStatusCode(404));
        }

        if (!$table->isAvailable($reservation->start_time, $reservation->end_time, $reservation->guest_count)) {
           throw new HttpResponseException(response()->json([
                "errors" => [
                    "message" => [
                        "Sorry, table is not available!"
                    ]
                ]
            ])->setStatusCode(400));
        }

        try {
            DB::beginTransaction();
            $reservation->saveCustomer($data);
            $reservation->status = 'active';
            $reservation->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                "errors" => [
                    "message" => [
                        "An error occurred while processing the reservation."
                    ]
                ]
            ])->setStatusCode(500));
        }

        return (new ReservationResource($reservation))->response()->setStatusCode(201);
    }
}
