<?php



namespace App\Http\Controllers;



use App\email_templates;

use App\modules_settings;

use App\settings;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Mail;



class EmailController extends Controller

{

    public $_setting = [];



    public function __construct()

    {

        $modules_settings = settings::all();

        foreach ($modules_settings as $setting) {

            $this->_setting[$setting->field_name] = $setting->field_value;

        }





        config([

            'mail.host' => $this->_setting["email_host"],

            'mail.port' => $this->_setting["email_port"],

            'mail.encryption' => $this->_setting["email_encryption_type"],

            'mail.username' => $this->_setting["email_username"],

            'mail.password' => $this->_setting["email_password"]

        ]);





        $app = App::getInstance();



        $app->singleton('swift.transport', function ($app) {

            return new \Illuminate\Mail\TransportManager($app);

        });



        $mailer = new \Swift_Mailer($app['swift.transport']->driver());

        Mail::setSwiftMailer($mailer);

    }





    public function get_template($template_title, $template_data = [])

    {

        $template = email_templates::where("title", $template_title)->first();

        //dd($template);

        $data = $template["description"];

        if (count($template_data) > 0) {

            foreach ($template_data as $key => $val) {

                $data = str_replace('['.$key.']', $val, $data);



            }

        }

        return ["data" => $data, "subject" => $template["subject"]];

    }



    public function send()

    {

        $template_data = [];

        $template_data["username"] = "Ali";

        $template_data["ref"] = "1000022222000";

        $this->sendEmail("Update Booking", "pakingzone@gmail.com", "pakingzone@gmail.com", $template_data);

    }



    //

    public function sendEmail($template_title, $to, $template_data)

    {
     
       
        set_time_limit(0);
        //  echo ( $this->_setting["email_host"]);
        //   echo ( $this->_setting["email_port"]);
        //   echo ( $this->_setting["email_encryption_type"]);
        //     echo ( $this->_setting["email_username"]);
        //      echo ( $this->_setting["email_password"]);
        //     dd('d');
         
        // if($to == "agentbookings@flightparkone.com")
        // {
        //     dd($to);
        // }
     
       
        
        $template = $this->get_template($template_title, $template_data);

        //dd($template);

      try {

        Mail::send([], [], function ($message) use ($template, $to) {



            $message->from($this->_setting["email_username"],'Parking Zone');

            $message->to($to);

            $message->subject($template["subject"]);

            $message->setBody($template["data"], 'text/html');
          



        });
       }
       catch(\Swift_TransportException $transportExp)
       {
        //   dd($transportExp->getMessage());
        return '0';
       }





//

//         Mail::send('frontend.mails.send', ['title' => $title, 'content' => $content], function ($message)

//        {

//

//            $message->from('pakingzone@gmail.com', 'Parkingzone ');

//

//            $message->to('pakingzone@gmail.com');

//            $message->subject('Parking zone');

//

//        });





        return true;

    }


    
    public function sendEmailWithFile($template_title, $to, $template_data, $pathToFile){
        
        set_time_limit(0);  
        $template = $this->get_template($template_title, $template_data); 

        $senf = Mail::send([], [], function ($message) use ($template, $to, $pathToFile) { 
            
            $message->from($this->_setting["email_username"],'Parking Zone');

            $message->to($to);

            $message->subject($template["subject"]);

            $message->setBody($template["data"], 'text/html');
                
             $message->attach($pathToFile);

    
        });  

    }




}

