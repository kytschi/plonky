<?php
/**
 * Plonky
 *
 * @package     Plonky\Plonky
 * @author 		Mike Welsh
 * @copyright   2023 Mike Welsh
 * @version     0.0.1
 *
 * Copyright 2023 Mike Welsh
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Library General Public
 * License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Library General Public License for more details.
 *
 * You should have received a copy of the GNU Library General Public
 * License along with this library; if not, write to the
 * Free Software Foundation, Inc., 51 Franklin St, Fifth Floor,
 * Boston, MA  02110-1301, USA.
 */
use Plonky\Plonky;
use Plonky\Exceptions\Exception;

function response($url, $message = 'Here is the demo response', $data = [])
{
    $response = new \stdClass();
    $response->copyright = '(c)' . date('Y') . ' Kytschi';
    $response->website = ($_SERVER['HTTPS'] ? 'https' : 'http') . '://' . $_SERVER['SERVER_NAME'];
    $response->verion = '0.0.1';
    $response->code = 200;
    $response->message = $message;
    $response->query = $url;
    $response->data = $data;
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
    die();
}

function genUser($id = null, $data = [])
{
    if (!$id) {
        $id = uniqid();
    }
    $user = new \stdClass();
    $user->id = $id;
    $user->username = !empty($data['username']) ? $data['username'] : 'demo';
    $user->first_name = !empty($data['first_name']) ? $data['first_name'] : 'Demo';
    $user->last_name = !empty($data['last_name']) ? $data['last_name'] : 'Demo';
    $user->email = !empty($data['email']) ? $data['email'] : 'hello@kytschi.com';
    $user->created_at = '2023-04-06 12:00:45';
    $user->updated_at = date('Y-m-d H:i:s');

    return $user;
}

try {
    //Test api.
    if (strpos($_SERVER['REQUEST_URI'], '/api/') !== false) {
        if (strpos($_SERVER['REQUEST_URI'], '/postcodes/') !== false) {
            $data = [];
            $postcode = new \stdClass();
            $postcode->city = 'Demo City';
            $postcode->county = 'Demo County';
            $postcode->postcode = urlencode(strip_tags(str_replace('/api/postcodes/', '', $_SERVER['REQUEST_URI'])));
            $postcode->country = 'UK';
            for ($iLoop = 1; $iLoop <= 20; $iLoop++) {
                $tmp = clone $postcode;
                $tmp->address_line_1 = $iLoop . ' Demo St';
                $data[] = $tmp;
            }
            response(
                $_SERVER['REQUEST_URI'],
                'results for postcode lookup',
                $data
            );
        } elseif (strpos($_SERVER['REQUEST_URI'], '/users/add') !== false) {
            response(
                $_SERVER['REQUEST_URI'],
                'user successfully created',
                genUser(null, $_POST)
            );
        } elseif (strpos($_SERVER['REQUEST_URI'], '/users/update/') !== false) {
            response(
                $_SERVER['REQUEST_URI'],
                'user successfully updated',
                genUser(
                    urlencode(strip_tags(str_replace('/api/users/update/', '', $_SERVER['REQUEST_URI']))),
                    $_POST
                )
            );
        } elseif (strpos($_SERVER['REQUEST_URI'], '/users/delete/') !== false) {
            response(
                $_SERVER['REQUEST_URI'],
                'user successfully deleted',
                []
            );
        } elseif (strpos($_SERVER['REQUEST_URI'], '/users/notifications/') !== false) {
            $data = [];
            $message = new \stdClass();
            $message->created_at = '2023-04-06 12:00:45';
            $message->updated_at = '2023-04-06 12:00:45';
            for ($iLoop = 1; $iLoop <= 20; $iLoop++) {
                $tmp = clone $message;
                $tmp->message = $iLoop . ' message';
                $data[] = $tmp;
            }
            response(
                $_SERVER['REQUEST_URI'],
                'user notifications',
                $data
            );
        } elseif (strpos($_SERVER['REQUEST_URI'], '/users') !== false) {
            if (!empty($_SERVER['REQUEST_METHOD'])) {
                if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                    response(
                        $_SERVER['REQUEST_URI'],
                        'invalid method'
                    );
                }
            }
            response(
                $_SERVER['REQUEST_URI'],
                'users found',
                genUser(null, $_POST)
            );
        }
    } else {
        /**
         * projects_folder => if not supplied the default is the projects folder.
         *
         * ssl_validation =>    perform validation on the SSL certification of the url.
         *                      By default this is enabled (true) to disable set it to false.
         *
         * save_mode => enable (true) or disable (false) the ability to save or not. Handy if you just want people 
         *              to be able to hit up your API without being able to take the actual 
         *              project's data.
         *              By default this is disabled.
         *
         * demo_mode => enable (true) or disable (false) demo mode which means you can not hit any live urls and 
         *              the response data will be demo data.
         *              By default this is disabled.
         */
        new Plonky(
            [
                'projects_folder' => '../projects',
                'ssl_validation' => false,
                'save_mode' => false,
                'demo_mode' => true
            ]
        );
    }
} catch (\Exception $err) {
    (new Exception($err->getMessage()))->fatal();
}
