<?php

if (! function_exists('generateUuid')) {
    function generateUuid()
    {
        return \Ramsey\Uuid\Uuid::uuid1()->toString();
    }
}

if (! function_exists('isIntegrationEnabled')) {
    function isIntegrationEnabled()
    {
        return env('INTEGRATION', false);
    }
}
if (! function_exists('isBoolean')) {
    function isBoolean($value)
    {
        return $value == 1 ? true : false;
    }
}

if (! function_exists('convertToBool')) {
    function convertToBool($value)
    {
        return $value == true ? 1 : 0;
    }
}
if (! function_exists('logActivity')) {
    function logActivity($model,$user, array $properties, $logMessage)
    {
        activity()
            ->performedOn($model)
            ->causedBy($user)
            ->withProperties($properties)
            ->log($logMessage);
    }
}

if (! function_exists('random_color_part')) {
    function random_color_part()
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }
}
if (! function_exists('random_color')) {
    function random_color()
    {
        return '#' . random_color_part() . random_color_part() . random_color_part();
    }
}
if (! function_exists('generate_color')) {
    function generate_color($number)
    {
        $color = [];
        for ($i = 0; $i < $number; ++$i) {
            $color[] = random_color();
        }

        return $color;
    }
}

if (! function_exists('human_filesize')) {
    function human_filesize($filesize, $decimals = 2)
    {
        $size   = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $factor = floor((strlen($filesize) - 1) / 3);

        return sprintf("%.{$decimals}f", $filesize / pow(1024, $factor)) . @$size[$factor];
    }
}

if (! function_exists('validateDate')) {
    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }
}

if (! function_exists('validateEmail')) {
    function validateEmail($email)
    {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }
}

if (! function_exists('randomPassword')) {
    function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, count($alphabet)-1);
            $pass[$i] = $alphabet[$n];
        }
        return $pass;
    }
}

if (! function_exists('getMapMarker')) { //get array of branch
    function getMapMarker($arr) {
        $count = count($arr);
        if($count > 0 && $count<2){
            // this is normal
            if($arr[0] == 'lgea')
                return 'http://marker1.png';
            else if($arr[0] == 'tolling')
                return 'http://marker2.png';
            else
                return 'null';
        }
        else if($count > 1){
            return 'http://marker3.png';
        }
        else { //value
            return 'null';
        }
    }
}
if (! function_exists('convertToMysqlDateTime')) { //get array of branch
    function convertToMysqlDateTime($value) {
       return date("Y-m-d H:i:s", strtotime($value));
    }
}

if (! function_exists('getMapMarkerColor')) { //get customer type.
    function getMapMarkerColor($type) {
      switch ($type) {
        case 'Customer':
            return 'green';
              break;
        case 'Prospect':
            return 'yellow';
              break;
        case 'Suspect':
            return 'red';
              break;
        default:
            return 'black';
            break;
      }
    }
}

if (! function_exists('cleanPhoneNumber')) { //get customer type.
    function cleanPhoneNumber($phoneNo) {
        //remove unnessary dash or spaces before saving
        return str_replace(["-", "–"], '', preg_replace('/[^A-Za-z0-9\-]/', '', $phoneNo));
    }
}
if (! function_exists('checkUserAccess')) { //get customer type.
    function checkUserAccess($role) {
        //if the user send multiple roles
        if(is_array($role)){
            if(auth()->user()->hasAnyRole($role)){
                return true;
            }
        }
        //if only send one role
        if(auth()->user()->hasRole(strtolower($role))){
            return true;
        }
        return false;
    }
}
if (! function_exists('randomDateInRange')) { //get customer type.
    function randomDateInRange($start_date, $end_date) {
       $min = strtotime($start_date);
        $max = strtotime($end_date);

        // Generate random number using above bounds
        $val = rand($min, $max);

        // Convert back to desired date format
        return date('Y-m-d', $val);
    }
}
if (! function_exists('setApiResponse')) { //get customer type.
    function setApiResponse($category,$type=null,$param = null) {
        $info = [];
        if($category == 'success'){
            switch($type){
                case 'created' : $info = ['successfully new create new '.$param,201];
                break;
                case 'updated' : $info = ['successfully update '.$param,200];
                break;
                case 'deleted' : $info = ['successfully delete '.$param,200];
                break;
                case 'comment' : $info = ['successfully create new comment',201];
                break;
                case 'update-password' : $info = ['successfully update password',200];
                break;
                case 'like' : $info = ['successfully like the newsboard',200];
                break;
                case 'unlike' : $info = ['successfully unlike the newsboard',200];
                break;
                case 'deleteComment' : $info = ['successfully deleted the comment',204];
                break;
                case 'favourite' : $info = ['successfully favourite the newsboard',200];
                break;
                case 'unfavourite' : $info = ['successfully unfavourite the newsboard',200];
                break;
                case 'message' : $info = ['successfully send the message',200];
                break;
                default : $info = ['Something missing.',404];
                break;
            }
        }else if($category == 'error'){
            switch($type){
                case 'created' : $info = ['failed to create new '.$param, 404];
                break;
                case 'updated' : $info = ['failed to update '.$param , 404];
                break;
                case 'deleted' : $info = ['failed to delete '.$param , 404] ;
                break;
                case 'access' : $info = ['you\'re not authorize to use this '.$param , 404] ;
                break;
                default : $info = ['Something missing.',404];
                break;
            }
        }else{
            $info = ['Something went wrong',404];
        }

        $response = [
            "status" => $category,
            "message" => $info[0]
        ];

        return response()->json($response,$info[1]);

    }
}

