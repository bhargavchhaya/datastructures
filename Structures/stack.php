<?php

class Stack {
    private $stack;
    private $limit;

    public function __construct($limit = 10) {
        // Initialize the stack array and set a limit
        $this->stack = [];
        $this->limit = $limit;
    }

    // Push an element to the stack
    public function push($item) {
        if (count($this->stack) < $this->limit) {
            array_unshift($this->stack, $item);
            echo "Pushed: $item\n";
        } else {
            echo "Stack overflow. Cannot push $item\n";
        }
    }

    // Pop an element from the stack
    public function pop() {
        if ($this->isEmpty()) {
            echo "Stack underflow. Cannot pop\n";
            return null;
        } else {
            $poppedItem = array_shift($this->stack);
            echo "Popped: $poppedItem\n";
            return $poppedItem;
        }
    }

    // Peek at the top element of the stack
    public function peek() {
        if ($this->isEmpty()) {
            echo "Stack is empty. Nothing to peek\n";
            return null;
        } else {
            return $this->stack[0];
        }
    }

    // Check if the stack is empty
    public function isEmpty() {
        return empty($this->stack);
    }

    // Display all elements in the stack
    public function display() {
        if ($this->isEmpty()) {
            echo "Stack is empty\n";
        } else {
            echo "Stack elements: ";
            foreach ($this->stack as $item) {
                echo $item . " ";
            }
            echo "\n";
        }
    }
}

// Example usage
$stack = new Stack(5);

$stack->push(10);
$stack->push(20);
$stack->push(30);
$stack->display();

echo "Top element is: " . $stack->peek() . "\n";

$stack->pop();
$stack->display();

$stack->push(40);
$stack->push(50);
$stack->push(60);
$stack->push(70); // This should trigger an overflow
$stack->display();
