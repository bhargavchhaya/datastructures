<?php

// Node class to represent each element in the doubly linked list
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

// DoublyLinkedList class to manage the doubly linked list
class DoublyLinkedList {
    private $head;

    public function __construct() {
        $this->head = null;
    }

    // Insert a node at the beginning of the list
    public function insertAtBeginning($data) {
        $newNode = new Node($data);
        if ($this->head !== null) {
            $this->head->prev = $newNode;
        }
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
            $newNode->prev = $current;
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

        while ($current !== null && $count < $position - 1) {
            $current = $current->next;
            $count++;
        }

        if ($current === null) {
            echo "Position out of bounds. Adding at the end instead.\n";
            $this->insertAtEnd($data);
        } else {
            $newNode->next = $current->next;
            if ($current->next !== null) {
                $current->next->prev = $newNode;
            }
            $current->next = $newNode;
            $newNode->prev = $current;
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

        // If the node to be deleted is the head node
        if ($current->data === $data) {
            $this->head = $current->next;
            if ($this->head !== null) {
                $this->head->prev = null;
            }
            echo "Deleted $data from the list\n";
            return;
        }

        // Traverse the list to find the node to delete
        while ($current !== null && $current->data !== $data) {
            $current = $current->next;
        }

        if ($current === null) {
            echo "$data not found in the list\n";
        } else {
            if ($current->next !== null) {
                $current->next->prev = $current->prev;
            }
            if ($current->prev !== null) {
                $current->prev->next = $current->next;
            }
            echo "Deleted $data from the list\n";
        }
    }

    // Display the list from the beginning
    public function displayFromBeginning() {
        if ($this->head === null) {
            echo "List is empty\n";
            return;
        }
        echo "Doubly Linked List (from beginning): ";
        $current = $this->head;
        while ($current !== null) {
            echo $current->data . " <-> ";
            $current = $current->next;
        }
        echo "NULL\n";
    }

    // Display the list in reverse
    public function displayInReverse() {
        if ($this->head === null) {
            echo "List is empty\n";
            return;
        }
        
        // Traverse to the end of the list
        $current = $this->head;
        while ($current->next !== null) {
            $current = $current->next;
        }

        echo "Doubly Linked List (in reverse): ";
        while ($current !== null) {
            echo $current->data . " <-> ";
            $current = $current->prev;
        }
        echo "NULL\n";
    }
}

// Example usage
$doublyLinkedList = new DoublyLinkedList();

$doublyLinkedList->insertAtEnd(10);
$doublyLinkedList->insertAtEnd(20);
$doublyLinkedList->insertAtBeginning(5);
$doublyLinkedList->insertAtEnd(30);
$doublyLinkedList->displayFromBeginning();

$doublyLinkedList->insertAtPosition(25, 3); // Insert 25 at position 3
$doublyLinkedList->displayFromBeginning();

$doublyLinkedList->deleteNode(20);
$doublyLinkedList->displayFromBeginning();

$doublyLinkedList->displayInReverse();