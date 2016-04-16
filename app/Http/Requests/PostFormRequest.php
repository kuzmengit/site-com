<?php

namespace site\Http\Requests;

use site\Http\Requests\Request;
use site\User;
use Auth;

class PostFormRequest extends Request
{
public function authorize()
{    
    if($this->user()->can_post())
    {
      return true;
    }
    return false;
}
public function rules()
{
    return [
      'title' => 'required|unique:posts|max:255',
      'title' => array('Regex:/^[A-Za-z0-9 ]+$/'),
      'body' => 'required',
    ];
}    
}