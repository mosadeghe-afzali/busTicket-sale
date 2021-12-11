<?php
namespace App\Interfaces;

interface Gateway
{
    public function request($info);
    public function verify($info);
}
