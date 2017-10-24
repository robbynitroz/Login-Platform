<?php

use App\Template;
use Illuminate\Database\Seeder;

/**
 * Class TemplateSeeder
 */
class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds for templates table using Template model.
     *
     * @return void
     */
    public function run()
    {
        //
        Template::create(
            [
                'hotel' => '1',
                'activated' => 'yes',
                'data' => json_encode(
                    [

                        'activeComponent' => 'app-login',
                        'defaultComponent' => 'app-login',
                        'media' => [
                            'src' => 'images/image.jpg',
                            'type' => 'image/jpeg',
                            'cover' => 'images/conser.jpg',
                        ],


                        'texts' => [
                            'en' => [
                                'greetingText' => 'You\'re one step away from going online',
                                'buttonText' => 'GO ONLINE HERE',
                                'policyLinkText' => 'Terms & conditions',
                                'policyBackLinkText' => '<<< Back',
                                'policyText' => '<p style="color: white">Here you will find terms and condition text<p/>',
                                'emailText' => 'Your email address here',
                                'sayTimeMorning' => 'Good morning!',
                                'sayTimeAfternoon' => 'Good afternoon!',
                                'sayTimeEvening' => 'Good evening!',
                            ]

                        ],

                        'backgroundColor' => 'background: rgba(19, 17, 17, 0.72);',
                        'hotelLogo' => 'storage/images/hotel_logo.png',
                        'policy' => array('text' => 'Terms & conditions', 'color' => 'grey', 'size' => '1rem',),
                        'greetingsTime' => array('on' => true, 'color' => 'white', 'size' => '2.4rem',),
                        'greeting' => array(
                            'color' => 'white',
                            'text' => 'You\'re one step away from going online',
                            'size' => '2rem',
                        ),
                        'button' => array(
                            'colorBackd' => '#1e2021',
                            'colorBackdHover' => '#000000',
                            'text' => 'GO ONLINE HERE',
                            'color' => '#d3e0ff',
                            'colorHover' => '#ffffff',
                            'borderColor' => '#d3e0ff',
                            'borderColorHover' => '#ffffff',
                            'hoverState' => false,
                        ),
                        'buttonIcon' => array(
                            'class' => 'fa-globe',
                            'color' => '#d3e0ff',
                            'colorHover' => '#ffffff',
                        ),
                        'littleTextColor' => array(
                            'color' => 'white',
                            'text' => 'connect and proceed to our webapp',
                        ),

                    ]
                ),

                'type'=>'login'
            ]
        );
    }
}
