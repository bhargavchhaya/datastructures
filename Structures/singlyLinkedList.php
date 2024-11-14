<?php

// Node class to represent each element in the linked list
class Node {
    public $data;
    public $next;

    public function __construct($data) {
        $this->data = $data;
        $this->next = null;
    }
}

// LinkedList class to manage the linked list
class LinkedList {
    private $head;

    public function __construct() {
        $this->head = null;
    }

    // Insert a node at the beginning of the list
    public function insertAtBeginning($data) {
        $newNode = new Node($data);
        $newNode->next = $this->head;
        $this->head = $newNode;
        echo "Inserted $data at the beginning\n";
    }

    // Insert a node at the end of the list
    public function insertAtEnd($data) {
        $newNode = new Node($data);
        if ($this->head === null) {
            $this->head = $newNode;
        } else {
            $current = $this->head;
            while ($current->next !== null) {
                $current = $current->next;
            }
            $current->next = $newNode;
        }
        echo "Inserted $data at the end\n";
    }

    // Insert a node at a specific position in the list
    public function insertAtPosition($data, $position) {
        $newNode = new Node($data);

        if ($position <= 0) {
            echo "Position should be greater than 0\n";
            return;
        }

        // Inserting at the beginning if position is 1
        if ($position === 1) {
            $this->insertAtBeginning($data);
            return;
        }

        $current = $this->head;
        $count = 1;

        // Traverse the list to find the insertion point
        while ($current !== null && $count < $position - 1) {
            $current = $current->next;
            $count++;
        }

        // If the position is beyond the end of the list
        if ($current === null) {
            echo "Position out of bounds. Adding at the end instead.\n";
            $this->insertAtEnd($data);
            return;
        }

        // Insert the new node at the specified position
        $newNode->next = $current->next;
        $current->next = $newNode;
        echo "Inserted $data at position $position\n";
    }

    // Display the entire list
    public function display() {
        if ($this->head === null) {
            echo "List is empty\n";
            return;
        }
        echo "Linked List: ";
        $current = $this->head;
        while ($current !== null) {
            echo $current->data . " -> ";
            $current = $current->next;
        }
        echo "NULL\n";
    }
}

// Example usage
$linkedList = new LinkedList();

$linkedList->insertAtEnd(10);
$linkedList->insertAtEnd(20);
$linkedList->insertAtEnd(30);
$linkedList->insertAtEnd(40);
$linkedList->display();

$linkedList->insertAtPosition(25, 3); // Insert 25 at position 3
$linkedList->display();

$linkedList->insertAtPosition(5, 1);  // Insert 5 at position 1 (beginning)
$linkedList->display();

$linkedList->insertAtPosition(50, 10); // Insert 50 at position 10 (out of bounds, so add to end)
$linkedList->display();
