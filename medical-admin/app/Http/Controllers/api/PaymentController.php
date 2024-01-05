<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AmbulanceBooking;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Appointment;
use App\Models\LabtestBookings;
use App\Models\BuyCart;
use App\Models\BuyCartOrderInfo;
use App\Models\DealerProduct;
use App\Models\DealerProductPurchase;
use App\Models\HomeCareRequest;
use App\Models\ServicePaymentHistory;
use App\Models\Treatment;
use App\Models\User;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use DB;
use Auth;
use Validator;

class PaymentController extends Controller
{
  public function __construct()
  {
    define("R_API_KEY", 'rzp_test_nD3visCDqsPFPX');
    define("R_API_SECRET", 'bZiG7tAAkqzK39rsJAr8wItb');
  }
  public function createOrder(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) { 
      $validator = Validator::make($request->all(), [
        'amount' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {
        $api_key = R_API_KEY;
        $api_secret = R_API_SECRET;

        $api = new Api($api_key, $api_secret);
        $orderData = [
          'receipt'         => 'AP-' . time() . rand(10, 100),
          'amount'          => $request->amount * 100, // 39900 rupees in paise
          'currency'        => 'INR'
        ];

        $res = $api->order->create($orderData);

        $payment = new Payment();
        $payment->order_id = $res->id;
        $payment->amount = $res->amount;
        $payment->amount_paid = $res->amount_paid;
        $payment->amount_due = $res->amount_due;
        $payment->currency = $res->currency;
        $payment->receipt = $res->receipt;
        $payment->status = $res->status;
        $payment->attempts = $res->attempts;
        $payment->entity = $res->entity;
        $payment->save();

        return successResponse('List',  $payment, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function razorpayResponse(Request $request)
  {

    $data = $request->all();
    $api_key = R_API_KEY;
    $api_secret = R_API_SECRET;
    $api = new Api($api_key, $api_secret);
    $orderId = $data['order_id'];
    $apiResponse = $api->order->fetch($orderId);

    // try {
    $payment = Payment::where('order_id', $orderId)->first();
    $payment->amount = $apiResponse->amount / 100;

    if ($apiResponse->amount_paid != 0) {
      $payment->amount_paid = $apiResponse->amount_paid / 100;
    } else {
      $payment->amount_paid = 0;
    }
    if ($apiResponse->amount_due != 0) {
      $payment->amount_due = $apiResponse->amount_due / 100;
    } else {
      $payment->amount_due = 0;
    }

    $payment->currency = $apiResponse->currency;
    $payment->receipt = $apiResponse->receipt;
    $payment->status = $apiResponse->status;
    $payment->attempts = $apiResponse->attempts;
    $payment->entity = $apiResponse->entity;
    $payment->save();
    if ($payment->status == 'paid') {
      if ($data['type'] == 'appointment') {
        $appointment = Appointment::where('id', $data['req_id'])->first();
        $appointment->payment_id = $payment->id;
        $appointment->save();
      } else if ($data['type'] == 'labtest') {
        $appointment = LabtestBookings::where('id', $data['req_id'])->first();
        $appointment->payment_id = $payment->id;
        $appointment->save();
      } else if ($data['type'] == 'dealer-product') {
        $appointment = DealerProductPurchase::where('id', $data['req_id'])->first();
        $appointment->payment_id = $payment->id;
        $appointment->save();
      } else if ($data['type'] == 'nursing') {
        $appointment = HomeCareRequest::where('id', $data['req_id'])->first();
        $appointment->payment_id = $payment->id;
        $appointment->save();
      } else if ($data['type'] == 'ambulance') {
        $appointment = AmbulanceBooking::where('id', $data['req_id'])->first();
        $appointment->payment_id = $payment->id;
        $appointment->save();
      } else if ($data['type'] == 'listing_treatment') {
        $rqId = json_decode($data['req_id'], true);
        $appointment = Treatment::where('id', $rqId['treatment_id'])->first();
        $appointment->is_active = '1';
        $appointment->save();
      } else if ($data['type'] == 'listing') {
        $rqId = json_decode($data['req_id'], true);
        $appointment = new ServicePaymentHistory;
        $appointment->service_id = $rqId['service_id'];
        $appointment->for_count = $rqId['for_count'];
        $appointment->coupon = $rqId['coupon'];
        $appointment->user_id = $rqId['user_id'];
        $appointment->payment_id = $payment->id;
        $appointment->order_id = $orderId;
        $appointment->from_date = date('Y-m-d');
        $appointment->end_date = date('Y-m-d', strtotime("+".$rqId['for_count']." day"));
        $appointment->save();

        $user = User::where('id', $rqId['user_id'])->first();
        $user->is_active = '1';
        $user->save();
      } else if ($data['type'] == 'cart') {
        $rqId = json_decode($data['req_id'], true);
        if (is_array($rqId) && !empty($rqId['cart_ids'])) {
          $itemIds = array(); 
          $user = Auth::guard('api')->user();
          foreach ($rqId['cart_ids'] as $value) {
            if(@$value['type'] == 'equp'){
              $info = DealerProduct::where('id', $value['id'])->where('is_deleted', '0')->first();
              $appointment = new DealerProductPurchase;
              $appointment->user_id    = $user->uid;
              $appointment->product_id    = $value['id'];
              $appointment->type    = $value['is_equp'];
              $appointment->qty    = $value['qty']; 
              $appointment->price    = ($info['mrp'] - (($info['discount']/100) * $info['mrp']) + $info['delivery_charges'])  * $value['qty'];
              $appointment->address    = $rqId['data']['address'] . ' '. $rqId['data']['locality'];
              $appointment->city    = $rqId['data']['city'];
              $appointment->pincode    = $rqId['data']['pincode']; 
              if (isset($rqId['data']['image']) && $rqId['data']['image'] != '') {
                $image = uploadBase64File($rqId['data']['image'], '', 'uploads');
                if ($image['status']) {
                  $appointment->image = $image['file_name'];
                }
              }
              $appointment->payment_id = $payment->id;
        
              $appointment->save();
            }else{
              $appointment = BuyCart::find($value);
              $appointment->order_id = $orderId;
              $appointment->payment_id = $payment->id; 
              if(isset($rqId['data']['req_date']) && $rqId['data']['req_date'] != ''){
                $appointment->req_date = $rqId['data']['req_date'];
              } 
              if(isset($rqId['data']['record_image']) &&  is_array($rqId['data']['record_image']) ){
                $file = [];
                foreach($rqId['data']['record_image'] as $img){
                  $p_reports = uploadBase64File($img, '', 'uploads');
                  if ($p_reports['status']) {
                    $file[] = $p_reports['file_name'];
                  }
                }
                $appointment->record_image = json_encode($file);
              } 
              $appointment->save();
              $itemIds[] = $appointment->id;
            }
             
          } 
          if ($user && count($itemIds) > 0) {
            $order = new BuyCartOrderInfo;
            $order->user_id = $user->uid;
            $order->payment_id = $payment->id;
            $order->payment_id = $payment->id;
            $order->order_id = $orderId;
            $order->buy_cart_items = implode(',', $itemIds);
            $order->total_amount = $rqId['total'];
            $order->total_discount = $rqId['discount'];
            $order->address = $rqId['data']['address'];
            $order->locality = $rqId['data']['locality'];
            $order->pincode = $rqId['data']['pincode'];
            $order->city = $rqId['data']['city'];
            if ($rqId['data']['image']) {
              $upImg = $this->uploadBase64File($rqId['data']['image'], '', 'uploads');
              if ($upImg['status']) {
                $order->prescription = $upImg['file_name'];
              }
            }
            $order->save();
          }
        }
      }
      if (isset($appointment)) {
        return successResponse('Payment Successful', $payment, \Config::get('constants.status_code.SUCCESS'));
      } else {
        return failResponse('Something went wrong', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }
    } else {
      return failResponse('Payment Failed', $payment, \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
    // } catch (\Exception  $th) {
    //   return failResponse('Login First To Proceed ', $th, \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    // }
  }
  public function razorpayInvoice()
  {
    $api_key = R_API_KEY;
    $api_secret = R_API_SECRET;
    $api = new Api($api_key, $api_secret);

    $billing_address['line1'] = 'address';
    $billing_address['city'] = 'city';
    $billing_address['zipcode'] = 'zipcode';
    $billing_address['state'] = 'state';
    $billing_address['country'] = 'IN';

    $line_items['name'] = 'itemname';
    $line_items['amount'] = 100;

    $sendData['type'] = 'invoice';
    $sendData['date'] = time();
    $sendData['customer'] = array('name' => 'name', 'contact' => '8447469656', 'email' => 'imchahardeepak@gmail.com', 'billing_address' => $billing_address, 'shipping_address' => $billing_address);
    $sendData['line_items'] = array($line_items);
    $sendData['email_notify'] = 1;
    $sendData['currency'] = 'INR';


    $invoice = $api->invoice->create($sendData);
    return $invoice;
  }
  function uploadBase64File($fileSource, $type = '', $folder)
  {
    $image_source = explode(";base64,", $fileSource);
    if ($type == '') {
      $image_type_aux = explode("image/", $image_source[0]);
      $image_type = @$image_type_aux[1];
    } else if ($type == 'pdf') {
      $image_type = 'pdf';
    }

    $png_url = "p-" . rand(1000, 100000) . time() . "." . $image_type;
    $path = public_path() . '/' . $folder . '/' . $png_url;

    $base_decode64 = base64_decode(str_replace(' ', '+', $image_source[1]));
    if (file_put_contents($path, $base_decode64)) {
      return array('status' => true, 'file_name' => $png_url, 'type' => $image_type);
    } else {
      return array('status' => false, 'file_name' => 'Error', 'type' => '');
    }
  }
}
