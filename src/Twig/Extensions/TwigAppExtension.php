<?php

namespace App\Twig\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Created by PhpStorm.
 * User: Georges
 * Date: 07/04/2020
 * Time: 16:38
 */
class TwigAppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('formattedProjectName', [$this, 'formattedProjectName']),
        ];
    }

    public function formattedProjectName($projectName)
    {
        $splittedData = explode(" ",$projectName);

        $formattedName = "";
        foreach($splittedData as $key => $data){

            $formattedName = $formattedName."_".$data;
        }

        return $formattedName;
    }
}