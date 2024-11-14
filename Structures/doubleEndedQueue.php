<?php

class Deque {
    private $deque;
    private $front;
    private $rear;
    private $limit;
    private $size;

    public function __construct($limit = 5) {
        $this->limit = $limit;
        $this->deque = array_fill(0, $this->limit, null); // Initialize deque with null values
        $this->front = -1;
        $this->rear = 0;
        $this->size = 0;
    }

    // Add an element to the front of the deque
    public function enqueueFront($item) {
        if ($this->isFull()) {
            echo "Deque overflow. Cannot enqueue $item at the front\n";
            return;
        }
        if ($this->isEmpty()) {
            $this->front = 0;
            $this->rear = 0;
        } else {
            $this->front = ($this->front - 1 + $this->limit) % $this->limit;
        }
        $this->deque[$this->front] = $item;
        $this->size++;
        echo "Enqueued $item at the front\n";
    }

    // Add an element to the rear of the deque
    public function enqueueRear($item) {
        if ($this->isFull()) {
            echo "Deque overflow. Cannot enqueue $item at the rear\n";
            return;
        }
        if ($this->isEmpty()) {
            $this->front = 0;
            $this->rear = 0;
        } else {
            $this->rear = ($this->rear + 1) % $this->limit;
        }
        $this->deque[$this->rear] = $item;
        $this->size++;
        echo "Enqueued $item at the rear\n";
    }

    // Remove an element from the front of the deque
    public function dequeueFront() {
        if ($this->isEmpty()) {
            echo "Deque underflow. Cannot dequeue from the front\n";
            return null;
        }
        $dequeuedItem = $this->deque[$this->front];
        $this->deque[$this->front] = null;
        if ($this->front == $this->rear) { // Queue is now empty
            $this->front = -1;
            $this->rear = -1;
        } else {
            $this->front = ($this->front + 1) % $this->limit;
        }
        $this->size--;
        echo "Dequeued $dequeuedItem from the front\n";
        return $dequeuedItem;
    }

    // Remove an element from the rear of the deque
    public function dequeueRear() {
        if ($this->isEmpty()) {
            echo "Deque underflow. Cannot dequeue from the rear\n";
            return null;
        }
        $dequeuedItem = $this->deque[$this->rear];
        $this->deque[$this->rear] = null;
        if ($this->front == $this->rear) { // Queue is now empty
            $this->front = -1;
            $this->rear = -1;
        } else {
            $this->rear = ($this->rear - 1 + $this->limit) % $this->limit;
        }
        $this->size--;
        echo "Dequeued $dequeuedItem from the rear\n";
        return $dequeuedItem;
    }

    // Check if the deque is empty
    public function isEmpty() {
        return $this->size == 0;
    }

    // Check if the deque is full
    public function isFull() {
        return $this->size == $this->limit;
    }

    // Display all elements in the deque
    public function display() {
        if ($this->isEmpty()) {
            echo "Deque is empty\n";
            return;
        }
        echo "Deque elements: ";
        for ($i = 0; $i < $this->limit; $i++) {
            echo ($this->deque[$i] === null ? "-" : $this->deque[$i]) . " ";
        }
        echo "\n";
    }
}

// Example usage
$deque = new Deque(5);

$deque->enqueueRear(10);
$deque->enqueueRear(20);
$deque->enqueueFront(5);
$deque->enqueueFront(2);
$deque->display();

$deque->dequeueFront();
$deque->display();

$deque->dequeueRear();
$deque->display();

$deque->enqueueFront(1);
$deque->enqueueRear(30);
$deque->enqueueRear(40); // Should indicate overflow
$deque->display();