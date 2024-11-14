<?php

class Queue {
    private $queue;
    private $limit;

    public function __construct($limit = 10) {
        // Initialize the queue array and set a limit
        $this->queue = [];
        $this->limit = $limit;
    }

    // Enqueue an element to the queue
    public function enqueue($item) {
        if (count($this->queue) < $this->limit) {
            array_push($this->queue, $item);
            echo "Enqueued: $item\n";
        } else {
            echo "Queue overflow. Cannot enqueue $item\n";
        }
    }

    // Dequeue an element from the queue
    public function dequeue() {
        if ($this->isEmpty()) {
            echo "Queue underflow. Cannot dequeue\n";
            return null;
        } else {
            $dequeuedItem = array_shift($this->queue);
            echo "Dequeued: $dequeuedItem\n";
            return $dequeuedItem;
        }
    }

    // Get the front element of the queue
    public function front() {
        if ($this->isEmpty()) {
            echo "Queue is empty. Nothing at the front\n";
            return null;
        } else {
            return $this->queue[0];
        }
    }

    // Check if the queue is empty
    public function isEmpty() {
        return empty($this->queue);
    }

    // Display all elements in the queue
    public function display() {
        if ($this->isEmpty()) {
            echo "Queue is empty\n";
        } else {
            echo "Queue elements: ";
            foreach ($this->queue as $item) {
                echo $item . " ";
            }
            echo "\n";
        }
    }
}

// Example usage
$queue = new Queue(5);

$queue->enqueue(10);
$queue->enqueue(20);
$queue->enqueue(30);
$queue->display();

echo "Front element is: " . $queue->front() . "\n";

$queue->dequeue();
$queue->display();

$queue->enqueue(40);
$queue->enqueue(50);
$queue->enqueue(60);
$queue->enqueue(70); // This should trigger an overflow
$queue->display();
