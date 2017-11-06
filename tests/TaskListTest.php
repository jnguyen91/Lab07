<?php
   use PHPUnit\Framework\TestCase;

   class TaskListTest extends TestCase
  {  
  
	private $CI;
     
    public function setUp()
    {
        $this->CI = &get_instance();
	$this->CI->load->model('Tasks');
    }
	  
    
    public function TaskListTestRule ()
    {
	   $tasks = $this->CI->Tasks->all();
	   $complete = 0;
	   $notdone = 0;
	   
	   foreach($tasks as $task)
	   {
		   if($task->status == 2) {
			   $complete++;
		   } else {
			   $notdone++;
		   }
	   }

	   $this->assertGreaterThan($complete, $notdone);
    }

  }
