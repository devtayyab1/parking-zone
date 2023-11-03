<?php
namespace App;
Form::macro('fullName', function($name)
{
    return '<p>Full name: <input type="text" name="'.$name.'"></p>';
});
?>