<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/11/2016
 * Time: 1:46 PM
 */

namespace Acme\Helper;


trait StateHelper
{
    protected $states = ['Alaska', 'Arkansas', 'California', 'Connecticut', 'Delaware', 'Georga', 'Idaho', 'Indiana', 'Iowa', 'Kentucky',
        'Louisiana', 'Maryland', 'Massachusetts', 'Mississippi', 'Montana', 'Nevada', 'New Hampshire', 'New Jersey', 'North Carolina', 'North Dakota',
        'Ohio', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Dakota', 'Tennessee', 'Utah', 'Vermont', 'Virginia', 'West Virginia'];

    public function getStates(){
        return $this->states;
    }
}