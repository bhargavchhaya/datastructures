<?php

class CircularQueue {
    private $queue;
    private $front;
    private $rear;
    private $size;
    private $limit;

    public function __construct($limit = 5) {
        $this->limit = $limit;
        $this->queue = array_fill(0, $this->limit, null); // Initialize queue with null values
        $this->front = -1;
        $this->rear = -1;
        $this->size = 0;
    }

    // Enqueue an element to the circular queue
    public function enqueue($item) {
        if ($this->isFull()) {
            echo "Queue overflow. Cannot enqueue $item\n";
            return;
        } else {
            if ($this->isEmpty()) {
                $this->front = 0; // Set front to the first position
            }
            $this->rear = ($this->rear + 1) % $this->limit;
            $this->queue[$this->rear] = $item;
            $this->size++;
            echo "Enqueued: $item\n";
        }
    }

    // Dequeue an element from the circular queue
    public function dequeue() {
        if ($this->isEmpty()) {
            echo "Queue underflow. Cannot dequeue\n";
            return null;
        } else {
            $dequeuedItem = $this->queue[$this->front];
            $this->queue[$this->front] = null;
            if ($this->front == $this->rear) {
                // Queue is empty after dequeuing the last element
                $this->front = -1;
                $this->rear = -1;
            } else {
                $this->front = ($this->front + 1) % $this->limit;
            }
            $this->size--;
            echo "Dequeued: $dequeuedItem\n";
            return $dequeuedItem;
        }
    }

    // Check if the queue is empty
    public function isEmpty() {
        return $this->size == 0;
    }

    // Check if the queue is full
    public function isFull() {
        return $this->size == $this->limit;
    }

    // Display all elements in the circular queue
    public function display() {
        if ($this->isEmpty()) {
            echo "Queue is empty\n";
            return;
        }
        echo "Queue elements: ";
        for ($i = 0; $i < $this->limit; $i++) {
            echo ($this->queue[$i] === null ? "-" : $this->queue[$i]) . " ";
        }
        echo "\n";
    }
}

// Example usage
$circularQueue = new CircularQueue(5);

$circularQueue->enqueue(10);
$circularQueue->enqueue(20);
$circularQueue->enqueue(30);
$circularQueue->enqueue(40);
$circularQueue->enqueue(50); // Queue is now full
$circularQueue->display();

$circularQueue->dequeue();
$circularQueue->dequeue();
$circularQueue->display();

$circularQueue->enqueue(60);
$circularQueue->enqueue(70); // Reuse dequeued positions due to circular nature
$circularQueue->display();

$circularQueue->enqueue(80); // Should indicate overflow
