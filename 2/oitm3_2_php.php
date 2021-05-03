<?php

/*
Írd meg az Answer osztályt hogy result pont 8 legyen.
 */

class Question
{
    protected $answer;
 
    public function __construct(AnswerInterface $answer)
    {
        if (!($answer instanceof AnswerInterface)) {
            throw new \InvalidArgumentException();
        } 
        $this->answer = $answer;
    }
 
	public function __invoke(){
	    return $this->answer->get()->the()->finalAnswer();
    }
}


interface AnswerInterface
{
    public function get();
    public function the();
    public function finalAnswer();
}
 
class Answer implements AnswerInterface 
{
    public function get(){ return $this; }
    public function the(){ return $this; }
    public function finalAnswer(){ return 8; }
}
 
$result = (int)(new Question(new Answer))();
var_dump($result);