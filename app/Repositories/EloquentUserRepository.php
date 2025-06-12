<?php
namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserInterface;

class EloquentUserRepository implements UserInterface
{
  private $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }

  public function getId()
  {
    return auth()->user()->id;
  }
  
  public function getFullName()
  {
    return auth()->user()->first_name . ' ' . auth()->user()->last_name;
  }

  public function isActive()
  {
    return auth()->user()->is_active;
  }
}
?>