<?php

namespace App\Http\Controllers;

use App\Template;


/**
 * Class TemplateController
 * @package App\Http\Controllers
 */
class TemplateController extends Controller
{
    //

    /**
     * @var array
     */
    public $user_templates;

    /**
     * @param string $ip
     * @return array
     */
    public function getTemplate(string $ip): array
    {
        $this->user_templates = Template::getTemplate($ip);
        return $this->user_templates;
    }


}
