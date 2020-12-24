<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentResourceController extends Controller
{
    private $payment;
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $paymentType = $request->has('paymentType') ? $request->input('paymentType') : 1;
        return view('admin.payment.index', compact('paymentType'));
    }

    public function list(Request $request)
    {
        $paymentType = $request->has('paymentType') ? $request->input('paymentType') : 1;
        $payments = $this->payment->where('type_id', '=', $paymentType)->orderBy('order', 'asc')->get()->toArray();
        if ($payments) {
            return response()->json([
                'payments' => $payments,
                'status' => 'success'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Load Failed',
                'status' => 'success'
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $attr = $request->all();
        $payment = $this->payment->create($attr);
        if ($payment) {
            return response()->json([
                'message' => trans('message.success.created', ['Module' => trans('payment::payment.name')]),
                'status' => 'success'
            ], 200);
        } else {
            return response()->json([
                'message' => trans('message.error.deleted', ['Module' => trans('payment::payment.name')]),
                'status' => 'error'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        if ($request->has('type') && $request->input('type') === 'json') {
            $payment = $this->payment->find($id)->toArray();
            return response()->json([
                'payment' => $payment,
                'status' => 'success'
            ], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        if ($request->has('type') && $request->input('type') === 'json') {
            $attr = $request->all();
            $payment = $this->payment->find($id);
            $result = $payment->update($attr);
            if ($result) {
                return response()->json([
                    'message' => trans('message.success.updated', ['Module' => trans('payment::payment.name')]),
                    'status' => 'success'
                ], 200);
            } else {
                return response()->json([
                    'message' => trans('message.error.updated', ['Module' => trans('payment::payment.name')]),
                    'status' => 'error'
                ], 500);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->has('type') && $request->input('type') === 'json') {
            $payment = $this->payment->find($id);
            $result = $payment->delete();
            if ($result) {
                return response()->json([
                    'message' => trans('message.success.deleted', ['Module' => trans('payment::payment.name')]),
                    'status' => 'success'
                ], 200);
            } else {
                return response()->json([
                    'message' => trans('message.error.deleted', ['Module' => trans('payment::payment.name')]),
                    'status' => 'error'
                ], 500);
            }
        }
    }

    public function savePosition(Request $request)
    {
        if (!$request->has('order')) {
            return response()->json([
                'message' => trans('message.error.position'),
                'status' => 'error'
            ], 500);
        }
        $order = $request->input('order');
        foreach ($order as $key => $pos) {
            $payment = $this->payment->find($pos);
            $payment->update([
                'order' => $key
            ]);
        }
        return response()->json([
            'message' => trans('message.success.position'),
            'status' => 'success'
        ], 200);
    }

    public function statistical(Request $request)
    {
        $payment_id = $request->has('payment_id') ? $request->input('payment_id') : 1;
        return view('admin.payment.statistical', compact('payment_id'));
    }

}
