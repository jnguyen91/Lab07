<?php
 class TaskTest extends TestCase
  {
    private $CI;
    public function setUp()
    {
      // Load CI instance normally
      $this->CI = &get_instance();
    }

    public function passTest()
    {
        $this->assertTrue($this->CI->tasks->setTask('ThisLab'));
        $this->assertTrue($this->CI->tasks->setSize(3));
        $this->assertTrue($this->CI->tasks->setPriority(1));
        $this->assertTrue($this->CI->tasks->setGroup(4));
    }
    
    public function failTest()
    {
        $this->assertTrue($this->CI->tasks->setTask('Nice space'));
        $this->assertTrue($this->CI->tasks->setSize(99));
        $this->assertTrue($this->CI->tasks->setPriority(100));
        $this->assertTrue($this->CI->tasks->setGroup(40432));
    }
  }