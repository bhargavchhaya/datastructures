<?php

// Node class to represent each element in the circular doubly linked list
class Node {
    public $data;
    public $next;
    public $prev;

    public function __construct($data) {
        $this->data = $data;
        $this->next = null;
        $this->prev = null;
    }
}

// CircularDoublyLinkedList class to manage the circular doubly linked list
class CircularDoublyLinkedList {
    private $head;

    public function __construct() {
        $this->head = null;
    }

    // Insert a node at the beginning of the list
    public function insertAtBeginning($data) {
        $newNode = new Node($data);

        if ($this->head === null) {
            $this->head = $newNode;
            $newNode->next = $newNode;
            $newNode->prev = $newNode;
        } else {
            $tail = $this->head->prev;

            $newNode->next = $this->head;
            $newNode->prev = $tail;
            $tail->next = $newNode;
            $this->head->prev = $newNode;
            $this->head = $newNode;
        }
        echo "Inserted $data at the beginning\n";
    }

    // Insert a node at the end of the list
    public function insertAtEnd($data) {
        $newNode = new Node($data);

        if ($this->head === null) {
            $this->head = $newNode;
            $newNode->next = $newNode;
            $newNode->prev = $newNode;
        } else {
            $tail = $this->head->prev;

            $tail->next = $newNode;
            $newNode->prev = $tail;
            $newNode->next = $this->head;
            $this->head->prev = $newNode;
        }
        echo "Inserted $data at the end\n";
    }

    // Insert a node at a specific position
    public function insertAtPosition($data, $position) {
        $newNode = new Node($data);

        if ($position <= 0) {
            echo "Position should be greater than 0\n";
            return;
        }

        if ($position === 1) {
            $this->insertAtBeginning($data);
            return;
        }

        $current = $this->head;
        $count = 1;

        while ($count < $position - 1 && $current->next !== $this->head) {
            $current = $current->next;
            $count++;
        }

        if ($count < $position - 1) {
            echo "Position out of bounds. Adding at the end instead.\n";
            $this->insertAtEnd($data);
        } else {
            $newNode->next = $current->next;
            $newNode->prev = $current;
            $current->next->prev = $newNode;
            $current->next = $newNode;
            echo "Inserted $data at position $position\n";
        }
    }

    // Delete a node by value
    public function deleteNode($data) {
        if ($this->head === null) {
            echo "List is empty. Cannot delete $data\n";
            return;
        }

        $current = $this->head;

        // Find the node to delete
        while ($current->data !== $data) {
            $current = $current->next;
            if ($current === $this->head) {
                echo "$data not found in the list\n";
                return;
            }
        }

        if ($current->next === $current) {
            // Only one node in the list
            $this->head = null;
        } else {
            $current->prev->next = $current->next;
            $current->next->prev = $current->prev;
            if ($current === $this->head) {
                $this->head = $current->next;
            }
        }
        echo "Deleted $data from the list\n";
    }

    // Display the list from the beginning
    public function displayForward() {
        if ($this->head === null) {
            echo "List is empty\n";
            return;
        }

        echo "Circular Doubly Linked List (forward): ";
        $current = $this->head;
        do {
            echo $current->data . " <-> ";
            $current = $current->next;
        } while ($current !== $this->head);
        echo "(head)\n";
    }

    // Display the list in reverse
    public function displayBackward() {
        if ($this->head === null) {
            echo "List is empty\n";
            return;
        }

        echo "Circular Doubly Linked List (backward): ";
        $tail = $this->head->prev;
        $current = $tail;
        do {
            echo $current->data . " <-> ";
            $current = $current->prev;
        } while ($current !== $tail);
        echo "(head)\n";
    }
}

// Example usage
$circularDoublyList = new CircularDoublyLinkedList();

$circularDoublyList->insertAtEnd(10);
$circularDoublyList->insertAtEnd(20);
$circularDoublyList->insertAtBeginning(5);
$circularDoublyList->insertAtEnd(30);
$circularDoublyList->displayForward();

$circularDoublyList->insertAtPosition(25, 3); // Insert 25 at position 3
$circularDoublyList->displayForward();

$circularDoublyList->deleteNode(20);
$circularDoublyList->displayForward();

$circularDoublyList->displayBackward();
?>
