<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ImageMimeTypeRule implements Rule
{
  /**
   * Create a new rule instance.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * Determine if the validation rule passes.
   *
   * @param  string  $attribute
   * @param  mixed  $value
   * @return bool
   */
  public function passes($attribute, $value): bool
  {
    if (!$value || !is_object($value) || !method_exists($value, 'getClientOriginalExtension')) {
      return false;
    }
    $allowedExtensions = array('jpg', 'jpeg', 'png', 'svg', 'gif', 'webp');
    $fileExtension = strtolower($value->getClientOriginalExtension());
    return in_array($fileExtension, $allowedExtensions);
  }

  /**
   * Get the validation error message.
   *
   * @return string
   */
  public function message(): string
  {
    return 'Only .jpg, .jpeg, .png, .webp, .svg and .gif file is allowed.';
  }
}
