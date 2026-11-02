<?php
namespace Tests;
abstract class TestCase extends \Illuminate\Foundation\Testing\TestCase {
 use \Illuminate\Foundation\Testing\RefreshDatabase;
 protected $seed = true;
}
