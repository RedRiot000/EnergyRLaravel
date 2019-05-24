<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //
    public function index()
    {
        $payments = auth()->user()->payments;

        return response()->json([
            'success' => true,
            'data' => $payments
        ]);
    }

    public function show($id)
    {
        $payment = auth()->user()->payments()->find($id);

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'payment with id ' . $id . ' not found'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $payment->toArray()
        ], 400);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'month' => 'required',
            'status' => 'required',
            'year' => 'required|integer',
            'units' => 'required',
            'assessment_date' => 'required',
        ]);

        $payment = new Payment($request->all());
        $payment->user_id = auth()->user()->id;

        if (auth()->user()->payments()->save($payment))
            return response()->json([
                'success' => true,
                'data' => $payment->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Payment could not be added'
            ], 500);
    }

    public function update(Request $request, $id)
    {
        $payment = auth()->user()->payments->find($id);

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $payment->fill($request->all())->save();

        if ($updated)
            return response()->json([
                'success' => true
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Payment could not be updated'
            ], 500);
    }

    public function destroy($id)
    {
        $payment = auth()->user()->payments->find($id);

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment with id ' . $id . ' not found'
            ], 400);
        }

        if ($payment->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Payment could not be deleted'
            ], 500);
        }
    }
}
