<?php

namespace App\Http\Controllers;

use App\Models\PendingProfile;
use App\Models\Profile;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    private PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }


    public function index()
    {
        return inertia('Courses/CheckoutScreen');
    }


    public function create()
    {
    }



    public function store(Request $request) {
        $user = auth()->user()->id;

        // Create a pending profile for the user
        $pendingProfile = PendingProfile::create([
            'user_id' => $user,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'university' => $request->university,
            'job_title' => $request->jobTitle,
            'city' => $request->city,
        ]);

        $url = "http://127.0.0.1:8000/payment-status?profileid={$pendingProfile->id}";


        $total = 300;



        return  $this->paymentService->payment_api($request,$total,$url);

    }


    public function handlePaymentCallback(Request $request)
    {
        // Verify the payment status with the payment gateway
        $paymentStatus = $this->verifyPayment($request);

        if ($paymentStatus === 'success') {
            $id = request('profileid');
            // Retrieve the pending profile
            $pendingProfile = PendingProfile::findOrFail($id);

            // Create the final profile
            Profile::create([
                'user_id' => $pendingProfile->user_id,
                'name' => $pendingProfile->name,
                'email' => $pendingProfile->email,
                'phone' => $pendingProfile->phone,
                'university' => $pendingProfile->university,
                'job_title' => $pendingProfile->job_title,
                'city' => $pendingProfile->city,

            ]);

            // Delete the pending profile
            $pendingProfile->delete();

            return inertia('PaymentStatus', ['status' => 'success']);
        }

        return inertia('PaymentStatus', ['status' => 'failed']);
    }


    private function verifyPayment(Request $request)
    {
        // Your payment verification logic here
        // Return 'success' or 'failed' based on the payment status

        if (request('Result') == 'Successful' && request('ResponseCode') == 000) {



            return 'success';

        } else  if (request('Result') == 'Failure') {
            return 'failure';
        } else {
            return 'failure';
        }
    }



    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
