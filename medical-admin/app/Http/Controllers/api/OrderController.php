<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AmbulanceBooking;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Nursing;
use App\Models\Treatment;
use App\Models\Labtest;
use App\Models\Labtestpackage;
use App\Models\LabtestBookings;
use App\Models\BuyCart;
use App\Models\BuyCartOrderInfo;
use App\Models\Chat;
use App\Models\Meeting;
use App\Models\Appointment;
use App\Models\Zoomtoken;
use App\Models\DealerProductPurchase;
use App\Models\DealerProduct;
use App\Models\Doctor;
use App\Models\HomeCareRequest;
use App\Models\LabBookingInfoList;
use Auth;
use Hash;
use DB;

class OrderController extends Controller
{
  public function ordersHomeCare(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      $orders = array();

      $OI = DB::table('home_care_requests as b')
        ->selectRaw('b.id,b.user_id,b.procedure_id, b.date, b.type, b.book_for, b.care_id, b.price, b.address,b.city,b.payment_id, b.qty, b.id_proof, b.status, b.pincode, p.name,p.type as service_type,p.image, py.status as payment_status, py.order_id, b.created_at, pp.title, rv.stars, rv.comment,u.mobile as customer_mobile, u.name as customer_name')
        ->join('nursings as p', 'b.care_id', '=', 'p.id')
        ->leftJoin('payments as py', 'b.payment_id', '=', 'py.id')
        ->join('users as u', function ($join) {
          $join->on('b.user_id', '=', 'u.uid')->where('u.type', '=', 'User');
      })
        ->leftJoin('nursing_procedures as pp', 'b.procedure_id', '=', 'pp.id')->leftJoin("reviews as rv",  function($q) {
          $q->on('rv.service_id', '=', 'b.id');
          $q->where('rv.type', '=', 'Homecare', 'and');
        });;
      if ($user->type == 'Nursing') {
        $OI->where(function ($query) use ($user) {
          $query->where('b.care_id', $user->uid);
          $nursing = Nursing::select("id","buero_id")->where('id',$user->uid)->first();
          if($nursing->buero_id == $user->id){
            $query->orWhere('p.buero_id', $user->id); 
          } 
        }); 
       
        
      } else {
        $OI->where('b.user_id', $user->uid);
      }

      $orders = $OI->where('py.status', '!=', '')->where('b.is_deleted', '0')->orderBy('b.id', 'desc')
        ->get();

      return successResponse('Order', $orders, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function ordersDealer(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      $orders = array();
      if ($user->type == 'Dealer' || $user->type == 'Pharmacy') {
        $p = DealerProduct::where('dealer_id', $user->id)->get();
        $productArray = json_decode(json_encode($p), true);
      }
      if ((isset($p) && !empty($p)) || $user->type == 'User') {

        $OI = DB::table('dealer_product_purchases as b')
          ->selectRaw('b.id,b.image as priscription_image,b.user_id, b.type, b.product_id, b.price, b.address,b.city,b.payment_id, b.qty, b.status, b.pincode, p.dealer_id, p.item_name,p.company,p.image, p.pack_size, py.status as payment_status, py.order_id, rv.stars, rv.comment,u.mobile as customer_mobile, u.name as customer_name, p.security_for_rent')
          ->join('dealer_products as p', 'b.product_id', '=', 'p.id')
          ->join('users as u', function ($join) {
              $join->on('b.user_id', '=', 'u.uid')->where('u.type', '=', 'User');
          })
          ->leftJoin('payments as py', 'b.payment_id', '=', 'py.id')
          ->leftJoin("reviews as rv",  function($q) {
            $q->on('rv.service_id', '=', 'b.id');
            $q->where('rv.type', '=', 'Equipment', 'and');
          });
        if ($user->type == 'Dealer' || $user->type == 'Pharmacy') {
          $pids = array_column($productArray, 'id');
          $OI->whereIn('b.product_id', $pids);
        } else {
          $OI->where('b.user_id', $user->uid);
        }

        $orders = $OI->where('py.status', '!=', '')->where('b.is_deleted', '0')->orderBy('b.id', 'DESC')
          ->get();
      } else {
        $orders = [];
      }
      return successResponse('Order', $orders, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function orders(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      $orders = array();
      if ($user->type == 'Pharmacy') {
        $p = Product::where('pharmacy_id', $user->uid)->get();
      }
      if ((isset($p) && !empty($p)) || $user->type == 'User') {

        $o = DB::table('buy_carts')
          ->selectRaw('order_id,u.mobile as customer_mobile, u.name as customer_name')->where('item_type', 'product')
          ->join('users as u', 'buy_carts.user_id', '=', 'u.id')
          ->where('order_id', '!=', '')
          ->where('payment_id', '!=', '');
        if ($user->type == 'Pharmacy') {
          $myArray = json_decode(json_encode($p), true);
          $productIds = array_column($myArray, 'id');
          $o->whereIn('item_id', $productIds);
        } else {
          $o->where('user_id', $user->id);
        }
        $orderList =  $o->groupBy('order_id')->orderByDesc('buy_carts.id')
          ->get();

        $i = 0;
        foreach ($orderList as $value) {
          $OI = DB::table('buy_carts as b')
            ->selectRaw('b.id,b.order_id, b.req_date, b.record_image, b.item_id, b.item_type, b.price, b.discount,b.qty,b.payment_id, b.is_completed, p.brand_name, p.salt_name, p.manufacturer_address, p.expiry_month, p.expiry_year, p.expiry_type, p.manufacturer_name,p.slug,p.image, p.variant_name, p.mrp, p.discount, py.status as payment_status, p.title, formulations.title as formulation_name')
            ->join('products as p', 'b.item_id', '=', 'p.id')
            ->leftJoin('payments as py', 'b.payment_id', '=', 'py.id')
            ->leftJoin('formulations', 'formulations.id', '=', 'p.formulation_id')
            ->where('b.order_id', $value->order_id);
          if ($user->type == 'Pharmacy') {
            $OI->whereIn('b.item_id', $productIds);
          }

          $oInfo = $OI->where('b.item_type', 'product')->where('py.status', '!=', '')->where('b.is_deleted', '0')
            ->get();

          $infoArray['info'] = BuyCartOrderInfo::selectRaw("buy_cart_order_infos.*, rv.stars, rv.comment")->leftJoin("reviews as rv",  function($q) {
            $q->on('rv.service_id', '=', 'buy_cart_order_infos.id');
            $q->where('rv.type', '=', 'Medicine', 'and');
          })->where('order_id', $value->order_id)->where('is_deleted', '0')->first();

          $infoArray['products'] = $oInfo;
          $infoArray['order_id'] = $value->order_id;
          $infoArray['customer_name'] = $value->customer_name;
          $infoArray['customer_mobile'] = $value->customer_mobile;

          $orders[] = $infoArray;
          $i++;
        }
      }
      return successResponse('Order', $orders, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }

  public function treatmentOrder(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      $orders = array();
      

      if ($user->type == 'Doctor') {
        $p = Treatment::where('doctor_id', $user->uid)->get();
      }
      if ($user->type == 'Hospital') {
        $doctors = Doctor::where('hospital_id', $user->id)->get();

        $doctorIds = $doctors->pluck('id');
    
        $p = Treatment::whereIn('doctor_id', $doctorIds)->get();
      }
      if ((isset($p) && !empty($p)) || $user->type == 'User') {
        $o = DB::table('buy_carts')
          ->selectRaw('buy_carts.order_id, buy_carts.user_id, t.doctor_id, rv.stars, rv.comment')->where('item_type', 'treatment')->join('treatments as t', 'buy_carts.item_id', '=', 't.id')
          ->leftJoin("reviews as rv",  function($q) {
            $q->on('rv.service_id', '=', 'buy_carts.order_id');
            $q->where('rv.type', '=', 'Treatment', 'and');
          })
          ->where('buy_carts.order_id', '!=', '')
          ->where('buy_carts.payment_id', '!=', '');
        if ($user->type == 'Doctor' || $user->type == 'Hospital') {
          $myArray = json_decode(json_encode($p), true);
          $arrayProduct = array_column($myArray, 'id');
          $o->whereIn('buy_carts.item_id', $arrayProduct);
        } else {
          $o->where('buy_carts.user_id', $user->id);
        }
        $orderList = $o->groupBy('buy_carts.order_id')
          ->orderByDesc('buy_carts.id')
          ->get();

        $i = 0;
        foreach ($orderList as $value) {
          $OI = DB::table('buy_carts as b')
            ->selectRaw('b.id,b.order_id, b.req_date, b.record_image, b.item_id, b.item_type, b.price, b.discount,b.qty,b.payment_id, b.is_completed, py.status as payment_status, t.package_name, t.package_location, t.stay_type, t.charges_in_rs,t.discount_in_rs, t.charges_in_doller,t.discount_in_doller, t.details, c.name, c.email, c.mobile, d.address as a1, d.city as c1, d.pincode as p1, t.hospital_name, t.hospital_address, d.full_name as doctor_name ')
            ->join('treatments as t', 'b.item_id', '=', 't.id')
            ->leftJoin('payments as py', 'b.payment_id', '=', 'py.id')
            ->leftJoin('users as u', 'b.user_id', '=', 'u.id')
            ->leftJoin('customers as c', 'c.id', '=', 'u.uid')
            ->leftJoin('doctors as d', 't.doctor_id', '=', 'd.id')
            ->where('b.order_id', $value->order_id);
          if ($user->type == 'Doctor' || $user->type == 'Hospital') {
            $OI->whereIn('b.item_id', $arrayProduct);
          } else {
            $OI->where('b.user_id', $user->id);
          }
          $oInfo = $OI->where('b.item_type', 'treatment')->where('py.status', '!=', '')->where('b.is_deleted', '0')
            ->get();

          $infoArray['treatment'] = $oInfo;
          $infoArray['order_id'] = $value->order_id;
          $infoArray['stars'] = $value->stars;
          $infoArray['comment'] = $value->comment;
          $infoArray['user_id'] = $value->user_id;

          $orders[] = $infoArray;
          $i++;
        }
      }
      return successResponse('Order', $orders, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }

  public function homeCareOrderUpdate(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $b = HomeCareRequest::find($request->id);

      $b->status = (string)$request->status;
      $b->save();
      return successResponse('Order Updated', $b, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function ambulanceOrderUpdate(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $b = AmbulanceBooking::find($request->id);

      $b->status = (string)$request->status;
      $b->save();
      return successResponse('Request Updated', $b, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function dealerProductOrderUpdate(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $b = DealerProductPurchase::find($request->id);

      $b->status = (string)$request->status;
      $b->save();
      return successResponse('Order Updated', $b, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function productOrderUpdate(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      if ($request->type == 'item') {
        $b = BuyCart::find($request->id);
      } else {
        $b = BuyCartOrderInfo::find($request->id);
      }
      $b->is_completed = (string)$request->is_completed;
      $b->save();
      return successResponse('Order Updated', $b, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updatePharmasyEc(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $b = BuyCartOrderInfo::find($request->id);
       
      $b->delivery_boy = $request->value;
      
      $b->save();
      return successResponse('Information Updated', $b, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateLabEc(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $b = LabtestBookings::find($request->id);
      if ($request->type == 'delivery_boy') {
        $b->delivery_boy = $request->value;
      }
      if ($request->type == 'sample_collector') {
        $b->sample_collector = $request->value;
      }
       
      $b->save();
      return successResponse('Information Updated', $b, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function labtestOrderUpdate(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $b = LabtestBookings::find($request->id);
      if ($request->is_completed != '') {
        $b->is_completed = (string)$request->is_completed;
      }
      if ($request->report_file != '') {
        $upImg = $this->uploadBase64File($request->report_file, '', 'uploads');
        if ($upImg['status']) {
          $b->report_file = $upImg['file_name'];
          $b->is_completed = '2';
        }
      }
      $b->save();
      return successResponse('Order Updated', $b, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function labtestOrder(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      $o = DB::table('labtest_bookings as l')
        ->selectRaw('l.id, l.lab_id, l.is_home_collection, l.is_home_delivery, l.is_ambulance, l.price, l.h_c_price, l.delivery_boy, l.sample_collector, l.h_d_price, l.ambulance_price, l.address, l.is_completed, l.report_file,  py.status as payment_status, py.amount_paid, py.receipt, u.name as u_name, u.mobile as u_mobile, u.email as u_email, l.address as u_address, c.city as u_city, c.pincode as u_pincode, rv.stars, rv.comment, d.name as delivery_boy_name, dby.name as sample_collector_name,lb.name as lab_name, lb.address as lab_address, lb.city as lab_city, lb.phone_no as lab_number')->leftJoin("users as u", "u.id", "=", "l.user_id")->leftJoin('customers as c', 'u.uid', '=', 'c.id')
        ->leftJoin('payments as py', 'l.payment_id', '=', 'py.id')
        ->leftJoin('delivery_boys as d', 'l.delivery_boy', '=', 'd.id')
        ->leftJoin('delivery_boys as dby', 'l.sample_collector', '=', 'dby.id') 
        ->leftJoin("laboratorists as lb",  function($q) {
          $q->on('lb.id', '=', 'l.lab_id');
        })
        ->leftJoin("reviews as rv",  function($q) {
          $q->on('rv.service_id', '=', 'l.id');
          $q->where('rv.type', '=', 'Labtest', 'and');
        })->where('l.payment_id', '!=', '');
      if ($user->type == 'Lab') {
        $o->where('lab_id', $user->uid);
      } else {
        $o->where('l.user_id', $user->id);
      }
      $orderList = $o->orderByDesc('l.id')->limit(20)->get();

      
      for ($i = 0; $i < count($orderList); $i++) {
        $value = $orderList[$i]; 
        $oi = LabBookingInfoList::where('order_id',$value->id)->where('is_deleted','0')->get();
        
        $orders = array();
        for($j = 0; $j < count($oi); $j++){
          $v = $oi[$j];
          $oType = array();
          $oType['type'] = $v->type;
          if ($v->type == 'test') {
            $oType['info'] = Labtest::where('id', $v->test_id)->first();
          } else if ($v->type == 'labpackage') {
            $pkg = Labtestpackage::where('id', $v->test_id)->first();
            $myArray = json_decode($pkg->test_ids, true); 
            $oType['info'] = Labtest::whereIn('id', $myArray)->get();
            $oType['package_name'] = $pkg->package_name;
          }
          $orders[] = $oType;
        }
    
        $orderList[$i]->list = $orders; 
      }

      return successResponse('Order', $orderList, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function ambulanceOrder(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      $orders = array();
      $o = DB::table('ambulance_bookings as l')
        ->selectRaw('l.id, amb.ambulance_type, l.name, l.mobile, l.ambulance_id, l.service_ambulance_id, l.booking_type, l.date, l.booking_for, l.payment_id, l.address, l.drop_address, l.status,  py.status as payment_status, py.amount_paid, py.receipt, a.name as a_name, a.address as a_address, a.city as a_city, a.pincode as a_pincode, rv.stars, rv.comment, a.public_number, rv.id as starsID')
        ->leftJoin('ambulances as a', 'l.ambulance_id', '=', 'a.id')
        ->leftJoin('ambulance_lists as amb', 'amb.id', '=', 'l.service_ambulance_id')
        ->leftJoin('payments as py', 'l.payment_id', '=', 'py.id')
        ->leftJoin("reviews as rv",  function($q) {
          $q->on('rv.service_id', '=', 'l.id');
          $q->where('rv.type', '=', 'Ambulance', 'and');
        })
        ->where('l.payment_id', '!=', '');
      if ($user->type == 'Ambulance') {
        $o->where('l.ambulance_id', $user->uid);
      } else {
        $o->where('l.user_id', $user->id);
      }
      $orderList = $o->orderByDesc('l.id')->get();
 
      return successResponse('Order', $orderList, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
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
  public function getMessage(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      $chat = Chat::where('appointment_id', $request->id)->get();

      return successResponse('Order', $chat, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function sendMessage(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      $chat = new Chat;
      $chat->sender_type = $user->type;
      $chat->sender_id = $user->uid;
      $chat->appointment_id = $request->id;
      $chat->message = $request->msg;
      $chat->msg_type = $request->type;
      $chat->save();

      return successResponse('Order', $chat, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateMeetingSecret(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      $m = Meeting::where('id', $request->id)->first();
      $m->secret = $request->token;
      $m->save();

      return successResponse('Order', $m, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function getVideoLink(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      $chat = Chat::where('message', $request->msg)->where('id', $request->msgId)->where('appointment_id', $request->appointment_id)->first();
      if (!empty($chat)) {
        $apn = Appointment::where('id', $request->appointment_id);
        if ($user->type == 'User') {
          $apn->where('customer_id', $user->uid);
          $role = 0;
        }
        if ($user->type == 'Doctor') {
          $apn->where('doctor_id', $user->id);
          // $apn->where('doctor_id', $user->uid);
          $role = 1;
        }
        $apInfo = $apn->first();
        if (empty($apInfo)) {
          return failResponse('Invalid request : 403', [], \Config::get('constants.status_code.SUCCESS'));
        } else {
          $m = Meeting::where('id', $request->msg)->first();
          if (empty($m)) {
            return failResponse('Invalid request : MID', [], \Config::get('constants.status_code.SUCCESS'));
          } else {
            $api_key = 'ToVFoW4KRb-agbvy7RSw2g';
            $api_secret = 'VzlWICgRyf9aIFGzWHQV7SDjgiZBGdA4cfNW';

            $api_key = 'IaZ4cjjuzDD6Hwq7faEhAEu5Rx1IjWmHlzA5';
            $api_secret = 'oWnC4AkijQ8VRcmiYDFUyEJVc9QDYQ8b7Vks';
            $time = time() * 1000 - 30000; //time in milliseconds (or close enough)

            $data = base64_encode($api_key . $m->meeting_id . $time . $role);

            $hash = hash_hmac('sha256', $data, $api_secret, true);

            $_sig = $api_key . "." . $m->meeting_id . "." . $time . "." . (string)$role . "." . base64_encode($hash);

            //return signature, url safe base64 encoded
            $m->hash = rtrim(strtr(base64_encode($_sig), '+/', '-_'), '=');

            $isExist = DB::table('zoomtokens')->selectRaw('id,access_token,refresh_token')->first();
            $m->token = $isExist->access_token;
            $m->role = $role;
            $m->k = $api_key;

            return successResponse('Details', $m, \Config::get('constants.status_code.SUCCESS'));
          }
        }
      } else {
        return failResponse('Invalid request : 404', [], \Config::get('constants.status_code.SUCCESS'));
      }
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function createVideoLink(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      $meeting = $this->createNewMeet();
      if ($meeting == false) {
        $chat['iscreated'] = false;
      } else {
        $chat = new Chat;
        $chat->sender_type = $user->type;
        $chat->sender_id = $user->uid;
        $chat->appointment_id = $request->id;
        $chat->message = $meeting->id;
        $chat->msg_type = 'zoom';
        $chat->save();
        $chat->iscreated = true;
      }


      return successResponse('Order', $chat, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function zoomVerify(Request $request)
  {
    $return = $this->getToken($request->code);
    return successResponse('Order', $return, \Config::get('constants.status_code.SUCCESS'));
  }
  function createNewMeet($isSecond = false)
  {
    $getToken = Zoomtoken::where('id', 1)->first();
    if (empty($getToken) || !isset($getToken->access_token)) {
      return false;
      $this->loginAgain();
    }
    $accessToken = $getToken->access_token;

    /*Creates the endpoint URL*/
    $request_url = 'https://api.zoom.us/v2/users/me/meetings';

    //recurrence-type: 1 for daily , 2 for weekly, 3 for monthly
    //weekly_days : 1 for sunday, 7 for saturday
    //"start_time" : "'.$startDate.'T'.$time.'", 

    $newDate = date('Y-m-d H:i');
    $newDate = str_replace(' ', 'T', $newDate);
    $endDate = date('Y-m-d');
    $weeklyDay = date('l');
    $wNum = 1;
    if ($weeklyDay == 'Sunday') {
      $wNum = 1;
    }
    if ($weeklyDay == 'Monday') {
      $wNum = 2;
    }
    if ($weeklyDay == 'Tuesday') {
      $wNum = 3;
    }
    if ($weeklyDay == 'Wednesday') {
      $wNum = 4;
    }
    if ($weeklyDay == 'Thursday') {
      $wNum = 5;
    }
    if ($weeklyDay == 'Friday') {
      $wNum = 6;
    }
    if ($weeklyDay == 'Saturday') {
      $wNum = 7;
    }


    //TYPE:8 = Shedule 
    $postFields = '{"topic" : "Meeting",
                "type" : 8,                                    
                "start_time" : "' . $newDate . '",       
                "duration": "60",  
                "recurrence": {"type" : 2, "end_date_time" : "' . $endDate . 'T23:59:00", "weekly_days": "' . $wNum . '"},  
                "password" : "123456"}';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $request_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "authorization: Bearer " . $accessToken,
      "content-type: application/json"
    ));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $res = curl_exec($ch);

    /*Check for any errors*/
    $errorMessage = curl_exec($ch);
    //echo $errorMessage;
    curl_close($ch);

    if (!$res) {
      //echo "No response meeting";
      return false;
    } else {
      $response = json_decode($res, true);
    }

    if (isset($response['code']) && $response['code'] == 124 && !$isSecond) {
      $ck = $this->refreshToken();
      if ($ck != false) {
        $this->createNewMeet(true);
      } else {
        return false;
      }
    } else if (isset($response['code']) && $response['code'] == 124 && $isSecond) {
      return false;
    }
    if(!isset($response['id'])){
      return false;
    }
    $m = new Meeting;

    $m->meeting_id = $response['id'];
    $m->host_id = $response['host_id'];
    $m->host_email = $response['host_email'];
    //$m->uuid = $response['uuid'];
    $m->topic = $response['topic'];
    $m->type = $response['type'];
    $m->start_url = $response['start_url'];
    $m->join_url = $response['join_url'];

    $m->occurrences = json_encode($response['occurrences']);
    $m->password = $response['password'];

    $m->save();
    return $m;
  }
  function refreshToken()
  {

    $getToken = Zoomtoken::first();

    $refresh_token = $getToken->refresh_token;

    $request_url = 'https://zoom.us/oauth/token';

    $postFields = array(
      "grant_type" => "refresh_token",
      "refresh_token" => $refresh_token
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $request_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "authorization: Basic " . $this->getKeys(),
    ));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $res = curl_exec($ch);

    /*Check for any errors*/
    $errorMessage = curl_exec($ch);
    //echo $errorMessage;
    curl_close($ch);

    $returnData = json_decode($res, true);

    if (isset($returnData['access_token'])) {
      $isExist = DB::table('zoomtokens')->selectRaw('id,access_token,refresh_token')->first();

      if (empty($isExist)) {
        $t = new Zoomtoken;
        $t->access_token = $returnData['access_token'];
        $t->refresh_token = $returnData['refresh_token'];
        $t->save();
      } else {
        $t = Zoomtoken::find($isExist->id);
        $t->access_token = $returnData['access_token'];
        $t->refresh_token = $returnData['refresh_token'];
        $t->save();
      }
      return $returnData;
    } else {
      return $this->loginAgain();
    }
  }
  function getKeys()
  {
    return base64_encode('Oxy8lGcZRVuFZOPMqRqXxg' . ':' . 'P9Msir6kVqs79CcNTrWPnrGtIozVG2l0');
  }
  function getToken($code)
  {
    try {

      $request_url = 'https://zoom.us/oauth/token';
      $postFields = array(
        "grant_type" => "authorization_code",
        "code" => $code,
        "redirect_uri" => 'https://admin.topmedz.com/api/zoom-verify'
      );
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_URL, $request_url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "authorization: Basic " . $this->getKeys(),
      ));
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      $response = curl_exec($ch);

      /*Check for any errors*/
      $errorMessage = curl_exec($ch);
      //echo $errorMessage;
      curl_close($ch);

      $returnData = json_decode($response, true);

      if (isset($returnData['access_token'])) {
        $isExist = DB::table('zoomtokens')->selectRaw('id,access_token')->first();

        if (empty($isExist)) {
          $t = new Zoomtoken;
          $t->access_token = $returnData['access_token'];
          $t->refresh_token = $returnData['refresh_token'];
          $t->save();
        } else {
          $t = Zoomtoken::find($isExist->id);
          $t->access_token = $returnData['access_token'];
          $t->refresh_token = $returnData['refresh_token'];
          $t->save();
        }
        return $t;
      } else {
        return array('message' => "No rsponse", 'data' => $returnData);
      }
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }
  function loginAgain()
  {
    return false;
    redirect('https://zoom.us/oauth/authorize?client_id=Oxy8lGcZRVuFZOPMqRqXxg&response_type=code&redirect_uri=https%3A%2F%2Fadmin.topmedz.com%2Fzoom-verify');
  }
}
