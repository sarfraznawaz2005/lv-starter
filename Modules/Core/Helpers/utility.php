<?php

/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 1/15/2017
 * Time: 3:36 PM
 */

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Modules\Core\Recipients\DynamicRecipient;
use Carbon\Carbon;

function appName()
{
    return config('app.name');
}

function modulePath($moduleName)
{
    return module_path($moduleName);
}

/**
 * Enable or disable query log.
 *
 * @param bool $enable
 */
function queryLog($enable = true)
{
    if ($enable) {
        DB::connection()->enableQueryLog();
    } else {
        DB::connection()->disableQueryLog();
    }
}

/**
 * @return mixed
 * This function return last executed query in plain sql
 */
function getLastQuery()
{
    $query = DB::getQueryLog();
    $lastQuery = end($query);

    return $lastQuery;
}

/**
 * displays message on console and also appends in log
 *
 * @param $message
 * @param bool $log
 */
function out($message, $log = true)
{
    echo $message . PHP_EOL;

    if ($log) {
        Log::info($message);
    }
}

/**
 * Returns instance of logged in user.
 *
 * @return \Illuminate\Contracts\Auth\Authenticatable|\Modules\User\Models\User
 */
function user()
{
    return auth()->user();
}

/**
 * Removes given field value from request
 *
 * @param $field
 */
function removeRequestVar($field)
{
    if (is_array($field)) {
        foreach ($field as $item) {
            request()->request->remove($item);
        }
    } else {
        request()->request->remove($field);
    }
}

/**
 * Adds a new value to request
 *
 * @param $name
 * @param $value
 */
function addRequestVar($name, $value)
{
    request()->request->add([$name => $value]);
}

/**
 * Removes given field value from request if it's empty
 *
 * @param $field
 */
function removeRequestVarIfEmpty($field)
{
    if (is_array($field)) {
        foreach ($field as $item) {
            if (trim(request()->$item) === '') {
                removeRequestVar($item);
            }
        }
    } else {
        if (trim(request()->$field) === '') {
            removeRequestVar($field);
        }
    }
}

/**
 * Removes given fields from update process if they are empty.
 *
 * @param $field
 * @param $model
 */
function avoidUpdateIfEmpty($field, $model)
{
    if (is_array($field)) {
        foreach ($field as $item) {
            avoidUpdateIfEmpty($item, $model);
        }
    } else {
        if (trim(request()->$field) === '' || is_null(request()->$field)) {
            removeRequestVar($field);

            if ($field === 'password') {
                removeRequestVar('password_confirmation');
                // don't re-hash password else it will be differnt value
                $model->autoHashPasswordAttributes = false;
                // pass the validation
                $model->password_confirmation = $model->$field;
            }
        }
    }
}

/**
 * if DataTable ajax frontend gets empty serverside response, this will avoid the error
 *
 * @return string
 */
function noDataTableResponse()
{
    return json_encode([
        "sEcho" => 1,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => []
    ]);
}

function title($title = '')
{
    \Meta::set('title', $title ?: appName());
}

function sendNotification($email, $object)
{
    try {
        $recipient = new DynamicRecipient($email);
        $recipient->notify($object);
    } catch (\Exception $e) {
    }
}

function sendBroadcast($object)
{
    try {
        broadcast($object)->toOthers();
    } catch (\Exception $e) {
    }
}

/**
 * Uploads file
 *
 * @param $name
 * @param $destination
 * @param bool $overwrite
 * @return array|string
 * @internal param $rules
 */
function uploadFile($name, $destination, $overwrite = false)
{
    $errors = [];

    if (request()->has($name)) {

        // call following line from controller
        //$this->validate(request(), $rules);

        if (!File::isDirectory($destination)) {
            File::makeDirectory($destination, 493, true, true);
        }

        // clean prev files
        File::cleanDirectory($destination);

        if ($overwrite) {
            $fileName = str_slug($name) . '.' . request()->$name->getClientOriginalExtension();
        } else {
            $fileName = time() . '.' . request()->$name->getClientOriginalExtension();
        }

        $uploaded = request()->$name->move($destination, $fileName);

        if ($uploaded) {
            return $fileName;
        } else {
            $errors = ['Could not upload'];
        }
    }

    return $errors;
}

function toggleText($text, $encodeUrl = true, $key = 'abc12345')
{
    // return text unaltered if the key is blank
    if ($key == '') {
        return $text;
    }

    // remove the spaces in the key
    $key = str_replace(' ', '', $key);

    if (strlen($key) < 8) {
        exit('key error');
    }

    // set key length to be no more than 32 characters
    $key_len = strlen($key);

    if ($key_len > 32) {
        $key_len = 32;
    }

    $k = array(); // key array

    // fill key array with the bitwise AND of the ith key character and 0x1F
    for ($i = 0; $i < $key_len; ++$i) {
        $k[$i] = ord($key{$i}) & 0x1F;
    }

    // perform encryption/decryption
    for ($i = 0; $i < strlen($text); ++$i) {
        $e = ord($text{$i});
        // if the bitwise AND of this character and 0xE0 is non-zero
        // set this character to the bitwise XOR of itself
        // and the ith key element, wrapping around key length
        // else leave this character alone
        if ($e & 0xE0) {
            $text{$i} = chr($e ^ $k[$i % $key_len]);
        }
    }

    if ($encodeUrl) {
        return urlencode($text);
    }

    return $text;
}

function gravatar($email, $size = 100)
{
    $hash = md5(strtolower(trim($email)));

    $url = "https://www.gravatar.com/avatar/$hash?s=$size&r=g&d=404";

    $headers = get_headers($url, 1);

    if (substr($headers[0], 9, 3) == '200') {
        return "https://www.gravatar.com/avatar/$hash?s=$size&r=g&d=mm";
    }

    return '';
}

function saveGravatar($imgUrl, $destinationDir, $fileName = '')
{
    if (!file_exists($destinationDir)) {
        mkdir($destinationDir, 0755);
    }

    $fileName = $fileName ?: time() . '.jpg';
    $destinationDir = $destinationDir . DIRECTORY_SEPARATOR . $fileName;

    $result = copy($imgUrl, $destinationDir);

    return $result ? $fileName : false;
}

function getImageTakenDate($imagePath)
{
    if (file_exists($imagePath)) {
        @$exif = exif_read_data($imagePath);
    }

    return $exif['DateTimeOriginal'] ?? null;
}

/**
 * send email using php's mail
 *
 * @param $email
 * @param $subject
 * @param $body
 * @return bool
 */
function sendSimpleMail($email, $subject, $body)
{
    $headers = 'From: webmaster@example.com' . "\r\n" .
        'Reply-To: webmaster@example.com' . "\r\n" .
        'MIME-Version: 1.0' . "\r\n" .
        'Content-Type: text/html; charset=ISO-8859-1' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    return mail($email, $subject, $body, $headers);
}

/**
 * prints array in readable format
 *
 * @param $data
 * @param bool $exit
 */
function prettyPrint($data, $exit = true)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';

    if ($exit) {
        exit;
    }
}

if (!function_exists('money_format')) {
    function money_format($format, $number)
    {
        $regex = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?' .
            '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/';

        if (setlocale(LC_MONETARY, 0) == 'C') {
            setlocale(LC_MONETARY, '');
        }

        $locale = localeconv();

        preg_match_all($regex, $format, $matches, PREG_SET_ORDER);

        foreach ($matches as $fmatch) {
            $value = floatval($number);

            $flags = array(
                'fillchar' => preg_match('/\=(.)/', $fmatch[1], $match) ?
                    $match[1] : ' ',
                'nogroup' => preg_match('/\^/', $fmatch[1]) > 0,
                'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ?
                    $match[0] : '+',
                'nosimbol' => preg_match('/\!/', $fmatch[1]) > 0,
                'isleft' => preg_match('/\-/', $fmatch[1]) > 0
            );

            $width = trim($fmatch[2]) ? (int)$fmatch[2] : 0;
            $left = trim($fmatch[3]) ? (int)$fmatch[3] : 0;
            $right = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits'];
            $conversion = $fmatch[5];

            $positive = true;

            if ($value < 0) {
                $positive = false;
                $value *= -1;
            }

            $letter = $positive ? 'p' : 'n';
            $prefix = $suffix = $cprefix = $csuffix = $signal = '';

            $signal = $positive ? $locale['positive_sign'] : $locale['negative_sign'];

            switch (true) {
                case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+':
                    $prefix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+':
                    $suffix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+':
                    $cprefix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+':
                    $csuffix = $signal;
                    break;
                case $flags['usesignal'] == '(':
                case $locale["{$letter}_sign_posn"] == 0:
                    $prefix = '(';
                    $suffix = ')';
                    break;
            }

            if (!$flags['nosimbol']) {
                $currency = $cprefix .
                    ($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) .
                    $csuffix;
            } else {
                $currency = $cprefix . $csuffix;
            }

            $space = $locale["{$letter}_sep_by_space"] ? ' ' : '';

            $value = number_format($value, $right, $locale['mon_decimal_point'],
                $flags['nogroup'] ? '' : $locale['mon_thousands_sep']);
            $value = @explode($locale['mon_decimal_point'], $value);

            $n = strlen($prefix) + strlen($currency) + strlen($value[0]);

            if ($left > 0 && $left > $n) {
                $value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0];
            }

            $value = implode($locale['mon_decimal_point'], $value);

            if ($locale["{$letter}_cs_precedes"]) {
                $value = $prefix . $currency . $space . $value . $suffix;
            } else {
                $value = $prefix . $value . $space . $currency . $suffix;
            }

            if ($width > 0) {
                $value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ?
                    STR_PAD_RIGHT : STR_PAD_LEFT);
            }

            $format = str_replace($fmatch[0], $value, $format);
        }

        return $format;
    }
}

/**
 * @param $number
 * @return string
 */
function moneyFormat($number)
{
    if (!$number) {
        return '$0.00';
    }

    setlocale(LC_MONETARY, 'en_US.UTF-8');

    return money_format('%.2n', $number);
}

function dateRange($first, $last, $format = 'm/d/Y')
{
    $dates = [];

    $first = Carbon::parse($first);
    $last = Carbon::parse($last);

    for ($date = $first; $date->lte($last); $date->addDay()) {
        $dates[] = $date->format($format);
    }

    return $dates;
}

function DateInRange($startDate, $endDate, $date)
{
    $start_ts = strtotime($startDate);
    $end_ts = strtotime($endDate);
    $user_ts = strtotime($date);

    return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
}

/**
 * @return string
 */
function getRandomColor()
{
    $randomcolor = '#' . strtoupper(dechex(rand(0, 10000000)));

    if (strlen($randomcolor) != 7) {
        $randomcolor = str_pad($randomcolor, 10, '0', STR_PAD_RIGHT);
        $randomcolor = substr($randomcolor, 0, 7);
    }

    return $randomcolor;
}

/**
 * @param $input
 * @return string
 */
function base64UrlEncode($input)
{
    return strtr(base64_encode($input), '+/=', '-_,');
}

/**
 * @param $input
 * @return string
 */
function base64UrlDecode($input)
{
    return base64_decode(strtr($input, '-_,', '+/='));
}

/**
 * Unslugs given string eg from "foo-bar" to "Foo Bar"
 *
 * @param $text
 * @return mixed
 */
function unSlug($text)
{
    return ucwords(str_replace(['-', '_'], [' ', ' '], $text));
}

function getSql($builder)
{
    $addSlashes = str_replace('?', "'?'", $builder->toSql());

    return vsprintf(str_replace('?', '%s', $addSlashes), $builder->getBindings());
}
