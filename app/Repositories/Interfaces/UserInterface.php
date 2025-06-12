<?php
namespace App\Repositories\Interfaces;

interface UserInterface {
  public function getId();
  public function getFullName();
  public function isActive();
}
?>