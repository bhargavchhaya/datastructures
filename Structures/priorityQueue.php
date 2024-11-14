<?php

class PriorityQueue {
    private $queue;

    public function __construct() {
        $this->queue = [];
    }

    // Enqueue an element with a specific priority
    public function enqueue($item, $priority) {
        $this->queue[] = ['item' => $item, 'priority' => $priority];
        // Sort the queue based on priority (ascending)
        usort($this->queue, function ($a, $b) {
            return $a['priority'] <=> $b['priority'];
        });
        echo "Enqueued: $item with priority $priority\n";
    }

    // Dequeue the element with the highest priority (lowest priority number)
    public function dequeue() {
        if ($this->isEmpty()) {
            echo "Priority queue underflow. Cannot dequeue\n";
            return null;
        }
        $dequeuedItem = array_shift($this->queue); // Remove the first element
        echo "Dequeued: {$dequeuedItem['item']} with priority {$dequeuedItem['priority']}\n";
        return $dequeuedItem;
    }

    // Peek at the element with the highest priority without removing it
    public function peek() {
        if ($this->isEmpty()) {
            echo "Priority queue is empty. Nothing to peek\n";
            return null;
        }
        return $this->queue[0];
    }

    // Check if the priority queue is empty
    public function isEmpty() {
        return empty($this->queue);
    }

    // Display all elements in the priority queue with their priorities
    public function display() {
        if ($this->isEmpty()) {
            echo "Priority queue is empty\n";
            return;
        }
        echo "Priority Queue elements:\n";
        foreach ($this->queue as $element) {
            echo "Item: {$element['item']}, Priority: {$element['priority']}\n";
        }
    }
}

// Example usage
$priorityQueue = new PriorityQueue();

$priorityQueue->enqueue("Task 1", 3);
$priorityQueue->enqueue("Task 2", 1);
$priorityQueue->enqueue("Task 3", 2);
$priorityQueue->display();

$priorityQueue->dequeue();
$priorityQueue->display();

$priorityQueue->enqueue("Task 4", 0); // Higher priority
$priorityQueue->display();

$priorityQueue->dequeue();
$priorityQueue->dequeue();
$priorityQueue->display();
