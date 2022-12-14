<?php
namespace App\Http\Controllers;
require('../vendor/autoload.php');

use Illuminate\Http\Request;
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;

class Configs extends Controller
{
    public function index () {

        $dataEnv = [
            // 'APP_NAME' => getenv('APP_NAME'),
            // 'APP_ENV' =>  getenv('APP_ENV'),
            // 'APP_KEY' =>  getenv('APP_KEY'),
            // 'APP_DEBUG' =>  getenv('APP_DEBUG'),
            // 'APP_URL' =>  getenv('APP_URL'),

            // 'LOG_CHANNEL' => getenv('LOG_CHANNEL'),
            // 'LOG_DEPRECATIONS_CHANNEL' => getenv('LOG_DEPRECATIONS_CHANNEL'),
            // 'LOG_LEVEL' => getenv('LOG_LEVEL'),

            'DB_CONNECTION' =>  getenv('DB_CONNECTION'),
            'DB_HOST' =>  getenv('DB_HOST'),
            'DB_PORT' =>  getenv('DB_PORT'),
            'DB_DATABASE' =>  getenv('DB_DATABASE'),
            'DB_USERNAME' =>  getenv('DB_USERNAME'),
            'DB_PASSWORD' =>  getenv('DB_PASSWORD'),
            'TOTEM_TABLE_PREFIX' =>  getenv('TOTEM_TABLE_PREFIX'),

            'MIX_PUSHER_APP_KEY' =>  getenv('MIX_PUSHER_APP_KEY'),
            'MIX_PUSHER_APP_CLUSTER' =>  getenv('MIX_PUSHER_APP_CLUSTER'),
            'MAIL_MAILER' =>  getenv('MAIL_MAILER'),
            'MAIL_HOST' =>  getenv('MAIL_HOST'),
            'MAIL_PORT' =>  getenv('MAIL_PORT'),
            'MAIL_USERNAME' =>  getenv('MAIL_USERNAME'),
            'MAIL_PASSWORD' =>  getenv('MAIL_PASSWORD'),
            'MAIL_ENCRYPTION' =>  getenv('MAIL_ENCRYPTION'),

            'ORACLE_OTM_SERVER' =>  getenv('ORACLE_OTM_SERVER'),
            'ORACLE_OTM_USERNAME' =>  getenv('ORACLE_OTM_USERNAME'),
            'ORACLE_OTM_PASSWORD' =>  getenv('ORACLE_OTM_PASSWORD'),

            'ORACLE_ERP_SERVER' =>  getenv('ORACLE_ERP_SERVER'),
            'ORACLE_ERP_USERNAME' =>  getenv('ORACLE_ERP_USERNAME'),
            'ORACLE_ERP_PASSWORD' =>  getenv('ORACLE_ERP_PASSWORD'),
        ];
        return view('config.config', ['dataEnv' => $dataEnv]);

    }

    public function update (Request $request ) {

        /**
        * Load any .env file. See /.env.example.
        */
        $dotenv = new Dotenv("./");
        try {
        $dotenv->load();
        }
        catch (InvalidPathException $e) {
        // Do nothing. Production environments rarely use .env files.
        }

        $dotenv = $request->DB_CONNECTION;

        $dotenv->overload();


        // $DB_HOST =  getenv('DB_HOST'),
        // $DB_PORT =  getenv('DB_PORT'),
        // $DB_DATABASE =  getenv('DB_DATABASE'),
        // $DB_USERNAME =  getenv('DB_USERNAME'),
        // $DB_PASSWORD =  getenv('DB_PASSWORD'),
        // $TOTEM_TABLE_PREFIX =  getenv('TOTEM_TABLE_PREFIX'),

        // $MIX_PUSHER_APP_KEY =  getenv('MIX_PUSHER_APP_KEY'),
        // $MIX_PUSHER_APP_CLUSTER =  getenv('MIX_PUSHER_APP_CLUSTER'),
        // $MAIL_MAILER =  getenv('MAIL_MAILER'),
        // $MAIL_HOST =  getenv('MAIL_HOST'),
        // $MAIL_PORT =  getenv('MAIL_PORT'),
        // $MAIL_USERNAME =  getenv('MAIL_USERNAME'),
        // $MAIL_PASSWORD =  getenv('MAIL_PASSWORD'),
        // $MAIL_ENCRYPTION =  getenv('MAIL_ENCRYPTION'),

        // $ORACLE_OTM_SERVER =  getenv('ORACLE_OTM_SERVER'),
        // $ORACLE_OTM_USERNAME =  getenv('ORACLE_OTM_USERNAME'),
        // $ORACLE_OTM_PASSWORD =  getenv('ORACLE_OTM_PASSWORD'),

        // $ORACLE_ERP_SERVER =  getenv('ORACLE_ERP_SERVER'),
        // $ORACLE_ERP_USERNAME =  getenv('ORACLE_ERP_USERNAME'),
        // $ORACLE_ERP_PASSWORD =  getenv('ORACLE_ERP_PASSWORD'),

    }
}
