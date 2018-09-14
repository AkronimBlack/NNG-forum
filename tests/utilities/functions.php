<?php

function create($class , $atributes=[] , $times=[])
{
	return factory($class , $times)->create($atributes);
}

function make($class , $atributes=[] , $times=[])
{
	return factory($class , $times)->make($atributes);
}

