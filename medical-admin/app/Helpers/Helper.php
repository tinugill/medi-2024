<?php
//for notification count
function notificationCount()
{
  $notificationCount = App\Models\Notifications::all()->where('status', 0)->count();
  return $notificationCount;
}
//for notification details
function notification()
{
  $notificationsMsg = App\Models\Notifications::where('status', 0)->get();;
  return $notificationsMsg;
}
//for get admin name
function getAdminName()
{
  $adminName = App\Models\Admin::select('name', 'profile_image')->first();
  return $adminName;
}

function successResponse($msg, $data = [], $code = 200)
{
  $resData['status'] = true;
  $resData['message'] = $msg;
  $resData['data'] = $data;
  $resData['code'] = $code;
  return response()->json($resData);
}

// return fail response function
function failResponse($msg, $data = [], $code)
{
  $resData['status'] = false;
  $resData['message'] = $msg;
  $resData['data'] = (object)$data;
  $resData['code'] = $code;
  return response()->json($resData);
}

//save authorized access token
function saveAccessToken($access_token, $user_id)
{
  \DB::table('users')->where('id', $user_id)->update(['access_token' => $access_token]);
  return true;
}

//upload base64 encoded image
function uploadImage($upload_dir, $image, $dir, $sub_dir)
{
  $file_name = '';
  if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
    chmod(public_path() . '/' . $dir, 0777);
    chmod(public_path() . '/' . $dir . '/' . $sub_dir . '/', 0777);
  }
  if (is_dir($upload_dir)) {
    preg_match("/^data:image\/(.*);base64/i", $image, $match);
    if (!empty($match[1])) {
      $extension = $match[1];
    } else {
      $extension = 'jpeg';
    }
    $img_parts = str_replace('data:image/' . $extension . ';base64,', '', $image);
    $image_base64 = base64_decode($img_parts);
    $file_name = uniqid() . '.' . $extension;
    $file = $upload_dir . $file_name;
    file_put_contents($file, $image_base64);
  }
  return $file_name;
}
function sendOtp($lastInserted, $type)
{
  $otp = rand(100000, 999999);
  $otp = 123456;
  $insertId = \DB::table('otps')->insertGetId(['uid' => $lastInserted, 'otp' => $otp, 'type' => $type]);

  return $insertId;
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

  $png_url = "d-" . rand(1000, 100000) . time() . "." . $image_type;
  $path = public_path() . '/' . $folder . '/' . $png_url;

  $base_decode64 = base64_decode(str_replace(' ', '+', $image_source[1]));
  if (file_put_contents($path, $base_decode64)) {
    return array('status' => true, 'file_name' => $png_url, 'type' => $image_type);
  } else {
    return array('status' => false, 'file_name' => 'Error', 'type' => '');
  }
}
